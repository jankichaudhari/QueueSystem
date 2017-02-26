<?php

class System
{
    /**
     * load default or as per requested controller
     */
    public function load()
    {
        global $config;

        // Set our defaults
        $controller = strtolower($config['defaultController']);
        $action = 'index';
        $url = '';

        // Get request url and script url
        $requestUrl = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $scriptUrl = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

        // Get our url path and trim the / of the left and the right
        if ($requestUrl != $scriptUrl) {
            $url = trim(preg_replace('/' . str_replace('/', '\/',
                    str_replace('index.php', '', $scriptUrl)) . '/', '', $requestUrl, 1), '/');
        }

        // Split the url into segments
        $segments = explode('/', $url);

        // Do our default checks
        if (isset($segments[0]) && $segments[0] != '') $controller = $segments[0];
        if (isset($segments[1]) && $segments[1] != '') $action = $segments[1];

        // Get our controller file
        $controller = $controller . "Controller";
        $path = APP_DIR . 'controllers' . DIR_SEPARATOR . $controller . '.php';
        if (file_exists($path)) {
            require_once($path);
        } else {
            $this->loadError();
        }

        // Create object and call method
        $controller = ucfirst($controller);
        $obj = new $controller();

        // Check the action exists
        if (!method_exists($obj, $action)) {
            $this->loadError();
        }
        die(call_user_func_array(array($obj, $action), array_slice($segments, 2)));
    }

    /**
     * load error controller to display 404 error page.
     */
    public function loadError()
    {
        global $config;

        $controller = $config['errorController'];
        require_once(APP_DIR . 'controllers' . DIR_SEPARATOR . $controller . '.php');

        $controller = ucfirst($controller);
        $error = new $controller();
        $error->index();

    }
}

?>
