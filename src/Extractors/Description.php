<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Description extends Extractor {

	protected array $defaults = [
		'id' => 'description'
	];

	public function __construct(array $options = [])
	{		
		parent::__construct($options);
		
		$this->filters = [
			[ 'meta[property="og:description"]', 'attr', ['content'] ],
			[ 'meta[name="twitter:description"]', 'attr', ['content'] ],
			[ 'meta[property="twitter:description"]', 'attr', ['content'] ],
			[ 'meta[name="description"]', 'attr', ['content'] ]
		];
	}

}