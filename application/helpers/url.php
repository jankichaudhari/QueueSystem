<?php

class Url
{

    public function baseUrl()
    {
        global $config;
        return $config['baseUrl'];
    }

    public function segment($seg)
    {
        if (!is_int($seg)) return false;

        $parts = explode('/', $_SERVER['REQUEST_URI']);
        return isset($parts[$seg]) ? $parts[$seg] : false;
    }
}

?>