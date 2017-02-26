<?php

/**
 * Class Controller
 * Defines methods to load model,view,plugin or helper
 */
class Controller
{
    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function loadModel($name)
    {
        //prepare valid path for model
        $name = strtolower($name) . 'Model';
        $path = APP_DIR . 'models' . DIR_SEPARATOR . $name . '.php';
        $this->includeFile($path);

        return $this->initializeClass($name);
    }

    /**
     * @param $name
     * @return View
     */
    public function loadView($name)
    {
        $view = new View($name);
        return $view;
    }

    /**
     * @param $name
     * @throws Exception
     */
    public function loadPlugin($name)
    {
        $path = APP_DIR . 'plugins' . DIR_SEPARATOR . strtolower($name) . '.php';
        $this->includeFile($path);
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function loadHelper($name)
    {
        $path = APP_DIR . 'helpers' . DIR_SEPARATOR . strtolower($name) . '.php';
        $this->includeFile($path);

        return $this->initializeClass($name);
    }

    /**
     * Initialize class for respective name
     *
     * @param $name
     * @return mixed
     */
    private function initializeClass($name)
    {
        $name = ucfirst($name);
        return new $name;
    }

    /**
     * include valid file if required
     *
     * @param $path
     * @throws Exception
     */
    private function includeFile($path)
    {
        if (!file_exists($path)) {
            throw new Exception("Invalid path to include file!");
        }

        if (!in_array($path, get_included_files())) {
            require($path);
        }
    }

}

?>