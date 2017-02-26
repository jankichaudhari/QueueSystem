<?php

/**
 * Render view files and set variables for views
 *
 * Class View
 */
class View
{

    private $pageVars = array();
    private $template;

    /**
     * View constructor.
     * @param $template
     */
    public function __construct($template)
    {
        $this->template = APP_DIR . 'views' . DIR_SEPARATOR . $template . '.php';

    }

    /**
     * @param $var
     * @param $val
     */
    public function set($var, $val)
    {
        $this->pageVars[$var] = $val;
    }

    /**
     * renders template and import variables into the current symbol table from $pageVars
     */
    public function render()
    {
        extract($this->pageVars);

        ob_start();
        if (!file_exists($this->template)) {
            throw new Exception("Invalid path to include file!");
        }
        require($this->template);
        echo ob_get_clean();
    }

}

?>