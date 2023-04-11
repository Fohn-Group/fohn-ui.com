<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Core\Utils;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Js\JsReload;
use Fohn\Ui\Page;
use Fohn\Ui\PageLayout\Layout;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\VirtualPage;

require_once __DIR__ . '/../init-ui.php';

$subtitles = [
    'Virtual Page are only display when trigger by the user.',
];
DemoApp::addPageHeaderTo(Ui::layout(), 'Virtual Pages', $subtitles);

DemoApp::addLineInfo(Ui::layout(), 'Demonstrating how virtual page can be add within each other.');

$vp = VirtualPage::with(DemoApp::createPage(Ui::service()->environment));

$vp->onPageRequest(function ($page) use ($vp) {
    $breadCrumb = View\Breadcrumb::addTo($page);
    $breadCrumb->addLink('Virtual Page Demo', Ui::parseRequestUrl());
    $breadCrumb->addLast('Top Virtual Page');

    View\Heading\Header::addTo($page, ['size' => 6, 'title' => 'Top Page Content']);
    View\Segment::addTo($page)->setText(Utils::getLoremIpsum(12));

    $vp2 = VirtualPage::with(DemoApp::createPage(Ui::service()->environment));
    $vp2->onPageRequest(function ($page) use ($vp) {
        $breadCrumb = View\Breadcrumb::addTo($page);
        $breadCrumb->addLink('Virtual Page Demo', Ui::parseRequestUrl());
        $breadCrumb->addLink('Top Virtual Page', $vp->getUrl());
        $breadCrumb->addLast('Inner Virtual Page');

        View\Heading\Header::addTo($page, ['size' => 6, 'title' => 'Inner Page Content']);
        $segment = View\Segment::addTo($page)->setText(Utils::getLoremIpsum((int) 50));

        $b = Button::addTo($page, ['label' => 'Reload Loren Ipsum', 'color' => 'secondary', 'type' => 'text']);
        Jquery::addEventTo($b, 'click')->execute(JsReload::view($segment));
    });

    // button that trigger virtual page.
    $btn = View\Button::addTo($page, ['label' => 'Open Inner Virtual Page', 'type' => 'text', 'color' => 'secondary']);
    $btn->jsLinkTo($vp2->getUrl());
});

// button that trigger virtual page.
$btn = View\Button::addTo(Ui::layout(), ['label' => 'Open Virtual Page', 'color' => 'secondary', 'type' => 'text']);
$btn->jsLinkTo($vp->getUrl());

DemoApp::addLineInfo(Ui::layout(), 'Demonstrating virtual page using other layout.');

$page = Page::factory()->addLayout(Layout::factory(['template' => Ui::templateFromFile(__DIR__ . '/template/center-layout.html')]));

$vp2 = VirtualPage::with($page);
$vp2->onPageRequest(function ($page) {
    View\Heading\Header::addTo($page, ['title' => 'Center Layout', 'size' => 5])->removeTailwind('mt-6');
    $segment = View\Segment::addTo($page)->setText(Utils::getLoremIpsum((int) 50));
    $btn = View\Button::addTo($page, ['label' => 'Back', 'color' => 'secondary', 'type' => 'text']);
    $btn->jsLinkTo(Ui::parseRequestUrl());
});

// button that trigger virtual page.
$btn = View\Button::addTo(Ui::layout(), ['label' => 'Display in a new layout', 'color' => 'secondary', 'type' => 'text']);
$btn->jsLinkTo($vp2->getUrl());
