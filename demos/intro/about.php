<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Js\Jquery;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View;
use Fohn\Ui\View\Button;
use Fohn\Ui\View\Heading\Header;
use Fohn\Ui\View\Segment;

require_once __DIR__ . '/../init-ui.php';

$codeReader = new \Fohn\Demos\CodeReader(__FILE__);
Header::addTo(Ui::layout(), ['title' => 'About Fohn-Ui', 'size' => 3]);

$html = 'Fohn-Ui is a PHP framework that make use of utility-first css framework: 
<a href="https://tailwindcss.com/" target="_blank" class="text-purple-700 underline">Tailwind CSS</a>.
This is a powerful combination for building and styling Web applications.';
DemoApp::addParagraph(Ui::layout(), $html, false);

$html = 'At the hearth of Fohn-Ui is the <b>Service\Ui::class</b>. 
This service main function is to supply various elements need by Fohn-Ui during the request life cycle:';
DemoApp::addParagraph(Ui::layout(), $html, false);

$serviceEl = [
    ['name' => 'the application class need for outputting content to browser;'],
    ['name' => 'the theme class used by views or components for styling purpose;'],
    ['name' => 'the rendered engine class for rendering Page into Html;'],
    ['name' => 'the Html template class for template content manipulation and rendering.'],
    ['name' => 'the PSR7 request object;'],
    ['name' => 'and many mores...'],
];
View\HtmlList::addTo(Ui::layout())->setItems($serviceEl);

$html = 'Minimal setup of the Ui service.';
DemoApp::addLineInfo(Ui::layout(), $html);

/*
// @ui_service
 // Minimal service setup.
 Ui::service()->boot(function (Ui $ui) {
    // set App.
    $ui->setApp(new App());
    // Add default exception handler.
    $ui->setExceptionHandler(PageException::factory());
    // Set page and layout to be output by App.
    $ui->initAppPage(Page::factory(['title' => 'myTitle']));
});
// @end_ui_service
 */
DemoApp::addCodeConsole(Ui::layout())->setTextContent($codeReader->extractCode('ui_service'));

$html = 'Once Ui service is boot, simply add content to your page layout using Ui::layout().';
DemoApp::addParagraph(Ui::layout(), $html);
DemoApp::addCodeConsole(Ui::layout())->setTextContent('View::addTo(Ui::layout())->setTextContent(\'Hello World!\');');
DemoApp::addLineInfo(Ui::layout(), 'Note that content is added to a page \'layout\' region and not the page itself.')
       ->removeTailwind('mt-6')
->appendTailwind('mx-4');

$html = 'This site is build using Fohn-Ui. If you wish to see how it is done, visit the 
<a href="https://github.com/fohn-group/fohn-ui.com" target="_blank" class="text-purple-700 underline">fohn-ui.com</a>  repository.';
DemoApp::addParagraph(Ui::layout(), $html, false);

////////////////// CSS
Header::addTo(Ui::layout(), ['title' => 'Default theme and css stylesheet', 'size' => 4])->appendTailwind('mt-6');

$html = 'Because Fohn-ui is built around Tailwind CSS, it is possible to create themes using PHP. This site use the default
Fohn-Ui theme and Tailwind CSS utilities set in css stylesheet are generated from this default theme. 
Complete new theme can easily be create; or new color recipes, for a specific theme, can be generated simply by overriding the default theme class.
';
DemoApp::addParagraph(Ui::layout(), $html);
DemoApp::addLineInfo(Ui::layout(), ' Many views in Fohn-Ui, like Button, are styled using the default theme:');
DemoApp::addCodeConsole(Ui::layout())->setTextContent('Ui::theme()->styleAs(\'Button\', [$btn])');


$html = 'The default theme generated a minimal set of Tailwind CSS utilities. However, it is possible
 to customize the Tailwind CSS utitlies needed for a project. <br/><br/> For more information on how to create a custom stylesheet, 
 visit the <a href="https://github.com/fohn-group/fohn-css" target="_blank" class="text-purple-700 underline">fohn-css</a> repository.';
DemoApp::addParagraph(Ui::layout(), $html, false);

///////////////// JS
Header::addTo(Ui::layout(), ['title' => 'Javascript', 'size' => 4])->appendTailwind('mt-6');
$html = 'Fohn-Ui comes with its own javascript package. The package contains functionalities needed for component user interface 
 and ensure a good user experience. The package contents vary from simple utilities functions, jQuery plugins or more complex Vue component.';
DemoApp::addParagraph(Ui::layout(), $html);

Header::addTo(Ui::layout(), ['title' => 'Vue.js', 'size' => 5])->appendTailwind('mt-6');
$html = 'Component like form, table or modal uses Vue.js in order to build their user interfaces. Most of the Vue components 
are renderless components, i.e. their templates are provide by the View::class html template engine while the behavior is done in Vue.js.
This allow for incredible flexibility, specially using Tailwind CSS, in styling your component without having to change the js package.';
DemoApp::addParagraph(Ui::layout(), $html);

Header::addTo(Ui::layout(), ['title' => 'jQuery', 'size' => 5])->appendTailwind('mt-6');
$html = 'jQuery is directly integrate to Fohn-Ui, which means that it is possible to assign jQuery event and function to a Fohn-Ui view directly using PHP code.';
DemoApp::addParagraph(Ui::layout(), $html);
DemoApp::addCodeConsole(Ui::layout())->setTextContent('Jquery::addEventTo($btn, \'click\')->executes([Jquery::withThis()->text(\'Hello\')])');

$html = 'Fohn-Ui js package can be changed and adapt to your project. For more information on how to do this, visit 
the <a href="https://github.com/fohn-group/fohn-js" target="_blank" class="text-purple-700 underline">fohn-js</a> repository.';
DemoApp::addParagraph(Ui::layout(), $html, false);
