<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Url extends Extractor {

	protected string $id = 'url';

	public function __construct(array $options = [])
	{
		parent::__construct($options);

		$this->filters = [
			[ 'meta[property="og:url"]', 'attr', ['content'] ],
			[ 'meta[name="twitter:url"]', 'attr', ['content'] ],
			[ 'meta[property="twitter:url"]', 'attr', ['content'] ],
			[ 'link[rel="canonical"]', 'attr', ['href'] ],
			[ 'link[rel="alternate"][hreflang="x-default"]', 'attr', ['href'] ],
			[ '', 'getUri', [] ]
		];
	}

}