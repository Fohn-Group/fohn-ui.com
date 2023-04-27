<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\Js;
use Fohn\Ui\Js\JsReload;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'jQuery integration.',
];
DemoApp::addPageHeaderTo($grid, 'Jquery', $subtitles);
DemoApp::addGithubButton($grid);

DemoApp::addHeader(Ui::layout(), 'Jquery class helpers', 4);
$html = 'Jquery object extends the JsChain object and contains helper methods that can be used to target a specific view instance, thanks
to Fohn-Ui ability to generate unique html id attribute value for every view created.
<br>Once a javascript chain is created, any of jQuery functions can be used.';
DemoApp::addParagraph(Ui::layout(), $html, false);

// @helperFn
$view = View::addTo(Ui::layout()); // generated unique id attribute value.

// Helper method and their equivalent chain rendering.
Jquery::withView($view)->toggle(); // jQuery('#viewUniqueId').toggle()
Jquery::withSelector('.css_class_name')->toggle(); // jQuery('.css_class_name').toggle()
Jquery::withThis()->toggle(); // jQuery(this).toggle()
Jquery::withVar('myVar')->toggle(); // jQuery(myVar).toggle()
Jquery::withSelf()->ajax(); // jQuery.ajax()
// @end_helperFn

$section = DemoApp::addInfoSection(Ui::layout(), 'Jquery chain helpers:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('helperFn'));

$html = 'Another useful helper method is the <code class="text-sm bg-gray-200 p-1 font-bold">Jquery::addEventTo(View $v, string $event, string $selector)</code>.
<br>The return type is a Js function that you can use to execute javascript expression. <br> This method will
render as <code class="text-sm bg-gray-200 p-1 font-bold">jQuery.on(event, selector, handler)</code>.';
DemoApp::addParagraph(Ui::layout(), $html, false);

$section = DemoApp::addInfoSection(Ui::layout(), 'Example of Jquery::addEventTo');

$grid = DemoApp::addTwoColumnsResponsiveGrid($section)->appendTailwinds(['items-center', 'h-24']);

// @jquery
$btn = Button::addTo($grid)->setLabel('Toggle Segment');
$segment = View\Segment::addTo($grid)->setTextContent('I might disapear');
// adding jQuery click event to button.
Jquery::addEventTo($btn, 'click')
    ->executes([Jquery::withThis()->text('Toggle Segment'), Jquery::withView($segment)->toggle()]);
// adding jQuery mouseover event to segment.
Jquery::addEventTo($segment, 'mouseover')
    ->executes([Jquery::withThis()->toggle(), Jquery::withView($btn)->text('Bring me back!')]);
// @end_jquery

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('jquery'));

DemoApp::addLineInfo($section, 'Rendered html:');
DemoApp::addCodeConsole($section, 'html')
    ->setTextContent($btn->getHtml() . \PHP_EOL . $segment->getHtml());

DemoApp::addLineInfo($section, 'Rendered script:');
DemoApp::addCodeConsole($section, 'javascript')
    ->setTextContent($btn->getJavascript() . \PHP_EOL . $segment->getJavascript());

$section = DemoApp::addInfoSection(Ui::layout(), 'Example of Jquery::addEventTo using custom selector');

$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);

// @jquerySelector
$bar = View::addTo($container);
foreach (str_split('Click-me') as $letter) {
    if (trim($letter)) {
        Button::addTo($bar, ['label' => $letter, 'color' => 'info'])->removeTailwind('mx-2');
    }
}
// Target button inside $bar view.
Jquery::addEventTo($bar, 'click', 'button')->execute(Jquery::withThis()->toggle());
// @end_jquerySelector
DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)
    ->setTextContent($codeReader->extractCode('jquerySelector'));

DemoApp::addHeader(Ui::layout(), 'jQuery plugin', 4);

$html = 'Fohn-Ui js package comes with some jQuery plugins. One of them being the reload-view plugin used for reloading
a specific View instance on the page. <br>It can be used with JsReload class
helper method: <code class="text-sm bg-gray-200 p-1 font-bold">JsReload::view(View $view, array $args)</code>.
<br> JsReload may also pass GET arguments to the callback url.';
DemoApp::addParagraph(Ui::layout(), $html, false);

$section = DemoApp::addInfoSection(Ui::layout(), 'Using JsReload:');
$container = View::addTo($section)->appendTailwinds(['grid', 'place-content-center']);

// @jqueryReload
// Reload button and add a number to the button label.
$number = $_GET['number'] ?? '';
$b = Button::addTo($container, ['label' => 'Reload ' . $number]);
Jquery::addEventTo($b, 'click')
    ->execute(
        JsReload::view($b, ['number ' => random_int(0, 100)])
            ->afterSuccess(
                Js::from('console.log("reloaded btn")')
            )
    );
// @end_jqueryReload

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)
    ->setTextContent($codeReader->extractCode('jqueryReload'));

DemoApp::addLineInfo($section, 'Use the afterSuccess method of JsReload that allow to execute javascript expressions when
reload is complete.');
