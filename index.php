<?php

/**
 * Demo landing page
 */
declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\DemoApp;
use Fohn\Ui\App;
use Fohn\Ui\Component\Form;
use Fohn\Ui\Component\Form\Control\Input;
use Fohn\Ui\Component\Form\Control\Password;
use Fohn\Ui\Js\JsStatements;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\PageException;
use Fohn\Ui\PageLayout\Layout;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;

require_once __DIR__ . '/vendor/autoload.php';
$codeReader = new CodeReader(__FILE__);

Ui::service()->boot(function (Ui $ui) {
    $config = loadConfig();
    date_default_timezone_set($config['timezone']);
    $ui->environment = $config['env'];

    $ui->setApp(new App());

    // Add default exception handler.
    $ui->setExceptionHandler(PageException::factory());
    // Set demos page.
    $page = \Fohn\Ui\Page::factory([
        'title' => 'Fohn-Ui - A PHP framework using Tailwind css.',
        'template' => Ui::templateFromFile(__DIR__ . '/src/templates/landing-page.html'),
    ]);
    $page->addLayout(Layout::factory(['template' => Ui::templateFromFile(__DIR__ . '/src/templates/landing-page-layout.html')]));
    $page->includeCssPackage('fohn-css', $config['css']);
    $ui->initAppPage($page);
});

function loadConfig(): array
{
    /** @var array $config */
    $config = require_once __DIR__ . '/demos/demos-config.php';

    // Override some value using local config if needed.
    if (file_exists(__DIR__ . '/demos/demos-config.local.php')) {
        $config = array_merge($config, require_once __DIR__ . '/demos/demos-config.local.php');
    }

    return $config;
}

$heroTitle = 'Web Application made easy';
$heroText = 'The open source PHP framework that works with <a href="https://tailwindcss.com" class="text-purple-700" target="_blank">Tailwind CSS</a>. Build powerful web application and style it like a pro!';
$heroLinkLabel = 'Learn More';
$heroLinkUrl = '/demos/intro/about/';
$heroImgSrc = '/public/images/happy-developer-team.jpg';

$heroCtn = View::addTo(Ui::layout())->appendTailwinds(['relative', 'overflow-hidden', 'dark:bg-darker', 'lg:overflow-auto']);
$heroCtn->setIdAttribute('hero');
$heroSection = View::addTo($heroCtn, ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/hero-section.html')]);
$heroSection->getTemplate()->set('heroTitle', $heroTitle);
$heroSection->getTemplate()->dangerouslySetHtml('heroText', $heroText);
$heroSection->getTemplate()->set('heroLinkLabel', $heroLinkLabel);
$heroSection->getTemplate()->set('heroLinkUrl', $heroLinkUrl);
$heroSection->getTemplate()->set('heroImgSrc', $heroImgSrc);

// VIEWS
$featureCtn = View::addTo(Ui::layout())->appendTailwinds(['relative', 'pt-24', 'md:pt-32']);
$featureSection = View::addTo($featureCtn)->appendTailwinds(['mx-4', 'md:mx-auto', 'md:w-3/5']);
View\Heading\Header::addTo($featureSection, ['size' => 2, 'title' => 'Built-In Ui Views'])
                   ->appendTailwinds(['text-center', 'text-3xl', 'font-bold', 'md:text-4xl', 'lg:text-5xl']);

$viewFeatureTxt = View::addTo($featureSection, ['htmlTag' => 'p'],)
    ->setTextContent('Fohn-Ui comes with out-of-the-box, ready to use, views.')
    ->appendTailwinds(['mt-4', 'text-center']);

$grid = View::addTo(Ui::layout(), ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/feature-grid.html')]);

$viewList = [
    ['name' => 'Button'],
    ['name' => 'Header'],
    ['name' => 'List'],
    ['name' => 'Message'],
    ['name' => 'Tag'],
    ['name' => 'and more...'],
];
View::addTo($grid, ['htmlTag' => 'p'], 'right')->setTextContent('Some Views included with Fohn-Ui:');
View\HtmlList::addTo($grid, [], 'right')->setItems($viewList)->appendTailwind('m-4');
View::addTo($grid, ['htmlTag' => 'p'], 'right')->setTextContent('Plus, it is easy to create your own.');

$gridItem = View::addTo($grid, ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/feature-grid-items.html')], 'left');

View::addTo($gridItem)->appendTailwind('text-gray-800')->setTextContent('Including them to the html page is as easy as:');
DemoApp::addCodeConsole($gridItem)
    ->setTextContent('Button::addTo(Ui::layout())->setLabel(\'Click Me\')');

$bar = View::addTo($gridItem)->appendTailwind('flex flex-row mt-8');
View\Button::addTo($bar)->setLabel('Click Me')->removeTailwind('mx-2')->appendTailwind('mx-auto');

// THEME

$featureCtn = View::addTo(Ui::layout())->appendTailwinds(['relative', 'pt-24', 'md:pt-32']);
$featureSection = View::addTo($featureCtn)->appendTailwinds(['mx-4', 'md:mx-auto', 'md:w-3/5']);
View\Heading\Header::addTo($featureSection, ['size' => 2, 'title' => 'Themable in PHP'])
                   ->appendTailwinds(['text-center', 'text-3xl', 'font-bold', 'md:text-4xl', 'lg:text-5xl']);

$viewFeatureTxt = View::addTo($featureSection, ['htmlTag' => 'p'],)
                      ->setTextContent('Thanks to Tailwind Css utilities framework, theme can be built with only using PHP.', false)
                      ->appendTailwinds(['mt-4', 'text-center']);

$grid = View::addTo(Ui::layout(), ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/feature-grid.html')])
    ->appendTailwind('md:flex-row-reverse');

View::addTo($grid, ['htmlTag' => 'p'], 'right')
    ->appendTailwind('w-1/2')
    ->setTextContent('View are styled using a theme and theme can be extend, modified or created..');

$gridItem = View::addTo($grid, ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/feature-grid-items.html')], 'left');

DemoApp::addCodeConsole($gridItem)
       ->setTextContent('Ui::theme()::styleAs(\'Button\', [$btn])');

// COMPONENT

$featureCtn = View::addTo(Ui::layout())->appendTailwinds(['relative', 'pt-24', 'md:pt-32']);
$featureSection = View::addTo($featureCtn)->appendTailwinds(['mx-4', 'md:mx-auto', 'md:w-3/5']);
View\Heading\Header::addTo($featureSection, ['size' => 2, 'title' => 'View as Component'])
                   ->appendTailwinds(['text-center', 'text-3xl', 'font-bold', 'md:text-4xl', 'lg:text-5xl']);

$viewFeatureTxt = View::addTo($featureSection, ['htmlTag' => 'p'],)
                      ->setTextContent('Some views are defined as Vue.js renderless component, i.e. the template is provide by Fohn-Ui while the behavior is control by Vue.js',)
                      ->appendTailwinds(['mt-4', 'text-center']);

$grid = View::addTo(Ui::layout(), ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/feature-grid.html')]);

$form = Form::addTo($grid, [], 'right');
$form->appendTailwinds(['border', 'rounded-3xl', 'border-gray-200', 'px-4', 'py-2', 'bg-white']);
$form->addHeader(View::factory()->setTextContent('Sign in Form:')->appendTailwind('text-gray-800'));
$form->addControl(Input::factory(['controlName' => 'email', 'inputType' => 'email', 'placeholder' => 'Email']));
$form->addControl(Password::factory(['controlName' => 'password', 'placeholder' => 'Password']));
$form->getControl('password')->onValidate(function($value) {
    $error = null;
   if (strlen($value) < 8) {
       $error = 'Password must be at least 8 characters.';
   }
   return $error;
});

$form->onSubmit(function ($form) {
   return JsStatements::with([JsToast::success('Thanks you!')]);
});

/* Add this code to console.
// @form
$form = Form::addTo(Ui::layout(), [], 'right');
$form->addControl(Input::factory(['controlName' => 'email', 'inputType' => 'email', 'placeholder' => 'Email']));
$form->addControl(Password::factory(['controlName' => 'password', 'placeholder' => 'Password']));
$form->getControl('password')->onValidate(function($value) {
    $error = null;
   if (strlen($value) < 8) {
       $error = 'Password must be at least 8 characters.';
   }
   return $error;
});

$form->onSubmit(function ($form) {
   return JsStatements::with([JsToast::success('Thanks you!')]);
});
// @end_form
 */

$gridItem = View::addTo($grid, ['template' => Ui::templateFromFile(__DIR__ . '/src/templates/feature-grid-items.html')], 'left');

$v = View::addTo($gridItem)->appendTailwinds(['flex', 'w-1/2', 'mx-auto']);
DemoApp::addCodeConsole($v)
       ->setTextContent($codeReader->extractCode('form'));

