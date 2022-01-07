<?php

namespace PaulMorel\Metascraper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Client {

	private $client;
	private $extractors;
	private $crawler;

	function __construct($url, $extractors = [])
	{
		$this->extractors = $extractors;

		if ( count($this->extractors) === 0) {
			return;
		}

		$client = new HttpBrowser(HttpClient::create());


		$this->crawler = $client->request('GET', $url);

		// print_r($this->extractors);

		$this->getMetadata();
		echo $url;
		
	}

	private function getMetadata() {

		$metadata = array_merge(...array_map( function($extractor) {
			return (new $extractor($this->crawler))->extract();
		}, $this->extractors));

		print_r($metadata);

	}
}