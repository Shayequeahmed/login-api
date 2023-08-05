<?php

namespace App\Support;

/**
 * Response class
 */
class Response
{
	protected $data;
	protected $errors;
	protected $status;

	public function __construct()
	{
		$this->data = "";
		$this->errors = [];
		$this->status = true;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function setErrors(array $errors)
	{
		$this->errors = $errors;
	}

	public function setStatus($status)
	{
		$this->status = $status === true;
	}

	public function send()
	{
		echo $this;
	}

	public function __toString()
	{
		return json_encode($this->prepareResponseObject());
	}

	public function prepareResponseObject()
	{
		$o 			= new \stdClass;
		$o->status 	= $this->evaluateStatus() ? 'success' : 'error';
		$o->errors 	= $this->errors;
		$o->data 	= $this->data;

		return $o;
	}

	public function get()
	{
		return $this->prepareResponseObject();
	}

	protected function evaluateStatus()
	{
		// If errors field has values then error occured
		if (count($this->errors) > 0) {
			return false;
		}

		return $this->status;
	}
}