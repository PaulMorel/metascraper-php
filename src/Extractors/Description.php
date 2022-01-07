<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Description extends Extractor {

	protected string $id = 'description';

	public function __construct(Crawler $crawler)
	{
		parent::__construct($crawler);

		$this->filters = [
			[ $this->crawler->filter('meta[property="og:description"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[name="twitter:description"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[property="twitter:description"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[name="description"]'), 'attr', ['content'] ]
		];
	}

}