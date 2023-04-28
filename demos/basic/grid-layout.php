<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;
use Fohn\Ui\View\GridLayout;

require_once __DIR__ . '/../init-ui.php';

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());
$subtitles = [
    'Display views in a grid layout.',
];
DemoApp::addPageHeaderTo($grid, 'Grid', $subtitles);
DemoApp::addGithubButton($grid);

$viewStyle =
    [
        'text-white',
        'flex',
        'items-center',
        'justify-center',
        'font-extrabold',
    ];

/**
 * Utility for adding a certain number of views into a grid.
 */
function gridDemo(GridLayout $grid, int $number, array $style, bool $useColPan = false): void
{
    $style[] = $useColPan ? 'bg-blue-300' : 'bg-blue-600';
    for ($x = 1; $x < $number + 1; ++$x) {
        $v = View::addTo($grid)->setTextContent((string) $x)->appendTailwinds($style)->appendTailwind(Tw::height('12'));
        if ($useColPan && $x === 4 || $useColPan && $x === 7) {
            $v->appendTailwinds([Tw::gridCol('span', '2'), 'bg-blue-600']);
        }
    }
}

/**
 * Create Views to display in SpanDemo.
 */
function gridSpanDemo(GridLayout $grid, array $style): void
{
    $grid->appendTailwind('h-64');
    $style[] = Tw::bgColor('info');
    View::addTo($grid)->setTextContent('1')->appendTailwinds($style)->appendTailwinds([Tw::gridRow('span', '3')]);
    View::addTo($grid)->setTextContent('2')->appendTailwinds($style)->appendTailwinds([Tw::gridCol('span', '2')]);
    View::addTo($grid)->setTextContent('3')->appendTailwinds($style)->appendTailwinds([Tw::gridRow('span', '2'), Tw::gridCol('span', '2')]);
}

/**
 * Create Views to display in StartDemo.
 */
function gridStartDemo(GridLayout $grid, array $style): void
{
    $grid->appendTailwind('h-64');
    $style[] = 'bg-blue-600';
    View::addTo($grid)->setTextContent('1')->appendTailwinds($style)->appendTailwinds([Tw::gridCol('start', '2'), Tw::gridCol('span', '4')]);
    View::addTo($grid)->setTextContent('2')->appendTailwinds($style)->appendTailwinds([Tw::gridCol('start', '1'), Tw::gridCol('end', '3')]);
    View::addTo($grid)->setTextContent('3')->appendTailwinds($style)->appendTailwinds([Tw::gridCol('end', '7'), Tw::gridCol('span', '2')]);
    View::addTo($grid)->setTextContent('4')->appendTailwinds($style)->appendTailwinds([Tw::gridCol('start', '1'), Tw::gridCol('end', '7')]);
}

$section = DemoApp::addInfoSection(Ui::layout(), 'Various Grid options');
DemoApp::addLineInfo($section, 'Grid using row direction.');

$gridLayout = GridLayout::addTo($section, ['columns' => 3, 'rows' => 3]);
gridDemo($gridLayout, 9, $viewStyle);

DemoApp::addLineInfo($section, 'Grid using col direction.');
$gridLayout = GridLayout::addTo($section, ['columns' => 3, 'rows' => 3, 'direction' => 'col']);
gridDemo($gridLayout, 9, $viewStyle);

DemoApp::addLineInfo($section, 'Grid col span utility.');
$gridLayout = GridLayout::addTo($section, ['columns' => 3, 'rows' => 3]);
gridDemo($gridLayout, 7, $viewStyle, true);

DemoApp::addLineInfo($section, 'Grid row/col span utility.');

$gridLayout = GridLayout::addTo($section, ['columns' => 3, 'rows' => 3, 'direction' => 'col']);
gridSpanDemo($gridLayout, $viewStyle);

DemoApp::addLineInfo($section, 'Grid col start/end utility.');

$gridLayout = GridLayout::addTo($section, ['columns' => 6, 'rows' => 3, 'direction' => 'col']);
gridStartDemo($gridLayout, $viewStyle);
