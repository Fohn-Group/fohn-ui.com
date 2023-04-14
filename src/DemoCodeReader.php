<?php

declare(strict_types=1);
/**
 * Read demo code.
 */

namespace Fohn\Demos;

class DemoCodeReader
{
    protected array $codes = [];

    public function __construct(string $filename)
    {
        $this->codes = explode(\PHP_EOL, file_get_contents($filename));
    }

    public function extractCode(string $blockId): string
    {
        $startLine = $this->getCodeLine('@' . $blockId);
        $endLine = $this->getCodeLine('@end_' . $blockId);

        $codes = array_slice($this->codes, $startLine, $endLine - ($startLine + 1));

        return implode(\PHP_EOL, $codes);
    }

    private function getCodeLine(string $code): int
    {
        $lineNumber = 0;

        foreach ($this->codes as $k => $line) {
            if (strpos($line, $code)) {
                $lineNumber = $k + 1;

                break;
            }
        }

        return $lineNumber;
    }
}
