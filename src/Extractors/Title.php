<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Title extends Extractor {

	protected string $id = 'title';

	public function __construct(Crawler $crawler)
	{
		parent::__construct($crawler);

		$this->filters = [
			[ $this->crawler->filter('meta[property="og:title"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[name="twitter:title"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[property="twitter:title"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('title'), 'text', [] ],
		];
	}

}