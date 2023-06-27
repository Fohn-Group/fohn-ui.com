<?php

declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\DemoApp;
use Fohn\Demos\Utils;
use Fohn\Ui\Component\Form;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Uses Control::onValidate() handler for validation.',
    'Validation can be set to any controls in form.',
];
DemoApp::addPageHeaderTo($grid, 'Form Controls Validation', $subtitles);
DemoApp::addGithubButton($grid);

$controls = [
    new Form\Control\Line(['controlName' => 'name', 'caption' => 'Last Name:', 'hint' => 'Name will be trim and first letter capitalized on submit.']),
    new Form\Control\Line(['controlName' => 'email', 'caption' => 'Email:', 'placeholder' => 'email@domain.com']),
    new Form\Control\Password(['controlName' => 'password', 'caption' => 'Password:']),
    new Form\Control\Number(['controlName' => 'age', 'caption' => 'Age (18 yrs or over):']),
];

$section = DemoApp::addInfoSection(Ui::layout(), 'Form controls validation:');

$form = Form::addTo($section);
$form->addControls($controls);

$form->getControl('name')
    ->onValidate(function (string $value) {
        $msg = null;
        if (!$value) {
            $msg = 'Please enter a name.';
        }

        return $msg;
    })
    ->onSetValue(function (string $value) {
        return ucfirst(trim($value));
    });

$form->getControl('email')
    ->onSetValue(function (string $value) {
        return filter_var($value, \FILTER_SANITIZE_EMAIL);
    })
    ->onValidate(function (string $value): ?string {
        $msg = null;
        if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
            $msg = 'Please enter a valid email.';
        }

        return $msg;
    });

$form->getControl('password')->onValidate(function (string $value): ?string {
    $msg = null;
    $options = ['options' => ['regexp' => '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/']];
    if (!filter_var($value, \FILTER_VALIDATE_REGEXP, $options)) {
        $msg = 'Please enter a valid password.';
    }

    return $msg;
});

$form->getControl('age')->onValidate(function (int $value): ?string {
    $msg = null;
    if (!filter_var($value, \FILTER_VALIDATE_INT, ['options' => ['min_range' => '18']])) {
        $msg = 'Must be at least 18 years old.';
    }

    return $msg;
});

$form->onSubmit(function (Form $f) {
    return Utils::displayControlsValueInToast($f->getControls());
});

View\HtmlList::addAfter($form->getControl('password'))
    ->setItems([
        ['name' => 'minimum of 8 character;'],
        ['name' => 'at least one uppercase letter;'],
        ['name' => 'at least one uppercase letter;'],
        ['name' => 'at least one number (digit);'],
        ['name' => 'at least one of the following characters: !@#$%^&*-;'],
    ])
    ->appendTailwind('italic text-sm mt-2')
    ->appendTailwind(Tw::textColor('secondary'));
