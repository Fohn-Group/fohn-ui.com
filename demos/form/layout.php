<?php

declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\Ctrl\DemoFormModelCtrl;
use Fohn\Demos\DemoApp;
use Fohn\Demos\Model\Country;
use Fohn\Ui\Component\Form;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\Service\Data;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());


$subtitles = [
    'Form default layout template can be change locally or globally.',
];
DemoApp::addPageHeaderTo($grid, 'Custom form layout.', $subtitles);
DemoApp::addGithubButton($grid);

$section = DemoApp::addInfoSection(Ui::layout(), 'Form using a new layout:');


$template = Ui::templateFromFile(__DIR__ . '/template/left.html');
Ui::service()->formLayoutSeed = [Form\Layout\Standard::class, 'template' => $template];

$modelCtrl = new DemoFormModelCtrl(new Country(Data::db()));
$id = (string) $modelCtrl->getModel()->tryLoadBy('iso', 'CA')->get('id');
$form = Form::addTo($section);
$form->addControls($modelCtrl->factoryFormControls($id));

$form->onSubmit(function (Form $f) use ($modelCtrl, $id) {
    if ($errors = $modelCtrl->saveModelUsingForm($id, $f->getControls())) {
        $f->addValidationErrors($errors);
    }

    return JsToast::success('Saved!', 'Record is now saved.');
});

View::addAfter($form->getControl('iso3'))
    ->appendTailwind('italic text-sm mt-2')
    ->appendTailwind(Tw::textColor('secondary'))
    ->setTextContent('The ISO and ISO3 country codes are internationally recognized means of identifying countries (and their subdivisions) using a two-letter or three-letter combination.');
