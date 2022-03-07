<?php

namespace PaulMorel\Metascraper\Extractors;

use PaulMorel\Metascraper\Extractors\Traits\HandlesImages;
use Symfony\Component\DomCrawler\UriResolver;
use Symfony\Component\DomCrawler\Crawler;


class Favicon extends Extractor {

	use HandlesImages;
	
	protected array $defaults = [
		'id' => 'logo',
		'size' => 'largest'
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

		$images = [];

		// Get info on all images found
		$filter->each(function(Crawler $node, $i) use ($crawler, &$images) {
			$imageInfo = $this->getImageInfo($node, $crawler);

			
			if ( $imageInfo === null ) {
				return;
			}

			$imageInfo = $this->setImagePriority($imageInfo);
			
			$images[] = $imageInfo;
		});

		$image = $this->getBestImage($images, $this->options['size']);
		$image = $this->removePriority($image);
		$image = $this->castImageSizeToInt($image);
		$image = $this->setHumanReadableFileSize($image);

		
		return [
			$this->options['id'] => $image
		];
	}

}