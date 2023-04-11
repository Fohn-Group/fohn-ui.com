<?php

declare(strict_types=1);

/**
 * Utility class for the Demo application.
 */

namespace Fohn\Demos;

use Fohn\Ui\Component\Navigation\Group;
use Fohn\Ui\Component\Navigation\Item;
use Fohn\Ui\Js\JsChain;
use Fohn\Ui\Page;
use Fohn\Ui\PageLayout\SideNavigation;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\Tailwind\Theme\Fohn;
use Fohn\Ui\Tailwind\Tw;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\View\Heading\SectionHeader;

class DemoApp
{
    public static function createPage(string $environment = 'production'): Page
    {
        /** @var Page $page */
        $page = Page::factory([
            'title' => 'Fohn-ui: ' . preg_replace('/\/demos\/|\.php/m', '', Ui::serverRequest()->getUri()->getPath()),
        ]);

        if ($environment === 'dev') {
            $page->includeJsPackage('fohn-js', '/public/fohn-ui.js');
            $page->includeCssPackage('fohn-css', '/public/fohn-ui.css');
        }

        // Add Admin layout to this page.
        $page->addLayout(SideNavigation::factory(['topBarTitle' => 'Fohn-Ui Demo']));

        /** @var SideNavigation $layout */
        $layout = $page->getLayout();
        // Add footer to this page.
        $layout->addView(View::factory(['text' => 'Made with Fohn - Ui']), 'footer');

        foreach (self::getNavigationGroup() as $group) {
            $layout->addNavigationGroup($group);
        }

        return $page;
    }

    private static function getNavigationGroup(string $baseUrl = '/'): array
    {
        return [
            new Group([
                'name' => 'Introduction',
                'url' => $baseUrl . 'demos/',
                'items' => [],
            ]),
            new Group([
                'name' => 'Basics',
                'icon' => 'bi bi-box',
                'url' => $baseUrl . 'demos/basic/view/',
                'items' => [
                    new Item(['name' => 'View', 'url' => $baseUrl . 'demos/basic/view/']),
                    new Item(['name' => 'Button/Link', 'url' => $baseUrl . 'demos/basic/button/']),
                    new Item(['name' => 'Header', 'url' => $baseUrl . 'demos/basic/header/']),
                    new Item(['name' => 'Message', 'url' => $baseUrl . 'demos/basic/message/']),
                    new Item(['name' => 'Tag', 'url' => $baseUrl . 'demos/basic/tag/']),
                    new Item(['name' => 'Grid', 'url' => $baseUrl . 'demos/basic/grid-layout/']),
                    new Item(['name' => 'List', 'url' => $baseUrl . 'demos/basic/list/']),
                    new Item(['name' => 'Breadcrumb', 'url' => $baseUrl . 'demos/basic/breadcrumb/']),
                ],
            ]),
            new Group([
                'name' => 'Form',
                'icon' => 'bi bi-input-cursor',
                'url' => $baseUrl . 'demos/form/basic/',
                'items' => [
                    new Item(['name' => 'Basic Layout', 'url' => $baseUrl . 'demos/form/basic/']),
                    new Item(['name' => 'Custom Layout', 'url' => $baseUrl . 'demos/form/layout/']),
                    new Item(['name' => 'Input Template', 'url' => $baseUrl . 'demos/form/input-template/']),
                    new Item(['name' => 'Controls', 'url' => $baseUrl . 'demos/form/control/']),
                ],
            ]),
            new Group([
                'name' => 'Collection',
                'icon' => 'bi bi-collection',
                'url' => $baseUrl . 'demos/collection/table/',
                'items' => [
                    new Item(['name' => 'Table', 'url' => $baseUrl . 'demos/collection/table/']),
                    new Item(['name' => 'Table w. Atk Model', 'url' => $baseUrl . 'demos/collection/table-as-crud/']),
                ],
            ]),
            new Group([
                'name' => 'Javascript',
                'icon' => 'bi bi-code-slash',
                'url' => $baseUrl . 'demos/javascript/js/',
                'items' => [
                    new Item(['name' => 'jQuery Integration', 'url' => $baseUrl . 'demos/javascript/js/']),
                ],
            ]),
            new Group([
                'name' => 'Interactive',
                'icon' => 'bi bi-chat-left',
                'url' => $baseUrl . 'demos/interactive/virtual/',
                'items' => [
                    new Item(['name' => 'Modal', 'url' => $baseUrl . 'demos/interactive/modal/']),
                    new Item(['name' => 'Toast', 'url' => $baseUrl . 'demos/interactive/toast/']),
                    new Item(['name' => 'Virtual Page', 'url' => $baseUrl . 'demos/interactive/virtual/']),
                    new Item(['name' => 'Server Side Event', 'url' => $baseUrl . 'demos/interactive/sse/']),
                    new Item(['name' => 'Console', 'url' => $baseUrl . 'demos/interactive/console/']),
                ],
            ]),
        ];
    }

    /**
     * Create button suitable to use in a table action column.
     */
    public static function tableBtnFactory(string $iconName, string $color = 'info'): View\Button
    {
        $btn = new Button(['iconName' => $iconName, 'color' => $color, 'shape' => 'circle', 'size' => 'small', 'type' => 'text']);
        $btn->removeTailwind('mx-2');

        return $btn;
    }

    public static function tableCaptionFactory(string $caption): View
    {
        return new View([
            'defaultTailwind' => [
                'my-2',
                'text-lg',
                Tw::textColor('info'),
            ],
            'text' => $caption,
        ]);
    }

    public static function addCodeConsole(View $view, string $language = 'php'): View
    {
        if (!isset(Ui::page()->jsPackages['highlight'])) {
            Ui::page()->includeJsPackage(
                'highlight',
                'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js'
            );
            Ui::page()->includeCssPackage(
                'highlight',
                'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/github-dark.min.css'
            );

            // @phpstan-ignore-next-line
            Ui::page()->getLayout()->appendJsAction(JsChain::with('hljs')->highlightAll());
        }

        $pre = View::addTo($view)->setHtmlTag('pre')
            ->appendTailwinds(['p-4', 'my-6', 'overflow-auto', 'rounded-lg', 'max-h-72'])
            ->appendCssClasses('hljs');

        return View::addTo($pre)->setHtmlTag('code')->appendTailwind('language-' . $language);
    }

    public static function addPageHeaderTo(View $view, string $title, array $subTitles = [], string $region = 'Content'): View
    {
        $subTitleTws = [
            Tw::textColor('secondary'),
            'italic',
            'text-sm',
            'ml-4',
        ];

        $pageHeader = SectionHeader::addTo($view, [
            'title' => $title,
        ], $region)->setHeaderSize(4);
        $pageHeader->getHeaderView()->appendTailwind(Tw::textColor('primary'));

        foreach ($subTitles as $subtitle) {
            $pageHeader->addSubTitle($subtitle)->appendTailwinds($subTitleTws);
        }

        return $pageHeader;
    }

    public static function addLineInfo(View $view, string $text): View
    {
        return View::addTo($view)
            ->setText($text)
            ->setHtmlTag('p')
            ->appendTailwinds(['italic', 'mb-4', 'mt-6', 'first:mt-0']);
    }

    public static function addInfoSection(View $view, string $text, bool $isCenter = false): View
    {
        $container = View::addTo($view)->appendTailwinds(['w-full', 'mt-10', 'mb-4']);

        $header = View::addTo($container)->appendTailwinds(['rounded-t-lg', 'font-bold', 'p-3'])->setText($text);
        Fohn::colorAs('neutral', $header);

        $section = View::addTo($container)->appendTailwinds(['p-6', 'border', 'rounded-b-lg']);

        if ($isCenter) {
            $section->appendTailwinds(['grid', 'grid-cols-1', 'justify-items-center']);
        }

        return $section;
    }

    public static function addVerticalSpacer(View $view, string $space): View
    {
        $tw = 'my-' . $space;

        return View::addTo($view)->appendTailwind($tw);
    }

    public static function addTwoColumnsResponsiveGrid(View $view): View\GridLayout
    {
        $grid = View\GridLayout::addTo($view, ['columns' => 1, 'rows' => 1, 'gap' => 4]);
        $grid->appendTailwinds(['md:grid-cols-2 ']);

        return $grid;
    }
}
