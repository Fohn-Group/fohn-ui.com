<?php

declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\DemoApp;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\Js;
use Fohn\Ui\Js\JsChain;
use Fohn\Ui\Js\JsFunction;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Javascript rendering engines.',
];
DemoApp::addPageHeaderTo($grid, 'Javascript', $subtitles);
DemoApp::addGithubButton($grid);

$text = 'Fohn-Ui can render javascript expression when associated with views using this method:';
DemoApp::addParagraph(Ui::layout(), $text, false);
DemoApp::addCodeConsole(Ui::layout())->setTextContent('View::appendJsAction(JsRenderInterface $action)');

$text = 'When rendering the html output for a page, the rendering engine will also collect each views actions and render them
within a script tag inside a jQuery ready function that will be executed once page is load.';
DemoApp::addParagraph(Ui::layout(), $text);
DemoApp::addCodeConsole(Ui::layout())->setTextContent(file_get_contents(__DIR__ . '/templates/ready-sample.html'));

$text = 'Fohn-Ui come with many utility method in order to easily create and render javascript function.';
DemoApp::addParagraph(Ui::layout(), $text);
$section = DemoApp::addInfoSection(Ui::layout(), 'Example of adding function to the window namespace:');
$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);

// @js_1
$btn = Button::addTo($container)->setLabel('Hello');
// creating an arrow function.
$fn = JsFunction::arrow([Js::var('msg')])
    ->executes([
        Js::from('console.log(msg)'), // log to browser console.
        Js::from('alert(msg)'), // display alert.
    ]);
// Adding function to window namespace on page load.
Ui::page()->appendJsAction(Js::from('window.alertMe = {{fn}}', ['fn' => $fn]));
// calling alertMe function on button click.
$btn->appendHtmlAttribute('onclick', JsFunction::declareFunction('alertMe', [Jquery::withThis()->text()])->jsRender());
// @end_js_1

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('js_1'));

DemoApp::addLineInfo($section, 'Rendered javascript:');
DemoApp::addCodeConsole($section, 'javascript')->setTextContent(Js::from('window.alertMe = {{fn}}', ['fn' => $fn])->jsRender());

DemoApp::addLineInfo($section, 'Html:');
DemoApp::addCodeConsole($section, 'html')->setTextContent(preg_replace('/class="(.*?)"|style="(.*?)"/', '', $btn->getHtml()));

DemoApp::addHeader(Ui::layout(), 'Chaining', 5);
$text = 'Javascript chaining can be rendered using the JsChain object. This is useful for external javascript library need for a project.
Note that the Jquery object itself is extending the JsChain object with specific implementation for the jQuery library.';
DemoApp::addParagraph(Ui::layout(), $text);

$section = DemoApp::addInfoSection(Ui::layout(), 'JsChain example:');
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent("JsChain::with('myLibrary')->performMethod(Js::var('myVar')->property");
DemoApp::addLineInfo($section, 'Rendered javascript:');
DemoApp::addCodeConsole($section, 'javascript')->setTextContent(JsChain::with('myLibrary')->performMethod(Js::var('myVar'))->property->jsRender());

$section = DemoApp::addInfoSection(Ui::layout(), 'Example with Day.js library:');
$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);

// @dayjs
Ui::page()->includeJsPackage('dayjs', 'https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js');

$clock = View::addTo($container)->appendTailwinds(['bg-blue-700', 'shadow-lg', 'font-bold', 'text-white', 'text-xl', 'text-center', 'p-4', 'w-48', 'rounded-full', 'tracking-widest']);
// Use Js::var('') to start a chain with a function call with no parameter: "dayjs()".
$getDayJsDate = JsChain::with('dayjs', Js::var(''))->format('HH:mm:ss');
$fn = JsFunction::anonymous()->execute(Jquery::withView($clock)->text($getDayJsDate));
$useInterval = Js::from('setInterval({{fn}}, 1000)', ['fn' => $fn]);

Ui::page()->appendJsAction($useInterval);
// @end_dayjs
Jquery::onDocumentReady($clock)->text(JsChain::with('dayjs', Js::var(''))->format('HH:mm:ss'));
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('dayjs'));
DemoApp::addLineInfo($section, 'Rendered javascript:');
DemoApp::addCodeConsole($section, 'javascript')->setTextContent($useInterval->jsRender());
