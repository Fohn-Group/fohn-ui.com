<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\View\Icon;
use Fohn\Ui\View\Link;

require_once __DIR__ . '/../init-ui.php';

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Uses of Tailwinds state modifier: Active, Focus, Hover and Disable.',
    'Colors are from Fohn-UI theme and therefore easyly customisable.',
];
DemoApp::addPageHeaderTo($grid, 'Link/Button', $subtitles);
DemoApp::addGithubButton($grid);

// Demonstrates how to use links.
$section = DemoApp::addInfoSection(Ui::layout(), 'Link:');
Link::addTo($section)->setUrl(Ui::parseRequestUrl())->setTextContent('click here');

// Demonstrates how to use buttons.
$section = DemoApp::addInfoSection(Ui::layout(), 'Contained type:');

$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);

Button::addTo($bar, ['label' => 'Primary']);
Button::addTo($bar, ['label' => 'Secondary', 'color' => 'secondary']);
Button::addTo($bar, ['label' => 'Info', 'color' => 'info']);
Button::addTo($bar, ['label' => 'Success', 'color' => 'success']);
Button::addTo($bar, ['label' => 'Warning', 'color' => 'warning']);
Button::addTo($bar, ['label' => 'Error', 'color' => 'error']);
Button::addTo($bar, ['label' => 'Neutral', 'color' => 'neutral']);

$section = DemoApp::addInfoSection(Ui::layout(), 'Outline type:');
$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);
Button::addTo($bar, ['label' => 'Primary'])->setType('outline');
Button::addTo($bar, ['label' => 'Secondary', 'color' => 'secondary'])->setType('outline');
Button::addTo($bar, ['label' => 'Info', 'color' => 'info'])->setType('outline');
Button::addTo($bar, ['label' => 'Success', 'color' => 'success'])->setType('outline');
Button::addTo($bar, ['label' => 'Warning', 'color' => 'warning'])->setType('outline');
Button::addTo($bar, ['label' => 'Error', 'color' => 'error'])->setType('outline');
Button::addTo($bar, ['label' => 'Neutral', 'color' => 'neutral'])->setType('outline');

$section = DemoApp::addInfoSection(Ui::layout(), 'Text type:');
$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);
Button::addTo($bar, ['label' => 'Primary'])->setType('text');
Button::addTo($bar, ['label' => 'Secondary', 'color' => 'secondary'])->setType('text');
Button::addTo($bar, ['label' => 'Info', 'color' => 'info'])->setType('text');
Button::addTo($bar, ['label' => 'Success', 'color' => 'success'])->setType('text');
Button::addTo($bar, ['label' => 'Warning', 'color' => 'warning'])->setType('text');
Button::addTo($bar, ['label' => 'Error', 'color' => 'error'])->setType('text');
Button::addTo($bar, ['label' => 'Neutral', 'color' => 'neutral'])->setType('text');

$section = DemoApp::addInfoSection(Ui::layout(), 'Link type:');
$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);
Button::addTo($bar, ['label' => 'Click Here'])->setType('link');

$section = DemoApp::addInfoSection(Ui::layout(), 'Using icon:');
$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);
Button::addTo($bar, ['label' => 'Home'])->addIcon(new Icon(['iconName' => 'bi-house-fill']));
Button::addTo($bar, ['label' => 'Play', 'type' => 'outline', 'color' => 'info'])->addIcon(new Icon(['iconName' => 'bi-play-circle']), 'right');
Button::addTo($bar, ['iconName' => 'bi-download']);

$section = DemoApp::addInfoSection(Ui::layout(), 'Button\'s Size :');
$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);
Button::addTo($bar, ['label' => 'Tiny', 'color' => 'neutral'])->setSize('tiny');
Button::addTo($bar, ['label' => 'Small', 'color' => 'neutral'])->setSize('small');
Button::addTo($bar, ['label' => 'Normal', 'color' => 'neutral']);
Button::addTo($bar, ['label' => 'Large', 'color' => 'neutral'])->setSize('large');

$section = DemoApp::addInfoSection(Ui::layout(), 'Button\'s Shape:');
$bar = View::addTo($section, ['defaultTailwind' => ['inline-block, my-4']]);
Button::addTo($bar, ['iconName' => 'bi-house-fill'])->setShape('square');
Button::addTo($bar, ['iconName' => 'bi-house-fill', 'color' => 'neutral'])->setShape('circle');
Button::addTo($bar, ['label' => 'Rounded', 'color' => 'secondary'])->setShape('circle');

$section = DemoApp::addInfoSection(Ui::layout(), 'Button\'s State:');
$grid = DemoApp::addTwoColumnsResponsiveGrid($section)
    ->appendTailwinds(['text-center', 'place-items-center']);

Button::addTo($grid, ['label' => 'Primary'])->disableUsingHtml();
Button::addTo($grid, ['label' => 'Primary'])->appendCssClasses('loading');
