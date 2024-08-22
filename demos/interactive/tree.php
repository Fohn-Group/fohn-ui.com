<?php

declare(strict_types=1);

use Fohn\Demos\CodeReader;
use Fohn\Demos\DemoApp;
use Fohn\Demos\Model\File;
use Fohn\Ui\Component\Tabs;
use Fohn\Ui\Component\Tabs\Tab;
use Fohn\Ui\Component\Tree;
use Fohn\Ui\Js\JsRenderInterface;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\Service\Data;
use Fohn\Ui\Service\Ui;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new CodeReader(__FILE__);

$fileModel = new File(Data::db());
$mode = $_GET['mode'] ?? 'single';
$allowFolderSelect = ($_GET['folder'] ?? null) === null;

$grid = DemoApp::addTwoColumnsResponsiveGrid(Ui::layout());

$subtitles = [
    'Display hierarchical data using Tree component.',
    'Enable data node selection.',
];
DemoApp::addPageHeaderTo($grid, 'Tree Component', $subtitles);
DemoApp::addGithubButton($grid);

$demoTabs = Tabs::addTo(Ui::layout());
$introTab = $demoTabs->addTab(new Tab(['name' => 'feature', 'caption' => 'Features']));
$sampleTab = $demoTabs->addTab(new Tab(['name' => 'example', 'caption' => 'Example']));

$text = 'The Tree component allow the user to view data in a hierarchical manner as well as allowing node selection.
One or many nodes selected may then be send back to the server via callback in order to be process by it.';
DemoApp::addParagraph($introTab, $text, false);

$text = 'Note: Fohn-Ui Tree component extend PrimeVue Tree component. <code class="text-sm bg-gray-200 p-1 font-bold">Fohn\Ui\Component\Tree</code> has
a class property <code class="text-sm bg-gray-200 p-1 font-bold">array $ptProps = []</code> that is used to pass props directly to the PrimeVue
component.<br> For more information: <a href="https://primevue.org/tree/" target="_blank" class="font-bold cursor underline">PrimeVue Tree</a>';
DemoApp::addParagraph($introTab, $text, false)->appendTailwinds(['italic']);

DemoApp::addHeader($introTab, 'Basic', 5);
$text = 'The Tree component takes an array of Nodes to be display as items.';
DemoApp::addParagraph($introTab, $text, false);

$section = DemoApp::addInfoSection($introTab, 'Nodes sample:');

// @nodeSample
$nodes = [
    [
        'key' => 'document',
        'label' => 'Documents',
        'data' => 'Documents Folder',
        'icon' => 'bi bi-folder',
        'children' => [
            [
                'key' => 'work',
                'label' => 'Works',
                'data' => 'Works Folder',
                'icon' => 'bi bi-gear',
                'children' => [
                    ['key' => 'expense', 'label' => 'Expenses.doc', 'data' => 'Expenses.doc', 'icon' => 'bi bi-filetype-doc'],
                    ['key' => 'resume', 'label' => 'Resume.doc', 'data' => 'Resume.doc', 'icon' => 'bi bi-filetype-doc'],
                ],
            ],
            [
                'key' => 'home',
                'label' => 'Home',
                'data' => 'Home Folder',
                'icon' => 'bi bi-house',
                'children' => [
                    ['key' => 'invoice', 'label' => 'Invoices.txt', 'data' => 'Invoice.txt', 'icon' => 'bi bi-filetype-txt'],
                ],
            ],
        ],
    ],
];
// @end_nodeSample

DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('nodeSample'));

$section = DemoApp::addInfoSection($introTab, 'Tree using nodes sample :');

// @treeSample
$tree = Tree::addTo($section, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
// @end_treeSample
DemoApp::addCodeConsole($section)->setTextContent($codeReader->extractCode('treeSample'));

DemoApp::addHeader($introTab, 'Selection', 5);
$text = 'There is three selection mode available using the <code class="text-sm bg-gray-200 p-1 font-bold">Tree::setSelectionMode()</code>
method of the Tree component class: "single", "multipe" or "checkbox" ';
DemoApp::addParagraph($introTab, $text, false);

$selSection = DemoApp::addInfoSection($introTab, 'Tree sample using different selection mode:');
DemoApp::addParagraph($selSection, 'Single:', false);

$tree = Tree::addTo($selSection, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
$tree->setSelectionMode('single');

DemoApp::addParagraph($selSection, 'Multiple:', false);
$tree = Tree::addTo($selSection, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
$tree->setSelectionMode('multiple');

DemoApp::addParagraph($selSection, 'Checkbox:', false);
$tree = Tree::addTo($selSection, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
$tree->setSelectionMode('checkbox');

DemoApp::addHeader($introTab, 'Event', 5);
$text = 'Tree component can trigger server callbacks and send node selection to the server. Two events are supported.
A node changed event, triggering callback on every user selection, or a post event, which will send the entire selection to the server via Save button.';
DemoApp::addParagraph($introTab, $text, false);

$eventSection = DemoApp::addInfoSection($introTab, 'Using node changed and post events:');
$text = 'Each callback function must return a JsRenderInterface object. For example, returning a notification
 to the user.';
DemoApp::addParagraph($eventSection, $text, false);

$tree = Tree::addTo($eventSection, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
$tree->setSelectionMode('multiple');

// @onNodeChanged
$tree->onTreeNodeChanged(static function ($action, $key): JsRenderInterface {
    // Process callback and return notification to user.
    return JsToast::notify(ucfirst($action), 'Key: ' . $key);
});
// @end_onNodeChanged
DemoApp::addCodeConsole($eventSection)->setTextContent($codeReader->extractCode('onNodeChanged'));

$tree = Tree::addTo($eventSection, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
$tree->setSelectionMode('checkbox');

// @onPost
$tree->onTreePost(static function ($keys, $rawValue): JsRenderInterface {
    // Process callback and return notification to user.
    return JsToast::notify('Post: ', 'value: ' . implode(', ', $keys));
});
// @end_onPost
DemoApp::addCodeConsole($eventSection)->setTextContent($codeReader->extractCode('onPost'));

DemoApp::addHeader($introTab, 'Filter', 5);
$text = 'Tree nodes can be filter by passing an array of node fields where filtering will be applied.';
DemoApp::addParagraph($introTab, $text, false);

$filterSection = DemoApp::addInfoSection($introTab, 'Filtering label:');
$tree = Tree::addTo($filterSection, ['ptProps' => ['expandedKeys' => ['document' => true]]]);
$tree->setNodes($nodes);
// @treeFilter
$tree->setFilter(['label'], 'lenient', 'Search document');
// @end_treeFilter
DemoApp::addCodeConsole($filterSection)->setTextContent($codeReader->extractCode('treeFilter'));

// ////// SAMPLE TAB /////////
$sampleSection = DemoApp::addInfoSection($sampleTab, 'Tree example:');

$tree = Tree::addTo($sampleSection);

$tree->setNodes($fileModel->getFilesHierarchy($allowFolderSelect));
$tree->setSelectionMode('multiple')
    ->setHeight('500px')
    ->setFilter(['label', 'type'], 'lenient', 'Search file');

$tree->onTreePost(static function ($keys, $rawValue): JsRenderInterface {
    return JsToast::notify('Post: ', 'value: ' . implode(', ', $keys));
});

Ui::viewDump($tree, 'tree');
