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

use Atk4\Data\Model\Scope;
use Fohn\Demos\Ctrl\DemoFormModelCtrl;
use Fohn\Demos\DemoApp;
use Fohn\Demos\Model\Country;
use Fohn\Ui\Component\Form;
use Fohn\Ui\Component\Modal;
use Fohn\Ui\Component\Table;
use Fohn\Ui\Js\Js;
use Fohn\Ui\Js\JsRenderInterface;
use Fohn\Ui\Js\JsStatements;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\Service\Data;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;

require_once __DIR__ . '/../init-ui.php';
$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Display, edit and delete country record.',
    'Use Paginator, Search and Sortable columns.',
    'Table will restore its state on refresh.',
];
DemoApp::addPageHeaderTo($grid, 'Table component using Country model', $subtitles);
DemoApp::addGithubButton($grid);

$country = new Country(Data::db());
$modelCtrl = new DemoFormModelCtrl($country);

$section = DemoApp::addInfoSection(Ui::layout(), 'Table for CRUD operation:');

$table = Table::addTo($section);
$table->setCaption(DemoApp::tableCaptionFactory('Countries'));
View::addTo(Ui::layout())
    ->setTextContent('Flag provided by: <a href="https://flagpedia.net" target="_blank">flagpedia</a>', false)
    ->appendTailwinds(['float-right italic text-sm -mt-1']);

// Create edit and delete dialog.
$editDialog = Modal\AsForm::addTo(Ui::layout(), ['title' => 'Edit Country']);
$deleteDialog = Modal\AsDialog::addTo(Ui::layout(), ['title' => 'Confirm country deletion:']);

// Add form to edit dialog
$form = $editDialog->addForm(Ui::factory(Form::class));
$form->addControls($modelCtrl->factoryFormControls(null));

// Response to form request value callback using $ctrl.
$form->onControlsValueRequest(function ($id, Form\Response\Value $response) use ($modelCtrl) {
    $response->mergeValues($modelCtrl->getFormInputValue((string) $id));
});

// Response to form submit request.
$form->onSubmit(function (Form $f, ?string $id) use ($modelCtrl, $editDialog, $table): JsRenderInterface {
    if ($errors = $modelCtrl->saveModelUsingForm($id, $f->getControls())) {
        $f->addValidationErrors($errors);
    }

    return JsStatements::with(
        [
            JsToast::success('Success!', 'Note: Record is not saved in db using demo mode.'),
            $table->jsUpdateRow($id, $f->getControlValues()),
            $editDialog->jsClose(),
        ]
    );
});

// Add columns to table.
$table->addColumn('name', Table\Column\Html::factory(['isSortable' => true]))->appendTailwinds(['w-52']);

$table->addColumn('flag', Table\Column\Html::factory())->alignText('center');
$table->getTableColumn('flag')->formatValue(function ($col, $value) {
    return "<div class='grid place-items-center'><img src='https://flagcdn.com/24x18/{$value}.png'></div>";
});

$table->addColumn('iso', Table\Column\Generic::factory(['isSortable' => true])->alignText('center'));
$table->addColumn('iso3', Table\Column\Generic::factory(['isSortable' => true])->alignText('center'));
$table->addColumn('numcode', Table\Column\Integer::factory());
$table->addColumn('phonecode', Table\Column\Integer::factory());

// Add Edit action column to table using a click event (default).
// The method return a Js arrow function using the cell property value as argument. ex: (cell) => {};
$editActionFn = $table->addActionColumn('action', 'edit', DemoApp::tableBtnFactory('bi bi-pencil-fill'));
// Add statements to the function. Function is execute on event set in addActionColumn.
$editActionFn->executes($editDialog->jsOpenWithId(Js::var('cell.id')));

// Add Delete action column to table.
$deleteActionFn = $table->addActionColumn('action', 'delete', DemoApp::tableBtnFactory('bi bi-x-circle-fill', 'error'));

// Get the current field 'name' value using a javascript expression.
// Create a user msg using a Js expression.
$msg = Js::from("'Are you sure you want to delete ' + {{countryName}} + ' ?'", ['countryName' => $table->jsGetCellValue('name')]);
// Open delete dialog on click.
$deleteActionFn->executes([$deleteDialog->jsOpen(['message' => $msg, 'payload' => ['id' => Js::var('cell.id')]])]);

// Add callback event to Dialog when user confirm the action.
$deleteDialog->addCallbackEvent('confirm', new Button(['label' => 'Delete', 'color' => 'info']));
$deleteDialog->onCallbackEvent('confirm', function ($payload) use ($deleteDialog, $table) {
    // Delete record in db. Record id is set in $payload['id']
    return JsStatements::with([
        JsToast::success('Delete', 'Note: Record is not delete from db in demo mode.'),
        $deleteDialog->jsClose(),
        $table->jsDeleteRow($payload[$table->idColumnName]),
    ]);
});

// Response to an onDataRequest event from Table.
// Fill in Table\Result\Set $dataSet depending on $payload value.
$table->onDataRequest(function (Table\Payload $payload, Table\Result\Set $result) use ($country): void {
    $searchFields = ['name'];
    if ($payload->sortColumn) {
        $country->setOrder($payload->sortColumn, $payload->sortDirection);
    }
    if ($payload->searchQuery) {
        $scope = Scope::createOr();
        foreach ($country->getFields() as $field) {
            if (in_array($field->shortName, $searchFields, true)) {
                $scope->addCondition($field, 'like', '%' . $payload->searchQuery . '%');
            }
        }
        $country->addCondition($scope);
    }
    $country->setLimit($payload->ipp, ($payload->page - 1) * $payload->ipp);

    $result->totalItems = (int) $country->action('count')->getOne();
    foreach ($country->export() as $k => $row) {
        $result->dataSet[$k] = $row;
        $result->dataSet[$k]['flag'] = strtolower($row['iso']);
    }
});

// Use Ui::viewDump to inspect a rendered template of a view using a console display like for debugging.
// Using url with dump args: /demos/table/crud.php?dump=table
Ui::viewDump($table, 'table');
// Using url with dump args: /demos/table/crud.php?dump=edit
Ui::viewDump($editDialog, 'edit');
// Using url with dump args: /demos/table/crud.php?dump=delete
Ui::viewDump($deleteDialog, 'delete');
