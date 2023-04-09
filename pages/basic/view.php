<?php

declare(strict_types=1);

// namespace Fohn\Ui\Demos;

use Fohn\Demos\DemoApp;
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
use Fohn\Ui\View\Divider;
use Fohn\Ui\View\GridLayout;
use Fohn\Ui\View\Heading\Header;
use Fohn\Ui\View\Segment;
use Fohn\Ui\View\Tag;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\DemoCodeReader(__FILE__, Ui::page());

$subtitles = [
    'View Class is the base class and at the hearth of Fohn-ui.',
    'View easily integrated with javascript and jQuery.',
];

DemoApp::addPageHeaderTo(Ui::layout(), 'View', $subtitles);

$section = DemoApp::addInfoSection(Ui::layout(), 'View can be added inside other Views.');

// @demo1
// Create a two column responsive grid.
$grid = DemoApp::addTwoColumnsResponsiveGrid($section)
    ->appendTailwinds( ['text-center', 'place-items-center']);

// add Outside view to the grid.
$outsideView = View::addTo($grid)->setText('Outside View')
    ->appendTailwinds(['border', 'border-gray-300', 'p-4', "w-1/2"]);

// Add innerView to the Outside view.
$innerView = View::addTo($outsideView)->setText('Inner View')
    ->appendTailwinds(['border', 'border-gray-300', 'p-4', 'bg-gray-100']);
// @end_demo1

DemoApp::addCodeConsole($section)->setText($codeReader->extractCode('demo1'));


$v = View::addTo($grid)->appendTailwinds(
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
View::addTo($in, ['text' => '$' . (random_int(100, 1000) / 100)]);

$section = DemoApp::addInfoSection(Ui::layout(), 'View may have Tailwind utilities css class.', true);

Segment::addTo($section)->setText('Segment')->appendTailwinds(
    [
        'lg:shadow',
        'w-1/3',
        'italic',
        'text-xl',
        'text-center',
        Tw::textColor('warning')
    ]
);

$section = DemoApp::addInfoSection(Ui::layout(), 'View may have Jquery events.');

$grid = DemoApp::addTwoColumnsResponsiveGrid($section);

$bb = View::addTo($grid);
Jquery::addEventTo($bb, 'click', 'button')->execute(Jquery::withThis()->toggle());
foreach (str_split('Click-me') as $letter) {
    if (trim($letter)) {
        Button::addTo($bb, ['label' => $letter, 'color' => 'info'])->removeTailwind('mx-2');
    }
}


$gLayout = GridLayout::addTo($grid, ['columns' => 2, 'rows' => 1, 'direction' => 'col']);

$container = View::addTo($gLayout)->appendTailwinds(['flex', 'justify-center']);
$boardingPassTemplate = new HtmlTemplate('<div id="{$idAttr}" {$attributes} class="cursor-pointer w-60 h-24 justify-center item-centers p-4 rounded-md {$classAttr}">
    <div class="flex-1 text-center">
        <div class="text-3xl">
          <i class="bi-airplane-fill"></i> {$num}
        </div>
        <div class="text-sm">
          Ticket
        </div>
    </div>
  </div>');
$boardingPassTemplate->set('num', (string) random_int(100, 999));

$boardingPass = View::addTo($container, ['template' => $boardingPassTemplate]);
Fohn::colorAs('warning', $boardingPass, 'outline');
$boardingPass->appendTailwinds(['outline-dashed', 'outline-2', 'outline-offset-2']);
Jquery::addEventTo($boardingPass, 'click')->execute(JsReload::view($boardingPass));

$buttons = GridLayout::addTo($gLayout, ['columns' => 1, 'rows' => 4]);

$b = Button::addTo($buttons, ['label' => 'Hide', 'iconName' => 'bi-eye-slash-fill', 'color' => 'neutral', 'shape' => 'wide'])->appendTailwind(Tw::width('36'));
Jquery::addEventTo($b, 'click')->execute(Jquery::withView($boardingPass)->hide());

$b = Button::addTo($buttons, ['label' => 'Show', 'iconName' => 'bi-eye-fill', 'color' => 'neutral',  'shape' => 'wide'])->appendTailwind(Tw::width('36'));
Jquery::addEventTo($b, 'click')->execute(Jquery::withView($boardingPass)->show());

$b = Button::addTo($buttons, ['label' => 'Reload', 'iconName' => 'bi-arrow-clockwise', 'color' => 'neutral',  'shape' => 'wide'])
    ->appendTailwind(Tw::width('36'));
// Add event to $b and execute an arrow function when reloaded.
Jquery::addEventTo($b, 'click')
    ->execute(
        JsReload::view($boardingPass, ['plane' => 1])
            ->afterSuccess(
                JsFunction::arrow([Variable::set('idAttr')])
                    // display button id in console.
                    ->execute(Js::from('console.log("Btn id: ", {{id}})', ['id' => $b->getIdAttribute()]))
                    // display boarding pass View as Jquery instance in console.
                    ->execute(Js::from('console.log("B. Pass Jquery instance: ", $(idAttr))'))
                    // call the arrow function using the boarding pass view id attribute.
                    ->immediatelyInvokeWith([Variable::set($boardingPass->getIdAttribute())])
            )
    );

$section = DemoApp::addInfoSection(Ui::layout(), 'View can be output to HTML including Javascript. Below is the above ticket view html and javascript output: ');

$pre = View::addTo($section)->setHtmlTag("pre")
    ->appendTailwinds(['p-4', 'my-6', 'bg-black',  'overflow-auto', 'rounded-md']);

$code = View::addTo($pre)->setHtmlTag('code')->appendTailwind('language-html')->setText($boardingPass->getHtml(true));
//Fohn::styleAs(Base::CONSOLE, [View::addTo($section, ['htmlTag' => 'pre'])->setText($boardingPass->getHtml(true))]);

//DemoApp::addLineInfo(Ui::layout(), 'View has a unique identifier. Below is the above ticket view html attribute id value: ');

Tag::addTo($section, ['text' => 'Ticket attr. Id: ' . $boardingPass->getIdAttribute(), 'color' => 'info']);
