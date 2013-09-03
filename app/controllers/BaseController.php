<?php

class BaseController extends Controller {
	protected $pageSize = 15;
	protected $orderBy = 'id';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	static function getCurrentUser() {
		$_user = null;
		if(Auth::guest()===true) {
			$_user = null;
		} else {
			$_user = User::where('name','=',Auth::user()->username)->first();
		}
		return $_user;
	}

}