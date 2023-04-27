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
    'Demonstrate usage of custom html template for line control component.',
];

DemoApp::addPageHeaderTo($grid, 'Form component hook.', $subtitles);
DemoApp::addGithubButton($grid);

$section = DemoApp::addInfoSection(Ui::layout(), 'Using the CONTROL_ADD hook for changing input template:');

$modelCtrl = new DemoFormModelCtrl(new Country(Data::db()));
$id = (string) $modelCtrl->getModel()->tryLoadBy('iso', 'CA')->get('id');
$form = Form::addTo($section);

// @hook
$form->onHook(Form::HOOK_BEFORE_CONTROL_ADD, function ($form, Form\Control $control, $layoutName) {
    if (get_class($control) === Form\Control\Input::class) {
        $control->setTemplate(Ui::templateFromFile(__DIR__ . '/template/custom-input.html'));
    }
});
// @end_hook
$form->addControls($modelCtrl->factoryFormControls($id));
$form->onSubmit(function (Form $f) use ($modelCtrl, $id) {
    if ($errors = $modelCtrl->saveModelUsingForm($id, $f->getControls())) {
        $f->addValidationErrors($errors);
    }

    return JsToast::success('Saved!', 'Record is now saved.');
});

View::addAfter($form->getControl('iso3'))
    ->appendTailwind('italic text-sm my-2')
    ->appendTailwind(Tw::textColor('secondary'))
    ->setTextContent('The ISO and ISO3 country codes are internationally recognized means of identifying countries (and their subdivisions) using a two-letter or three-letter combination.');

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('hook'));
