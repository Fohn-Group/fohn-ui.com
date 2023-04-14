<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Demos\DemoCodeReader;
use Fohn\Ui\HtmlTemplate;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\Js;
use Fohn\Ui\Js\JsFunction;
use Fohn\Ui\Js\JsReload;
use Fohn\Ui\Js\Type\Variable;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Theme\Base;
use Fohn\Ui\Tailwind\Theme\Fohn;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\View\GridLayout;
use Fohn\Ui\View\Segment;
use Fohn\Ui\View\Tag;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new DemoCodeReader(__FILE__);

$subtitles = [
    'View Class is the base class at the hearth of Fohn-ui.',
];

DemoApp::addPageHeaderTo(Ui::layout(), 'View', $subtitles);

$text = 'A View instance is associate with an Html template. Prior of being rendered by the rendering engine, you 
can add other views within a view template tag region or simply fill in the template tag with content like the view id 
or css class.';
DemoApp::addParagraph(Ui::layout(), $text);

$text = 'Template tag are special markup text within an html file. For example: {$idAttri} or {$Content}';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'Minimal view template:');

DemoApp::addLineInfo($section, 'view.html:');
DemoApp::addCodeConsole($section)->setText(file_get_contents(__DIR__ . '/templates/view.html'));

$text = 'View class contains methods that will fill in these templates tags during rendering.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'View instance:');
// @demoTemplate
$view = View::addTo($section)
    ->setHtmlTag('p')
    ->setText('I am a paragraph')
    ->appendTailwinds(['px-4', 'py-2', 'text-red-600', 'text-xl', 'italic']);
// @end_demoTemplate

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setText($codeReader->extractCode('demoTemplate'));
DemoApp::addLineInfo($section, 'Rendered html:');
DemoApp::addCodeConsole($section,'html')->setText($view->getHtml());


$text = 'Views can be added inside a view. Although you can specify the region inside your template where the newly created
 view is to be placed, View::class will use {$Content} region by default.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'View can be added inside other Views.');

// @demo1
$outsideView = View::addTo($section)->setText('Outside View')
    ->appendTailwinds(['border', 'border-gray-300', 'p-4', 'w-1/2']);

// Add innerView to the Outside view.
$innerView = View::addTo($outsideView)->setText('Inner View')
    ->appendTailwinds(['border', 'border-gray-300', 'p-4', 'bg-gray-100']);
// @end_demo1
DemoApp::addCodeConsole($section)->setText($codeReader->extractCode('demo1'));

$text = 'By using TailwindCss utilities and View, you have full control on how the view should be styled.
All this without having to write css files.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'Example of Views styled using TailwindCss');

// @demoTw
$v = View::addTo($section)->appendTailwinds(
    [
        'flex',
        'items-center',
        'bg-green-600',
        'rounded-full',
        'w-24',
        'h-24',
        'text-white',
    ]
);

$in = View::addTo($v)->appendTailwinds(
    [
        'flex-1',
        'text-center',
    ]
);

View::addTo($in, ['text' => 'Buy']);
View::addTo($in, ['text' => '$20']);
// @end_demoTw
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setText($codeReader->extractCode('demoTw'));

$text = 'Having to set TailwindCss utilies every time for every views would be cumbersome. 
That is why Fohn-Ui also come with a set of basic Views. Furthermore some of these views are styled by a default theme
 which allow to easily apply TailwindCss to it.';
DemoApp::addParagraph(Ui::layout(), $text);


$section = DemoApp::addInfoSection(Ui::layout(), 'Button style using default theme');

// @demoButton
/*
 * When render Button is style by the default theme
 * Ui::theme()->styleAs('BUTTON', [$this]);
 */
$btn = Button::addTo($section, ['color' => 'secondary', 'shape' => 'wide', 'type' => 'outline', 'label' => 'click me']);
// @end_demoButton
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setText($codeReader->extractCode('demoButton'));
DemoApp::addLineInfo($section, 'Rendered html:');
DemoApp::addCodeConsole($section, 'html')->setText($btn->getHtml());

