<?php

declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\Ctrl\DemoFormModelCtrl;
use Fohn\Demos\DemoApp;
use Fohn\Demos\Model\Country;
use Fohn\Demos\Utils;
use Fohn\Ui\Component\Form;
use Fohn\Ui\Component\Tabs;
use Fohn\Ui\Component\Tabs\Tab;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\Js;
use Fohn\Ui\Js\JsFunction;
use Fohn\Ui\Service\Data;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    '',
];
DemoApp::addPageHeaderTo($grid, 'Tabs component', $subtitles);
DemoApp::addGithubButton($grid);

// @addingTabs
$demoTabs = Tabs::addTo(Ui::layout());
$introTab = $demoTabs->addTab(new Tab(['name' => 'intro', 'caption' => 'Introduction']));
$demosTab = $demoTabs->addTab(new Tab(['name' => 'demo', 'caption' => 'Demos']));
$menuTab = $demoTabs->addTab(new Tab(['name' => 'menu', 'caption' => 'Menu Template']));
// @end_addingTabs

$text = 'Tabs and Tab components, like many other component in Fohn-Ui, are handled by their javascript Vue components.
In Tabs/Tab, the behavior is handled by Vuejs while Fohn-Ui supply the html template for them.';
DemoApp::addParagraph($introTab, $text, false);

$text = 'First, add <code class="text-sm bg-gray-200 p-1 font-bold">Component\Tabs</code> view in your layout.
Then, individual Tab are added using  <code class="text-sm bg-gray-200 p-1 font-bold">Component\Tabs::addTab(): Tab</code> method.';
DemoApp::addParagraph($introTab, $text, false);

DemoApp::addCodeConsole($introTab)->setTextContent($codeReader->extractCode('addingTabs'));

$text = 'The addTab method returns a Fohn-Ui view where you can simply add any other View in it.';
DemoApp::addParagraph($introTab, $text, false);

// @addingTabView
View::addTo($introTab);
// @end_addingTabView
DemoApp::addCodeConsole($introTab)->setTextContent($codeReader->extractCode('addingTabView'));

DemoApp::addHeader($introTab, 'Javascript Event', 5);

$text = 'Individual Tab can be activate, enable or disable via Javascript.';
DemoApp::addParagraph($introTab, $text, false);

// @tabActivation
$section = DemoApp::addInfoSection($introTab, 'Js activation:');

$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);
$btn = Button::addTo($container, ['type' => 'text', 'size' => 'small'])->setLabel('Activate Demos Tab');
Jquery::addEventTo($btn, 'click')->execute($demoTabs->jsActivateTabName('demo'));
// @end_tabActivation
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('tabActivation'));

$text = 'Javascript function can be execute when a tab is being initialized, display or hide.';
DemoApp::addParagraph($introTab, $text, false);

// @tabFunction
// creating js function that echo text to browser console.
$createFn = function ($text) {
    return JsFunction::arrow()->execute(Js::from("console.log('{$text}')"));
};

$introTab->jsOnInitTab($createFn('init intro'));
$introTab->jsOnShowTab($createFn('show intro'));
$introTab->jsOnHideTab($createFn('hide intro'));
// @end_tabFunction
DemoApp::addCodeConsole($introTab)->setTextContent($codeReader->extractCode('tabFunction'));

DemoApp::addHeader($introTab, 'Tab Menu Template', 5);
$text = 'Tabs menu template can easily by changed with <code class="text-sm bg-gray-200 p-1 font-bold">Component\Tabs::setTabsMenuTemplate</code> method.
This allows you to control the look of the entire Tabs menu. Look for some example within the Menu Template tab.';
DemoApp::addParagraph($introTab, $text, false);

// DEMOS TAB

// ----
$section = DemoApp::addInfoSection($demosTab, 'Tab interaction:');
DemoApp::addLineInfo($section, 'The default tab is set to User tab.');

$btnGoTo = Button::addTo($section, ['label' => 'Activate Country Tab', 'type' => 'text']);
$btnEnableUser = Button::addTo($section, ['label' => 'Enable User Tab', 'type' => 'text']);
$btnDisableUser = Button::addTo($section, ['label' => 'Disable User Tab', 'type' => 'text']);

// ----
$section = DemoApp::addInfoSection($demosTab, 'Tabs demos:');

$tabs = Tabs::addTo($section);
Jquery::addEventTo($btnGoTo, 'click')->execute($tabs->jsActivateTabName('form'));
Jquery::addEventTo($btnEnableUser, 'click')->execute($tabs->jsEnableTabName('user'));
Jquery::addEventTo($btnDisableUser, 'click')->execute($tabs->jsDisableTabName('user'));

// ---
$homeTab = $tabs->addTab(new Tab(['name' => 'home']));
View::addTo($homeTab)->setTextContent('Home tab content.');

// ---
$modelCtrl = new DemoFormModelCtrl(new Country(Data::db()));
$id = (string) $modelCtrl->getModel()->tryLoadBy('iso', 'CA')->get('id');

$formTab = $tabs->addTab(new Tab(['name' => 'form', 'caption' => 'Country Form']));
$form = Form::addTo($formTab);
$form->addControls($modelCtrl->factoryFormControls($id));
$form->onSubmit(function (Form $f) use ($modelCtrl, $id) {
    if ($errors = $modelCtrl->saveModelUsingForm($id, $f->getControls())) {
        $f->addValidationErrors($errors);
    }

    return Utils::displayControlsValueInToast($f->getControls());
});

// ---
$userTab = $tabs->addTab(new Tab(['name' => 'user']));
View::addTo($userTab)->setTextContent('User tab content.');

$tabs->activateTabName('user');

// MENU TEMPLATE

// ---
$section = DemoApp::addInfoSection($menuTab, 'Using menu template:');

$tabs = Tabs::addTo($section);
$tabs->setTabsMenuTemplate(Ui::templateFromFile(__DIR__ . '/template/tabs-menu.html'));

$homeTab = $tabs->addTab(new Tab(['name' => 'home']));
View::addTo($homeTab)->setTextContent('Home tab content.');

$profileTab = $tabs->addTab(new Tab(['name' => 'profile']));
View::addTo($profileTab)->setTextContent('Profile tab content.');

$userTab = $tabs->addTab(new Tab(['name' => 'preferences']));
View::addTo($userTab)->setTextContent('Preferences tab content.');

$adminTab = $tabs->addTab(new Tab(['name' => 'admin']))->disabled();

// ---
$section = DemoApp::addInfoSection($menuTab, 'Adding tab property:');

DemoApp::addLineInfo($section, 'A Tab property, like an icon name, can be added to the Tab component and be available
within the menu template.');

// @menuIcon
$tabs = Tabs::addTo($section);
$tabs->setTabsMenuTemplate(Ui::templateFromFile(__DIR__ . '/template/tabs-menu-icon.html'));

$homeTab = $tabs->addTab(new Tab(['name' => 'home']))->addProperty('icon', 'bi-house-fill');
View::addTo($homeTab)->setTextContent('Home tab content.');

$profileTab = $tabs->addTab(new Tab(['name' => 'profile']))->addProperty('icon', 'bi-person-fill');
View::addTo($profileTab)->setTextContent('Profile tab content.');

$userTab = $tabs->addTab(new Tab(['name' => 'preferences']))->addProperty('icon', 'bi-gear-fill');
View::addTo($userTab)->setTextContent('Preferences tab content.');

$adminTab = $tabs->addTab(new Tab(['name' => 'admin']))->disabled()->addProperty('icon', 'bi-person-fill-lock');
// @end_menuIcon
