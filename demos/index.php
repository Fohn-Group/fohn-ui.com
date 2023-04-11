<?php

declare(strict_types=1);

use Fohn\Ui\Service\Ui;
use Fohn\Ui\View\Heading\Header;

require_once __DIR__ . '/init-ui.php';

Header::addTo(Ui::layout(), ['title' => 'Fohn Ui', 'size' => 4]);
