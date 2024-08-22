<?php

declare(strict_types=1);

namespace Fohn\Demos\Model;

class Folder extends File
{
    protected function init(): void
    {
        parent::init();
        $this->addCondition('is_folder', true);
    }
}
