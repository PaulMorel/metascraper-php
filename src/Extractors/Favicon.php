<?php

namespace PaulMorel\Metascraper\Extractors;

use phpUri as PHPUri;
use Symfony\Component\DomCrawler\Crawler;

class Favicon extends Extractor {

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

		$filter->each(function(Crawler $node, $i) {
			ray($this->getImageSize($node), $node->outerHtml());

		});
		
		return [
			$this->options['id'] => PHPUri::parse($crawler->getUri())->join($filter->attr('href'))
		];
	}


	private function getImageSize(Crawler $node) {
		
		// Get size from `sizes` attribute
		if ( $sizes = $node->attr('sizes') ) {
			$sizes = preg_replace('/x/', 'x', $sizes);
			$sizes = explode(' ', $sizes)[0];
			[$height, $width] = explode('x', $sizes);

			return [$height, $width];
		}

		// Get size from the `name` attribute
		
		// Get size from `content` attribute

		// Get size from the `href` attribute

		// Get size from image
	}

}