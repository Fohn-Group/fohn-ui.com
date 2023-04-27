<?php

declare(strict_types = 1);
/**
 * console report demo.
 */

namespace Fohn\Demos\Ctrl;

use Psr\Log\LoggerInterface;

class ConsoleReport
{
    public function generateReport(LoggerInterface $console): array
    {
        $console->log('info', 'Console Implements Logger Interface');
        $console->debug('debug {foo}', ['foo' => 'bar']);
        $console->emergency('emergency {foo}', ['foo' => 'bar']);
        $console->alert('alert {foo}', ['foo' => 'bar']);
        $console->critical('critical {foo}', ['foo' => 'bar']);
        $console->error('error {foo}', ['foo' => 'bar']);
        $console->warning('warning {foo}', ['foo' => 'bar']);
        $console->notice('notice {foo}', ['foo' => 'bar']);
        $console->info('info {foo}', ['foo' => 'bar']);

        return ['jsMaxInt' => (2 ** 53) - 1, 'jsBigInt' => 2 ** 53];
    }
}
