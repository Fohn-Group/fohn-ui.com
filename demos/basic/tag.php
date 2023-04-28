<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Tag;

require_once __DIR__ . '/../init-ui.php';

$img = '../../images/fohn-logo.png';

/**
 * Create an inline bar view where tag are placed.
 */
function getLabeBar(): View
{
    return (new View())->appendTailwinds(['flex', 'inline-block', 'mx-2']);
}

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());
$subtitles = [
    'Tags are used to label, organize, or categorize objects.',
    'Tags can also serve as a label for content or display counts.',
];
DemoApp::addPageHeaderTo($grid, 'Tag', $subtitles);
DemoApp::addGithubButton($grid);

$section = DemoApp::addInfoSection(Ui::layout(), 'Tags');

DemoApp::addLineInfo($section, 'Use theme colors and/or icon.');
$labelBar = $section->addView(getLabeBar());

Tag::addTo($labelBar)->setTextContent('Hot!');
Tag::addTo($labelBar, ['iconName' => 'bi-envelope', 'color' => 'info'])->setTextContent('23');
Tag::addTo($labelBar, ['iconName' => 'bi-trash2', 'color' => 'error'])->setTextContent('Item');

DemoApp::addLineInfo($section, 'Display icon to left or right of text or use icon only.');
$labelBar = $section->addView(getLabeBar());

Tag::addTo($labelBar, ['imageSrc' => $img])->setTextContent('Logo');
Tag::addTo($labelBar, ['iconName' => 'bi-cup-straw', 'placement' => 'left'])->setTextContent('Beer');
Tag::addTo($labelBar, ['iconName' => 'bi-bullseye', 'color' => 'error', 'placement' => 'left'])->setTextContent('Here');
Tag::addTo($labelBar, ['iconName' => 'bi-camera']);

DemoApp::addLineInfo($section, 'Using rounded shape.');
$labelBar = $section->addView(getLabeBar());

Tag::addTo($labelBar, ['imageSrc' => $img, 'shape' => 'rounded'])->setTextContent('Logo');
Tag::addTo($labelBar, ['iconName' => 'bi-cup-straw', 'placement' => 'left', 'shape' => 'rounded'])->setTextContent('Beer');
Tag::addTo($labelBar, ['iconName' => 'bi-bullseye', 'color' => 'error', 'placement' => 'left', 'shape' => 'rounded'])->setTextContent('Here');
Tag::addTo($labelBar, ['iconName' => 'bi-camera', 'shape' => 'rounded']);

DemoApp::addLineInfo($section, 'Using outline type.');
$labelBar = $section->addView(getLabeBar());

Tag::addTo($labelBar, ['iconName' => 'bi-cup-straw', 'type' => 'outline'])->setTextContent('Beers: 3');
Tag::addTo($labelBar, ['iconName' => 'bi-bullseye', 'color' => 'error', 'placement' => 'left', 'type' => 'outline'])->setTextContent('Here');
