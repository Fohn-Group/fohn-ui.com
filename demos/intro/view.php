<?php

declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new CodeReader(__FILE__);


DemoApp::addHeader(Ui::layout(), 'View / Html Template', 4);
DemoApp::addLineInfo(Ui::layout(), 'The View PHP class is the base class of all Fohn-Ui views or components..');
$text = 'A View instance is associate with an Html template. Prior of being rendered by the rendering engine, other 
views can be insert within a view template tag, representing a region. View methods will set various template tags 
durung the pre rendering process in order to fill html attributes with proper content.';
DemoApp::addParagraph(Ui::layout(), $text);

DemoApp::addHeader(Ui::layout(), 'Html Template', 5);

$text = 'The template engine support regular or self closing tag. Regular tag need to be explicitly close.
Regular tag will render content between the open and close tag as default content if not set
 by the template engine. On the other hand, self closing tag will not render any content if not directly set by the template engine.';
DemoApp::addParagraph(Ui::layout(), $text);

DemoApp::addLineInfo(Ui::layout(), 'Regular and self closing tag:');
$items = [
    ['name' => 'Regular', 'open' => '{MyTag}', 'close' =>  '{/}','default' => '<div>Default Content</div>'],
    ['name' => 'Self Closing', 'open' => '{$myTag}', 'close' =>  '', 'default' => ''],
];

View\HtmlList::addTo(Ui::layout(), ['itemsTemplate' => __DIR__ . '/templates/list-tag-explain.html'])->setItems($items)->appendTailwind('ml-2');

$section = DemoApp::addInfoSection(Ui::layout(), 'Minimal view template:');

DemoApp::addLineInfo($section, 'view.html:');
DemoApp::addCodeConsole($section)->setTextContent(file_get_contents(__DIR__ . '/templates/view.html'));

$text = 'Template engine also support special markup for javascript integration. This is specially useful
when creating Vue.js component.';
DemoApp::addParagraph(Ui::layout(), $text);
$section = DemoApp::addInfoSection(Ui::layout(), 'A vue component template:');
DemoApp::addLineInfo($section, 'Vue component template:');
DemoApp::addCodeConsole($section, 'html')->setTextContent(file_get_contents(__DIR__ . '/templates/vue.html'));

DemoApp::addLineInfo($section, 'Template rendered in html:');
DemoApp::addCodeConsole($section, 'html')->setTextContent(file_get_contents(__DIR__ . '/templates/vue-rendered.html'));


//////////// VIEW

DemoApp::addHeader(Ui::layout(), 'Creating Views', 5);

$section = DemoApp::addInfoSection(Ui::layout(), 'Example of a view instance rendered in html:');
$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);
// @demoTemplate
$view = View::addTo($container)
    ->setHtmlTag('p')
    ->setTextContent('I am a paragraph')
    ->appendTailwinds(['text-red-600', 'text-xl', 'italic']);
// @end_demoTemplate

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('demoTemplate'));
DemoApp::addLineInfo($section, 'Rendered html:');
DemoApp::addCodeConsole($section, 'html')->setTextContent($view->getHtml());

$text = 'Views can be added inside other view. By default, added views are rendered within the default template tag region named <span class="text-blue-700">{$Content}</span>.';
DemoApp::addParagraph(Ui::layout(), $text, false);

$section = DemoApp::addInfoSection(Ui::layout(), 'View can be rendered within other view:');

$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);
// @demo1
$outsideView = View::addTo($container)->setTextContent('Outside View')
    ->appendTailwinds([ 'border', 'border-gray-300', 'text-center', 'p-4']);

// Add innerView to the Outside view.
$innerView = View::addTo($outsideView)->setTextContent('Inner View')
    ->appendTailwinds(['text-blue-400', 'border', 'border-blue-400', 'p-4', 'bg-gray-100']);
// @end_demo1
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('demo1'));

$text = 'Note that it is possible to specify other tag region where views need to be rendered. 
This is very powerful and allow for flexible rendering of html content.';
DemoApp::addLineInfo($section, $text);

$text = 'By using Tailwind CSS utilities and Fohn-Ui View, you have full control on how the rendered html should be styled.
All this without having to write any css stylesheet.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'Example of views styled using Tailwind CSS:');

// @demoTw
$container = View::addTo($section)->appendTailwinds([
    'flex', 'items-center', 'rounded-full', 'w-24', 'h-24',
    'mx-auto', 'text-white', 'bg-green-600'
]);

$innerView = View::addTo($container)->appendTailwinds(['flex-1', 'text-center']);

View::addTo($innerView)->setTextContent('Buy <br> $20', false);
// @end_demoTw
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('demoTw'));

$text = 'Having to set Tailwind CSS utilities every time for every views would be cumbersome.
That is why Fohn-Ui come with a set of basic Views. Furthermore some of these views are styled by the default theme
 which allow to easily apply TailwindCss to it.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'Button styled using the default theme:');
$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);

// @demoButton
/*
 * Prior to be rendered to html, Buttons are style by the theme set in Ui service.
 * Ui::theme()->styleAs('BUTTON', [$this]);
 */
$btn = Button::addTo($container, ['color' => 'secondary', 'shape' => 'wide', 'type' => 'outline', 'label' => 'click me']);
// @end_demoButton
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('demoButton'));
DemoApp::addLineInfo($section, 'Rendered html:');
DemoApp::addCodeConsole($section, 'html')->setTextContent($btn->getHtml());
