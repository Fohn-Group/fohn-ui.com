<?php

declare(strict_types=1);

/**
 * Generate Default Tailwind utilities to be included in css files via tailwind.config.js.
 */

use Fohn\Ui\Service\Theme\Fohn;

require_once __DIR__ . '/../vendor/autoload.php';

file_put_contents('fohn-theme-tw.txt', Fohn::getThemeCss());
echo 'theme css done!' . \PHP_EOL;
