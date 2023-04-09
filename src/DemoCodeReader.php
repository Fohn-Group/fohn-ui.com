<?php

declare(strict_types = 1);
/**
 * Read demo code.
 */

namespace Fohn\Demos;

use Fohn\Ui\Js\JsChain;
use Fohn\Ui\Page;
use Fohn\Ui\PageLayout\Admin;
use Fohn\Ui\View;

class DemoCodeReader
{
    protected array $codes = [];

    public function __construct(string $filename, Page $page)
    {
        $this->codes = explode(PHP_EOL, file_get_contents($filename));

    }

    public function extractCode(string $block): string
    {
        $startLine = $this->getCodeLine('@' . $block);
        $endLine = $this->getCodeLine('@end_' . $block);

        $codes = array_slice($this->codes, $startLine, $endLine - ($startLine + 1));

        return implode(PHP_EOL, $codes);
    }

    private function getCodeLine(string $code): int
    {
        $lineNumber = 0;

        foreach ($this->codes as $k => $line) {
            if ( strpos($line, $code)) {
                $lineNumber = $k + 1;
                break;
            }
        }

        return $lineNumber;
    }
}
