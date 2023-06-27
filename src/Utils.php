<?php

declare(strict_types=1);
/**
 * DemoApp utilities function.
 */

namespace Fohn\Demos;

use Fohn\Ui\Component\Form\Control;
use Fohn\Ui\Js\JsRenderInterface;
use Fohn\Ui\Js\JsToast;
use Fohn\Ui\View;
use Fohn\Ui\View\HtmlList;

class Utils
{
    /**
     * @param array<Control> $formControls
     */
    public static function displayControlsValueInToast(array $formControls): JsRenderInterface
    {
        $items = [];
        foreach ($formControls as $k => $control) {
            $items[] = ['name' => $control->getControlName() . ': ' . $control->getInputValue()];
        }

        $container = (new View())->appendTailwinds(['ml-6']);
        $container->addView((new HtmlList(['position' => 'outside']))->setItems($items));

        $msg = preg_replace('/\s+/', ' ', $container->getHtml());

        return JsToast::info('Submit!', $msg, [], false);
    }
}
