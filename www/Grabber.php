<?php

require 'IGrabber.php';

class Grabber implements IGrabber
{
	const URL_CZC = 'https://www.czc.cz/';

	/**
	 */
	public function __construct()
	{
	}

	/**
   * @param array
	 * @return array
	 */

	public function getData($array)
	{
    libxml_use_internal_errors(true);
		$links = $this->getLinks($array);
		$data = $this->getProductData($links);

		return $data;
	}

	/**
   * @param array
	 * @return string
	 */

	private function getPage($url)
	{
		$crl = curl_init();
    $timeout = 5;
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_HEADER, false);
    curl_setopt($crl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    $contents = curl_exec($crl);
    curl_close($crl);

		if($contents) return $contents; else return false;
	}

	/**
   * @param array
	 * @return array
	 */

	private function getLinks($array)
	{
		$data = [];
		foreach ($array as $item) {
			$dom = new \DOMDocument();
			$html = $dom->loadHTML($this->getPage(self::URL_CZC . substr($item, 0, -4) . '/hledat'));
			$dom->preserveWhiteSpace = false; 

			$xpath = new DomXPath($dom);
			$className = 'tile-link';
			$nodes = $xpath->query("//*[contains(@class, '$className')]");

			$isFirst = true;

			foreach($nodes as $node) {
				foreach ($node->attributes as $attr) {
					if($attr->nodeName == 'href' && $isFirst) {
            $data[] = [
              'code' => $item,
              'slug' => $attr->nodeValue,
						];
						$isFirst = false;
					}
				}
			}
    }

    return $data;
	}

	/**
   * @param array
	 * @return array
	 */

	private function getProductData($array)
	{
		$data = [];
		foreach ($array as $item) {
			$dom = new \DOMDocument();
			$html = $dom->loadHTML($this->getPage(self::URL_CZC . ltrim(str_replace("\/", "/", $item['slug']), '/')));
			$dom->preserveWhiteSpace = false;

			$xpath = new DomXPath($dom);

			$nodes = $xpath->query("//h1");
			$data[$item['code']] = [
				'slug' => $item['slug'],
				'name' =>$nodes[0]->textContent,
			];

			$className = 'rating__label';
			$nodes = $xpath->query("//*[contains(@class, '$className')]");
			$data[$item['code']] = [
				'rate' => $nodes[0]->textContent,
				'name' => $data[$item['code']]['name'],
			];

			$className = 'price-vatin';
			$nodes = $xpath->query("//*[contains(@class, '$className')]");
			$data[$item['code']] = [
				'price' => $nodes[0]->textContent,
				'rate' =>	$data[$item['code']]['rate'],
				'name' =>	$data[$item['code']]['name'],
				'slug' => $item['slug']
			];
		}

    return $data;
	}

}
