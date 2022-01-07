<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Favicon extends Extractor {

	protected string $id = 'favicon';

	public function __construct(Crawler $crawler)
	{
		parent::__construct($crawler);
	}

	public function extract(): array
	{
		$filter = $this->crawler->filter('link[rel*="icon"]');

		if ( $filter->count() === 0 ) {
			return [];
		}

		print_r($filter->attr('href'));

		return [
			$this->id => 'a'
		];
	}

}