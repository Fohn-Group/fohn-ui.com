<?php

declare(strict_types=1);

use Fohn\Demos\DemoApp;
use Fohn\Ui\Core\Utils;
use Fohn\Ui\Service\Ui;
use Fohn\Ui\View\Message;

require_once __DIR__ . '/../init-ui.php';

$subtitles = [
];
DemoApp::addPageHeaderTo(Ui::layout(), 'Message', $subtitles);

$section = DemoApp::addInfoSection(Ui::layout(), 'Message color and type:');

$msg = Message::addTo($section, ['title' => 'Outline Info', 'color' => 'info']);
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));

$msg = Message::addTo($section, ['color' => 'success', 'title' => 'Outline Success']);
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));

$msg = Message::addTo($section, ['color' => 'error', 'title' => 'Outline Error']);
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));

$msg = Message::addTo($section, ['type' => 'contained', 'color' => 'warning', 'title' => 'Contained Warning']);
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));

$msg = Message::addTo($section, ['type' => 'contained', 'color' => 'success', 'title' => 'Contained Success']);
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)));

$msg = Message::addTo($section, ['type' => 'contained', 'color' => 'info', 'title' => 'Contained Info with icon']);
$msg->addText(Utils::getLoremIpsum(random_int(1, 10)))->addIcon('bi-house-fill fa-3x');
