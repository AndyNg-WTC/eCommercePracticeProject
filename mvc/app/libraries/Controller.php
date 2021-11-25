<?php

declare(strict_types=1);

namespace libraries;

/**
 * Base Controller
 *
 * Loads the models and views from the module directory.
 */
class Controller
{
    // Load model
    public function model(string $module, string $model): object
    {
        // Require model file
        require_once '../app/code/' . $module . '/Model/' . $model . '.php';

        // Instantiate model
        $modelNamespace = "code\\" . $module . "\Model\\" . $model;
        return new $modelNamespace();
    }

    //Load view
    public function view(string $module, string $view, array $data = []): void
    {
        // Check for the view file
        if (file_exists('../app/code/' . $module . '/view/' . $view . '.php')) {
            require_once '../app/code/' . $module . '/view/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }

    public function getModule(string $module): string
    {
        $fileInfo = pathinfo($module);
        return $fileInfo['filename'];
    }
}
