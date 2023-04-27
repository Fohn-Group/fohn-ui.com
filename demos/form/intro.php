<?php

declare(strict_types = 1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Component\Form\Layout\Standard;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\JsFunction;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\Service\Ui;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Form content and management.',
];

DemoApp::addPageHeaderTo($grid, 'Form Component', $subtitles);
DemoApp::addGithubButton($grid);

$text = 'Forms in Fohn-Ui are Vue.js renderless component, the same for each form controls. Form html content is provide by Fohn-Ui while form behavior is 
handled by Vue <b>form component</b> from Fohn-Ui javascript package.
<br>This allow Fohn-Ui users to have maximum flexibility in controlling the look of their forms.';
DemoApp::addParagraph(Ui::layout(), $text, false);

DemoApp::addHeader(Ui::layout(), 'Fom layout', 5);
$text = 'Form use a FormLayoutInterface View where all form controls are added. The FormLayoutInterface view is used to set
the overall look of the form. The default form layout when creating a form is supply by the current Ui::service(). Fohn-Ui users
 can change the overall look of Forms within the entire App by setting the <code class="text-sm bg-gray-200 p-1 font-bold">Ui::service()->formLayoutSeed</code> property within
  the service boot() function.';
DemoApp::addParagraph(Ui::layout(), $text, false);

// @formLayout
Ui::service()->boot(function (Ui $ui) {
    // Display form controls to the left of the page for the entire app.
    $ui->formLayoutSeed = [Standard::class, 'template' => Ui::templateFromFile(__DIR__ . '/template/left.html')];
});
// @end_formLayout
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('formLayout'));

$text = 'Form controls added to the form layout are usually insert within the template default <span class="text-blue-700">{$Content}</span> tag.
<br> However, if the template contains a tag, named after a form control name, then the html content, for this control,
 will be rendered at this tag location.';
DemoApp::addParagraph(Ui::layout(), $text, false);

$text = 'The <a class="text-purple-700 underline" href="/demos/form/control/">Controls</a> demos Form layout template 
uses tag with control name in that manner.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/////////////////////////
DemoApp::addHeader(Ui::layout(), 'Form Controls', 5);
$text = 'Form controls are added using the <code class="text-sm bg-gray-200 p-1 font-bold">Form::addControl(Control $control)</code> method. It is possible to set, for each form control,
two callback functions that are fire when form is submit: one for validating the control value and one for transforming that value 
prior to retrieve these values for database saving purpose.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Comment for code demo purpose.
// @controlCB
$form = Form::addTo(Ui::layout);
$name = $form->addControl(new Input(['controlName' => 'name']));
$name->onValidate(function ($value): ?string {
        // validate value and return error msg or null.
        return $error;
    })->onSetValue(function ($value) {
        // return modify value if needed.
        return $value;
});
// @end_controlCB
*/
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('controlCB'));
$text = 'Form controls also uses javascript onChange handlers via the <code class="text-sm bg-gray-200 p-1 font-bold">Control::onChange(JsFunction $fn, int $debounceValue)</code> method.
 The JsFunction pass to the onChange method will be execute when user enter a new control value. The handler function also receive the new 
control value as a parameter.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Comment for code demo purpose.
// @controlChange
// Changing html text on a view using the new control value.
$name = $form->getControl('name');
$jsHandler = JsFunction::arrow([Js::var('newValue')])->execute(Jquery::withView($view)->text(Js::var('newValue')));
$name->onChange($jsHandler, 500);
// @end_controlChange
*/
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('controlChange'));

/////////////////////////////
DemoApp::addHeader(Ui::layout(), 'Form Submission', 5);
$text = 'Form submission is handled by the <code class="text-sm bg-gray-200 p-1 font-bold">Form::onSubmit(\Closure function(Form $form))</code> method. When form is submitted, the closure function 
is executed. The closure function receive the Form instance as parameter. Form instance can be used for either form final validation and/or saving controls value to a database.
The closure function must return a JsRenderInterface containing javascript expressions which will be executed on the client browser.';
DemoApp::addParagraph(Ui::layout(), $text, false);

/* Comment for code demo purpose.
// @formSubmit
$form->onSubmit(function (Form $f) {
    $values = $f->getControlValues();
    // save values in db.

    return JsToast::success('Saved!', 'Demo mode.');
});
// @end_formSubmit
*/
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('formSubmit'));

/////////////////////////////
DemoApp::addHeader(Ui::layout(), 'Model Controller', 5);
$text = 'Adding form control or saving form controls value may be handle using a <code class="text-sm bg-gray-200 p-1 font-bold">FormModelController::class</code>.
Controller will look into an ORM Model and return form controls accordingly. These form controls can then be 
 added to the form. As of now, Fohn-Ui support FormModelController for use with AgileToolkit Data ORM. (atk4/data).';
DemoApp::addParagraph(Ui::layout(), $text, false);

/*
// @formCtrl
$modelCtrl = new \Atk\FormModelCtrl(new Country(Data::db()));
$form = Form::addTo(Ui::layout());
$form->addControls($modelCtrl->factoryFormControls($id));

$form->onSubmit(function (Form $f) use ($modelCtrl, $id) {
    if ($errors = $modelCtrl->saveModelUsingForm($id, $f->getControls())) {
        $f->addValidationErrors($errors);
    }

    return JsToast::success('Saved!', 'Demo mode.');
});
// @end_formCtrl
 */
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('formCtrl'));
