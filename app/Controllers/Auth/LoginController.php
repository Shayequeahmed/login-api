<?php

namespace App\Controllers\Auth;

use Fantom\Log\Log;
use Fantom\Session;
use Fantom\Controller;
use App\Support\Response;
use App\Middlewares\GuestMiddleware;
use App\Support\Authentication\Auth;
use App\Support\Validations\AuthValidator;

/**
 * LoginController
 */
class LoginController extends Controller
{
	protected function index()
	{
		$this->view->render("Auth/Login/index.php");
	}

	public function authenticate()
	{
		$res = new Response();
		$v = AuthValidator::validateLogin();

		// No need to set the error in the session
		// it is already handled by view
		if ($v->hasError()) {
			$res->setErrors($v->validationErrors()->all());
			return $res->send();
		}

		/*var_dump($_POST['email'], $_POST['password']);
		exit();*/

		// @TODO Handle username/email input for login
		if ($_POST['email'] != "user@gmail.com" && $_POST['password'] != "12345678") {
			$res->setErrors(['message' => 'Invalid Email or Password']);
			Log::error(Auth::error());
			return $res->send();
		}

		return $res->send();
	}

	public function logout()
	{
		Auth::logout();
		redirect('/');
	}

	protected function before()
	{
		return (new GuestMiddleware)();
	}
}