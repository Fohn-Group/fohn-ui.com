<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Tag;

require_once __DIR__ . '/../init-ui.php';

$img = '../images/fohn-logo.png';

function getLabeBar(): View
{
    return (new View())->appendTailwinds(['flex', 'inline-block', 'mx-2']);
}

$subtitles = [
    'Tags are used to label, organize, or categorize objects.',
    'Tags can also serve as a label for content or display counts.',
];
DemoApp::addPageHeaderTo(Ui::layout(), 'Tag', $subtitles);

$section = DemoApp::addInfoSection(Ui::layout(), 'Tags');
DemoApp::addLineInfo($section, 'Use theme colors and/or icon.');
$labelBar = $section->addView(getLabeBar());
Tag::addTo($labelBar, ['text' => 'Hot!']);
Tag::addTo($labelBar, ['text' => '23', 'iconName' => 'bi-envelope', 'color' => 'info']);
Tag::addTo($labelBar, ['text' => 'Item', 'iconName' => 'bi-trash2', 'color' => 'error']);

DemoApp::addLineInfo($section, 'Display icon to left or right of text or use icon only.');
$labelBar = $section->addView(getLabeBar());
Tag::addTo($labelBar, ['text' => 'Logo', 'imageSrc' => $img]);
Tag::addTo($labelBar, ['text' => 'Beer', 'iconName' => 'bi-cup-straw', 'placement' => 'left']);
Tag::addTo($labelBar, ['text' => 'Here', 'iconName' => 'bi-bullseye', 'color' => 'error', 'placement' => 'left']);
Tag::addTo($labelBar, ['iconName' => 'bi-camera']);

DemoApp::addLineInfo($section, 'Using rounded shape.');

$labelBar = $section->addView(getLabeBar());
Tag::addTo($labelBar, ['text' => 'Logo', 'imageSrc' => $img, 'shape' => 'rounded']);
Tag::addTo($labelBar, ['text' => 'Beer', 'iconName' => 'bi-cup-straw', 'placement' => 'left', 'shape' => 'rounded']);
Tag::addTo($labelBar, ['text' => 'Here', 'iconName' => 'bi-bullseye', 'color' => 'error', 'placement' => 'left', 'shape' => 'rounded']);
Tag::addTo($labelBar, ['iconName' => 'bi-camera', 'shape' => 'rounded']);

DemoApp::addLineInfo($section, 'Using outline type.');

$labelBar = $section->addView(getLabeBar());
Tag::addTo($labelBar, ['text' => 'Beers: 3', 'iconName' => 'bi-cup-straw', 'type' => 'outline']);
Tag::addTo($labelBar, ['text' => 'Here', 'iconName' => 'bi-bullseye', 'color' => 'error', 'placement' => 'left', 'type' => 'outline']);
