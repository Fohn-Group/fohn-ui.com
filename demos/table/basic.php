<?php

declare(strict_types=1);

use Faker\Factory;
use Fohn\Demos\DemoApp;
use Fohn\Ui\Component\Form\Control\Select;
use Fohn\Ui\Component\Table;
use Fohn\Ui\Js\Js;
use Fohn\Ui\Js\JsFunction;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Service\Theme\TwConstant;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\CodeReader(__FILE__);
$currencies = [
    'en_US' => 'USD',
    'fr_CA' => 'CAD',
    'en_GB' => 'EUR',
    'de_DE' => 'EUR',
    'it_IT' => 'EUR',
];

$locales = [
    'en_US' => 'English (USA)',
    'fr_CA' => 'Français (CA)',
    'en_GB' => 'English (GB)',
    'de_DE' => 'Dutch (DE)',
    'it_IT' => 'Italiano (IT)',
];

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());
$subtitles = [
    'Easily format cell value using formatter function.',
    'Apply Tailwinds utilities on row and/or cell base on data values.',
];
DemoApp::addPageHeaderTo($grid, 'Table component', $subtitles);
DemoApp::addGithubButton($grid);

$section = DemoApp::addInfoSection(Ui::layout(), 'Table using custom format value for columns:');

$select = Select::addTo($section, ['controlName' => 'loc_select', 'allowNull' => false, 'caption' => 'Select locale for displaying data:']);
$select->setItems($locales)->appendTailwind('md:w-1/2');

$table = Table::addTo($section, ['hasTableSearch' => false, 'hasPaginator' => false]);
$table->setCaption(DemoApp::tableCaptionFactory('Sales Report'));
$select->onChange(JsFunction::arrow([Js::var('selectLocale')])->executes([
    $table->jsDataRequest(['loc' => Js::var('selectLocale')]),
]));

// Locale get argument to table callback.
$locale = $table->stickyGet('loc', 'en_US');
$currencyCode = $currencies[$locale];
$select->setValue($locale);

$table->addColumn('name_email', Table\Column\Html::factory(['caption' => 'Name']));
// Apply specific formatter based on cell value. Formatter function must return a string.
$table->getTableColumn('name_email')->formatValue(function ($col, $value) {
    $textColor = Tw::textColor('info-light');

    return "<a href=mailto:'{$value['email']}' class='{$textColor} underline'>{$value['name']}</a>";
});

// @publish
$table->addColumn('date_publish', Table\Column\Date::factory(['caption' => 'Publish']))->alignText('center');
// Apply specific formatter based on cell value. Formatter function must return a string.
$table->getTableColumn('date_publish')->formatValue(function ($column, $value) use ($locale) {
    $fmt = \IntlDateFormatter::create(
        $locale,
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE
    );

    return $fmt->format($value);
});
// @end_publish

$table->addColumn('sales', Table\Column\Currency::factory(['caption' => 'Sales', 'isAccounting' => true, 'currencyCode' => $currencyCode]));
// Apply specific Tw css utility on sales column based on cell value.
$table->getTableColumn('sales')->applyCssCell(function ($v) {
    $tw = Tw::from([]);
    if ($v < 0) {
        $tw->merge(['text-' . TwConstant::COLORS['error-light']]);
    }

    return $tw;
});

$table->addColumn('is_director', Table\Column\Boolean::factory(['caption' => 'Director']));

$table->addColumn('tag', Table\Column\Html::factory(['caption' => 'I']))->alignText('center');
$table->getTableColumn('tag')->formatValue(function ($column, $value) {
    $tag = (new View\Tag(['textSize' => 'x-small', 'shape' => 'rounded', 'width' => '8']));
    $tag->setTextContent((string) $value);
    $tag->removeTailwind('mx-2')->removeTailwind('my-1');
    $tag->appendTailwind('mx-auto');
    $tag->color = $value > 50 ? 'primary' : 'secondary';

    return $tag->getHtml();
});

$table->applyCssRow(function (string $id, object $row) {
    $tws = Tw::from([]);
    if ($row->sales > 250000) {
        $tws->merge(['bg-' . TwConstant::COLORS['accent-light']]);
    }

    return $tws;
});

// Load fake data into table.
$table->onDataRequest(function (Table\Payload $payload, Table\Result\Set $result): void {
    $faker = Factory::create();
    $data = [];

    for ($i = 0; $i < 15; ++$i) {
        $first = $faker->firstName(random_int(0, 1) ? 'male' : 'female');
        $last = $faker->lastName;
        $name = $first . ' ' . $last;
        $email = strtolower(substr($first, 0, 1) . '.' . $last . '@salescomp.com');
        $data[] = [
            'name_email' => ['name' => $name, 'email' => $email],
            'date_publish' => $faker->dateTimeThisMonth(),
            'is_director' => $faker->optional($weight = 0.5, $default = false)->boolean(),
            'sales' => $faker->randomFloat(2, 100000, 1000000) - 500000,
            'tag' => $faker->numberBetween(0, 99),
        ];
    }

    $result->dataSet = $data;
});

Ui::viewDump($table, 'table');
