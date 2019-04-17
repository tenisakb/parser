<?php

class Dispatcher
{

	/**
	 * @var IGrabber
	 */
	private $grabber;
	/**
	 * @var IOutput
	 */
	private $output;
		/**
	 * @var IParser
	 */
	private $parser;

	/**
	 * @param IGrabber $grabber
	 * @param IOutput $output
	 * @param IParser $parser
	 */
	public function __construct(IGrabber $grabber, IOutput $output, IParser $parser)
	{
		$this->grabber = $grabber;
		$this->output = $output;
		$this->parser = $parser;
	}

	/**
	 * @return string JSON
	 */
	public function run()
	{
		print_r('Begin parse txt for productID </br>');
		$codes = $this->parser->parse();
		print_r('Grabbering data from czc </br>');
		$data = $this->grabber->getData($codes);
		print_r('Begin generate json file output.json');
		$this->output->getJson($data);
	}

}
