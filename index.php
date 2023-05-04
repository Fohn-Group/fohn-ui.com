<?php

/**
 * Demo landing page
 */
declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\App;
use Fohn\Ui\PageException;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;

require_once __DIR__ . '/vendor/autoload.php';

Ui::service()->boot(function (Ui $ui) {
    $config = loadConfig();
    date_default_timezone_set($config['timezone']);
    $ui->environment = $config['env'];

    $ui->setApp(new App());

    // Add default exception handler.
    $ui->setExceptionHandler(PageException::factory());
    // Set demos page.
    $page = \Fohn\Ui\Page::factory([
        'title' => 'Fohn-Ui - The php framework.',
        'template' => Ui::templateFromFile(__DIR__ . '/src/templates/landing-page.html'),
    ]);
    $page->addLayout(\Fohn\Ui\PageLayout\Layout::factory(['template' => Ui::templateFromFile(__DIR__ . '/src/templates/landing-page-layout.html')]));
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
$heroText = 'The PHP framework that works with <a href="https://tailwindcss.com" class="text-purple-700" target="_blank">Tailwind CSS</a>. Build powerful web application and style it like a pro!';
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

$featureCtn = View::addTo(Ui::layout())->appendTailwinds(['relative', 'pt-32', 'md:pt-44']);
$featureSection = View::addTo($featureCtn)->appendTailwinds(['mx-4', 'md:mx-auto', 'md:w-3/5']);

View\Heading\Header::addTo($featureSection, ['size' => 2, 'title' => 'Views'])
    ->appendTailwinds(['text-center', 'text-3xl', 'font-bold', 'text-gray-900', 'dark:text-white', 'md:text-4xl', 'lg:text-5xl']);


$viewFeatureTxt = View::addTo($featureSection, ['htmlTag' => 'p'])
    ->setTextContent('Fohn-Ui comes with predefined Views. <br>Including them to the html page is as easy as:', false)
    ->appendTailwinds(['mt-4', 'text-center', 'text-gray-600', 'dark:text-gray-300']);

DemoApp::addCodeConsole($featureSection)
    ->appendTailwinds(['mt-4'])
    ->setTextContent('Button::addTo(Ui::layout())->setLabel(\'Click Me\')');

$bar = View::addTo($featureSection)->appendTailwind('flex flex-row');
View\Button::addTo($bar)->setLabel('Click Me')->removeTailwind('mx-2')->appendTailwind('mx-auto');


//$main = View::addTo(Ui::layout())->appendTailwinds(['relative', 'overflow-hidden', 'dark:bg-darker', 'lg:overflow-auto']);
//$grCtn = View::addTo($main)->appendTailwinds(['absolute', 'inset-x-0', 'top-32', 'lg:hidden']);
//$grCols = View::addTo($grCtn)->appendTailwinds(['grid grid-cols-2', '-space-x-52', 'opacity-50', 'dark:opacity-60', '2xl:mx-auto', '2xl:max-w-6xl']);
//View::addTo($grCols)->appendTailwinds(['h-60', 'bg-gradient-to-br', 'from-purple-700', 'to-purple-400',  'blur-3xl', 'dark:from-blue-700']);
//View::addTo($grCols)->appendTailwinds(['h-72', 'rounded-full', 'bg-gradient-to-r', 'from-cyan-400', 'to-sky-300', 'blur-3xl', 'dark:from-transparent', 'dark:to-indigo-600']);
//
//$mainConetnt = View::addTo($main)->appendTailwinds(['mx-auto', 'max-w-6xl', 'px-6', 'md:px-12', 'lg:px-6', 'xl:px-0']);
