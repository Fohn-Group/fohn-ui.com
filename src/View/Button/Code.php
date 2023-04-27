<?php

declare(strict_types=1);
/**
 * Create a button that open a new tab window using javascript.
 */

namespace Fohn\Demos\View\Button;

use Fohn\Ui\Js\Js;

class Code extends \Fohn\Ui\View\Button
{
    public function jsOpenWindow(string $url): self
    {
        $chain = Js::from('window.open({{url}}, {{target}})', ['url' => $url, 'target' => '_blank']);
        $this->appendHtmlAttribute('onclick', $chain->jsRender());

        return $this;
    }
}
