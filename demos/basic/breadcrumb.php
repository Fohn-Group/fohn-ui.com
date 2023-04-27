<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View\Breadcrumb;

require_once __DIR__ . '/../init-ui.php';

$pages = ['Home', 'Product', 'Electronic', 'Computer'];
$addBreadcrumbItems = function (Breadcrumb $breadcrumb, array $items, string $separator = '/') {
    foreach ($items as $k => $item) {
        $isLast = $k === count($items) - 1;
        if (!$isLast) {
            $breadcrumb->addLink($item, '#', $isLast, $separator);
        } else {
            $breadcrumb->addLast($item);
        }
    }
};

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Extends Lister Class.',
];
DemoApp::addPageHeaderTo($grid, 'Breadcrumb', $subtitles);
DemoApp::addGithubButton($grid);

$section = DemoApp::addInfoSection(Ui::layout(), 'Breadcrumb');
DemoApp::addLineInfo($section, 'Default breadcrumb :');

$breadcrumb = Breadcrumb::addTo($section);
$addBreadcrumbItems($breadcrumb, $pages);
DemoApp::addVerticalSpacer($section, '10');

DemoApp::addLineInfo($section, 'Using seperator \'>\' :');
$breadcrumb = Breadcrumb::addTo($section);
$addBreadcrumbItems($breadcrumb, $pages, '>');

DemoApp::addVerticalSpacer($section, '10');

DemoApp::addLineInfo($section, 'Using theme color :');
$breadcrumb = Breadcrumb::addTo($section, ['textColor' => 'info']);
$addBreadcrumbItems($breadcrumb, $pages, '•');
$breadcrumb->appendTailwinds(['shadow', 'p-4', 'rounded-md', 'border']);
