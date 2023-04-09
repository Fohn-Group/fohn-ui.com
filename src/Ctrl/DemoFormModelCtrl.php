<?php

declare(strict_types=1);
/**
 * Specific Ctrl for DemoApp.
 * Basically prevent Form to save data in db while
 * keeping Model validation.
 */

namespace Fohn\Demos\Ctrl;

use Fohn\Ui\Service\Atk\FormModelController;

class DemoFormModelCtrl extends FormModelController
{
    /**
     * Does not save data in Db for demo, but we still want to validate for error.
     */
    public function saveModelUsingForm(?string $id, array $formControls): array
    {
        $entity = $id ? $this->getModel()->load($id) : $this->getModel()->createEntity();

        $formErrors = [];
        $fieldErrors = $this->setModelFields($formControls, $entity);
        $validateErrors = $entity->validate();

        foreach ($fieldErrors as $fieldName => $error) {
            $formErrors[$fieldName] = implode(' / ', array_values($error));
        }

        foreach ($validateErrors as $fieldName => $error) {
            $formErrors[$fieldName] = isset($formErrors[$fieldName]) ? $formErrors[$fieldName] . ' / ' . $error : $error;
        }

        return $formErrors;
    }
}
