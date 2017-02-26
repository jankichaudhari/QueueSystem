<?php

/**
 * Class Error
 */
class ErrorController extends Controller
{
	/**
	 *
	 */
	public function index()
	{
		$this->error404();
	}

	/**
	 * @throws Exception
	 */
	public function error404()
	{
		$template = $this->loadView('error');
		$template->render();
		exit();
	}
}

?>
