<?php
/**
 * Create a Table Vue Component and display Country data
 * using an Atk4\Country model.
 *
 * Table contains two actions columns:
 *  - one for editing the select Country record using a Modal\AsForm component;
 *  - one for deleting the select Country record using a Modal\AsDialog component;
 */

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Demos\Model\Employees;
use Fohn\Ui\Component\Table;
use Fohn\Ui\Js\JsStatements;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\Service\Data;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View\Button;

require_once __DIR__ . '/../init-ui.php';
$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Filter is apply on per column basis.',
];
DemoApp::addPageHeaderTo($grid, 'Table component using Filters', $subtitles);
DemoApp::addGithubButton($grid);

$modelCtrl = Data::tableModelCtrl(new Employees(Data::db()));
$modelCtrl->setSearchFields(['firt_name', 'last_name']);

$table = Table::addTo(Ui::layout(), ['keepSelectionAcrossPage' => true, 'height' => 'viewport-60']);
$table->setCaption(DemoApp::tableCaptionFactory('Employees'));
$table->getTableTw()->merge([Tw::textSize('sm'), Tw::bgColor('white')]);

// Multiple process action
$actionProcess = (new Table\Action(['keepSelection' => true]))->setTrigger(Button::factory(['label' => 'Process', 'color' => 'neutral']));
$table->addRowsAction($actionProcess)->onTrigger(static function ($ids) {
    $count = count($ids);

    return JsStatements::with([JsToast::success("Process Action on {$count} employee(s)")]);
});

// @phpstan-ignore-next-line
$table->addColumns($modelCtrl->getModel()->getTableColumns());
// @phpstan-ignore-next-line
$table->filterColumns($modelCtrl->getModel()->getTableFilters());

$table->onDataRequest(static function (Table\Payload $payload, Table\Result\Set $result) use ($modelCtrl): void {
    $modelCtrl->setTableResultSet($payload, $result);
});

// Use Ui::viewDump to inspect a rendered template of a view using a console display like for debugging.
// Using url with dump args: /demos/table/crud.php?dump=table
Ui::viewDump($table, 'table');
