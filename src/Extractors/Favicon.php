<?php

namespace PaulMorel\Metascraper\Extractors;

use PaulMorel\Metascraper\Extractors\Traits\HandlesImages;
use Symfony\Component\DomCrawler\UriResolver;
use Symfony\Component\DomCrawler\Crawler;


class Favicon extends Extractor {

	use HandlesImages;
	
	protected array $defaults = [
		'id' => 'logo'
	];

	public function __construct(array $options = [])
	{
		parent::__construct($options);
	}

	public function extract(Crawler $crawler): array
	{
		$filter = $crawler->filter('link[rel*="icon"], meta[name*="msapplication"]');

		if ( $filter->count() === 0 ) {
			return [];
		}

		$filter->each(function(Crawler $node, $i) use ($crawler) {
			$size = $this->getImageSize($node, $crawler);

			if ( $size !== null ) {
				$size = $this->setImagePriority($size);
			}

		});
		
		return [
			$this->options['id'] => [
				'url' => UriResolver::resolve($filter->attr('href'), $crawler->getUri())
			]
		];
	}

}