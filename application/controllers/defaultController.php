<?php

/**
 * Class Default
 */
class DefaultController extends Controller
{
    /**
     * @throws Exception
     */
    public function index()
    {
        $template = $this->loadView('default');
        $template->render();
    }

}

?>
