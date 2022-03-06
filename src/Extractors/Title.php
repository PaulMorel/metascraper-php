<?php

namespace PaulMorel\Metascraper\Extractors;

class Title extends Extractor {

	protected array $defaults = [
		'id' => 'title'
	];

	public function __construct(array $options = [])
	{
		parent::__construct($options);

		$this->filters = [
			[ 'meta[property="og:title"]', 'attr', ['content'] ],
			[ 'meta[name="twitter:title"]', 'attr', ['content'] ],
			[ 'meta[property="twitter:title"]', 'attr', ['content'] ],
			[ 'title', 'text', [] ],
		];
	}

}