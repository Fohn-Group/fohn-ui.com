<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\View\Heading\Header;
use Fohn\Ui\View\Segment;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\DemoCodeReader(__FILE__);
Header::addTo(Ui::layout(), ['title' => 'About Fohn-Ui', 'size' => 3]);

$text = 'Fohn-Ui is a PHP framework that use TailwindCss utilities. 
With Fohn-Ui and the help of TailwindCss, you can quickly built good looking Web application without having to create any css files.';
DemoApp::addParagraph(Ui::layout(), $text);

Header::addTo(Ui::layout(), ['title' => 'Theme done in PHP', 'size' => 4])->appendTailwind('mt-6');

$text = 'Because Fohn-ui is built around TailwindCss, it is possible to create theme written in PHP.
You can create your own theme or simply override the default Fohn-Ui and change color recipes.
Many views in Fohn-ui, like Button, are styled using the default theme.';
DemoApp::addParagraph(Ui::layout(), $text);

Header::addTo(Ui::layout(), ['title' => 'Javascript', 'size' => 4])->appendTailwind('mt-6');
$text = 'Javascript event and function can be added to any views.';
DemoApp::addParagraph(Ui::layout(), $text);

Header::addTo(Ui::layout(), ['title' => 'jQuery', 'size' => 5])->appendTailwind('mt-6');
$text = 'jQuery is directly integrate within Fohn-Ui.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'Jquery integration');

//$bar = View::addTo($section)->appendTailwind('h-24');
$grid = DemoApp::addTwoColumnsResponsiveGrid($section)->appendTailwinds(['items-center', 'h-24']);
// @jquery
$btn = Button::addTo($grid)->setLabel('Toggle Segment');
$segment = Segment::addTo($grid)->setText('I might disapear');
Jquery::addEventTo($btn, 'click')
    ->executes([Jquery::withThis()->text('Toggle Segment'), Jquery::withView($segment)->toggle()]);
Jquery::addEventTo($segment, 'mouseover')
    ->executes([Jquery::withThis()->toggle(), Jquery::withView($btn)->text('Bring me back!')]);
// @end_jquery
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setText($codeReader->extractCode('jquery'));

DemoApp::addLineInfo($section, 'Rendered html:');
DemoApp::addCodeConsole($section, 'javascript')->setText($btn->getHtml() . PHP_EOL . $segment->getHtml());

DemoApp::addLineInfo($section, 'Rendered script:');
DemoApp::addCodeConsole($section, 'javascript')->setText($btn->getJavascript() . PHP_EOL . $segment->getJavascript());
