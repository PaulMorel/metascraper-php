<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Url extends Extractor {

	protected string $id = 'url';

	public function __construct(Crawler $crawler)
	{
		parent::__construct($crawler);

		$this->filters = [
			[ $this->crawler->filter('meta[property="og:url"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[name="twitter:url"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('meta[property="twitter:url"]'), 'attr', ['content'] ],
			[ $this->crawler->filter('link[rel="canonical"]'), 'attr', ['href'] ],
			[ $this->crawler->filter('link[rel="alternate"][hreflang="x-default"]'), 'attr', ['href'] ],
			[ $this->crawler, 'getUri', [] ]
		];
	}

}