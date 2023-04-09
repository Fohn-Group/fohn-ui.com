<?php

declare(strict_types=1);

// namespace Fohn\Ui\Demos;

use Fohn\Demos\DemoApp;
use Fohn\Ui\Component\Form;
use Fohn\Demos\Ctrl\DemoFormModelCtrl;
use Fohn\Demos\Model\Country;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\Service\Data;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;

require_once __DIR__ . '/../init-ui.php';

$modelCtrl = new DemoFormModelCtrl((new Country(Data::db())));
$id = (string) $modelCtrl->getModel()->tryLoadAny()->get('id');

$subtitles = [
    'Demonstrate change of form default layout and/or layout html template.',
    'Changes can be apply for a page only or for the entire application by setting Ui::formLayoutSeed property.',
];
DemoApp::addPageHeaderTo(Ui::layout(), 'Custom form layout.', $subtitles);

$template = Ui::templateFromFile(__DIR__ . '/template/left.html');
Ui::service()->formLayoutSeed = [Form\Layout\Standard::class, 'template' => $template];

$form = Form::addTo(Ui::layout());
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
    ->setText('The ISO and ISO3 country codes are internationally recognized means of identifying countries (and their subdivisions) using a two-letter or three-letter combination.');
