<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Table Introduction.',
];

DemoApp::addPageHeaderTo($grid, 'Table Component', $subtitles);
DemoApp::addGithubButton($grid);

$text = 'Tables in Fohn-Ui are Vue.js renderless component, the same for each table cells. Table html content is provide
by Fohn-Ui while table behavior, on the client side, is handled by Vue <b>table component</b> from Fohn-Ui javascript package.
<br>This allow Fohn-Ui users to have maximum flexibility in controlling the look of their tables.';
DemoApp::addParagraph(Ui::layout(), $text, false);

DemoApp::addHeader(Ui::layout(), 'Table Columns', 5);
$text = 'Columns are added to the table using the <code>Table::addColumn(Table\Column $column)</code> method.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Usage for code display purpose only.
// @tableColumn
$table = Table::addTo(Ui::layout(), ['hasTableSearch' => false, 'hasPaginator' => false]);
$table->addColumn('name_email', Table\Column\Html::factory(['caption' => 'Name']));
// @end_tableColumn
 */
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('tableColumn'));

DemoApp::addHeader(Ui::layout(), 'Table Records', 5);
$text = 'Filling table with data is handled by the <code class="text-sm bg-gray-200 p-1 font-bold">Table::onDataRequest(function (Table\Payload $payload, Table\Result\Set $result)</code>.
The Vue table component will request for table data once it has been rendered on the page. The closure function for executing the data request will be call
using two parameters: a Payload object instance and a Result\Set object instance.
<br> The Payload instance is built from the data request and may contain the table current page number, the name of column to sort data on, the sort direction, the number of records per pages and
a search query string.
<br> The Result\Set instance on the other hand needs to be filled with a data set.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Usage for code display purpose only.
// @tableData
$table->onDataRequest(function (Table\Payload $payload, Table\Result\Set $result): void {
    $faker = Factory::create();
    $data = [];
    for ($i = 0; $i < 15; ++$i) {
        $name = $faker->name();
        $email = $faker->email();
        $data[] = [
            'name_email' => ['name' => $name, 'email' => $email],
        ];
    }

    $result->dataSet = $data;
});
// @end_tableData
*/
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('tableData'));

DemoApp::addHeader(Ui::layout(), 'Table Column Format', 5);
$text = 'Any table column can be format using a formatter closure function. The closure function must return a string.
Column type of <code class="text-sm bg-gray-200 p-1 font-bold">Html::class</code> support html markup. The formatter closure function also receive the Column instance
and it\' value as parameters.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Usage for code display purpose only.
// @cellFormat
// Apply specific formatter based on cell value. Formatter function must return a string.
$table->getTableColumn('name_email')->formatValue(function ($col, $value) {
    $textColor = Tw::textColor('info-light');

    return "<a href=mailto:'{$value['email']}' class='{$textColor} underline'>{$value['name']}</a>";
});
// @end_cellFormat
*/
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('cellFormat'));

DemoApp::addHeader(Ui::layout(), 'Table Row Style', 5);
$text = 'Tailwind utilities may be apply conditionally to a table row base on cells values via a closure function.
The closure function will receive a row id and a standard PHP object instance as parameter. The object instance will
contains the table column names as property. The closure function must return a <code class="text-sm bg-gray-200 p-1 font-bold">Tw::class</code> object instance.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Usage for code display purpose only.
// @cssRow
// $table contain a column named 'sales'.
$table->applyCssRow(function (string $id, object $row): Tw {
    $tws = Tw::from([]);
    if ($row->sales > 250000) {
        $tws->merge([Tw::bgColor('success')]);
    }

    return $tws;
});
// @end_cssRow
*/
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('cssRow'));
