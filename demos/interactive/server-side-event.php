<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Callback\ServerEvent;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\JsStatements;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\View\GridLayout;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\CodeReader(__FILE__);

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Streaming event usages.',
];
DemoApp::addPageHeaderTo($grid, 'Server Side Event', $subtitles);
DemoApp::addGithubButton($grid);

$section = DemoApp::addInfoSection(Ui::layout(), 'Server event streaming example:');
DemoApp::addLineInfo($section, 'You can use server event to send Javascript instruction.');

$gridLayout = GridLayout::addTo($section, ['columns' => 1, 'rows' => 2, 'direction' => 'col']);

$row = View::addTo($gridLayout)->appendTailwinds([Tw::marginX('auto'), Tw::marginY('4')]);
/** @var View\Chip $counter */
$counter = View\Chip::addTo($row, ['color' => 'secondary'])->appendTailwinds(['absolute', 'z-10'])->setTextContent('0');
$ping = View\Chip::addTo($row, ['color' => 'secondary']);

$row = View::addTo($gridLayout)->appendTailwinds([Tw::marginX('auto'), Tw::marginY('auto')]);
$startBtn = Button::addTo($row)->setLabel('Start');
$stopBtn = Button::addTo($row)->setLabel('Stop');
Jquery::onDocumentReady($stopBtn)->attr('disabled', true);

// @sse
$sse = ServerEvent::addAbstractTo(Ui::layout(), ['keepAlive' => false, 'minBufferSize' => 4096]);

// Jquery actions to execute when starting ServerSide event.
$startSseEvents = JsStatements::with([
    Jquery::withView($ping)->toggleClass('animate-ping'),
    Jquery::withView($counter->content)->text(0),
    Jquery::withView($startBtn)->attr('disabled', true),
    Jquery::withView($stopBtn)->attr('disabled', false),
]);

// Jquery actions to execute when stopping ServerSide event.
$stopSseEvents = JsStatements::with([
    Jquery::withView($ping)->toggleClass('animate-ping'),
    Jquery::withView($startBtn)->attr('disabled', false),
    Jquery::withView($stopBtn)->attr('disabled', true),
]);

// Fire sse via button.
Jquery::addEventTo($startBtn, 'click')->execute($sse->start($startSseEvents));
Jquery::addEventTo($stopBtn, 'click')->execute($sse->stop($stopSseEvents));

// When ServerSide event is fire.
$sse->onRequest(function (ServerEvent $sse) use ($counter, $stopSseEvents) {
    for ($i = 1; $i < 26; ++$i) {
        $sse->executeJavascript(Jquery::withView($counter->content)->text($i));
        sleep(1);
    }
    $sse->executeJavascript($stopSseEvents);
}, []);

// @end_sse

DemoApp::addLineInfo($section, 'Code:');
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('sse'));
