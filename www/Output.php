<?php

require 'IOutput.php';

class Output implements IOutput
{

	/**
	 */
	public function __construct()
	{
	}

	/**
   * @param string $array
	 */
	public function getJson($array)
	{
		$fp = fopen('output.json', 'w');
		fwrite($fp, json_encode($array));
		fclose($fp);
	}

}
