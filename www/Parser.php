<?php

require 'IParser.php';

class Parser implements IParser
{
	/**
	 */
	public function __construct()
	{
	}

	/**
	 * @return array
	 */
	public function parse()
	{
    return file('vstup.txt');
	}

}
