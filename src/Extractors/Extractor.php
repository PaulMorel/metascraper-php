<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

abstract class Extractor
{

	protected array $filters;
	protected array $options;
	protected array $defaults;
	protected $metadata = null;

	public function __construct(array $options = [])
	{
		$this->options = array_merge($this->defaults, $options);
	}

	public function extract(Crawler $crawler): array
	{

		$metadata = null;

		foreach ($this->filters as [$filter, $method, $args]) {
			if ( ! empty($filter) ) {
				$crawler = $crawler->filter($filter);


				if ($crawler->count() === 0) {
					continue;
				}
			}

			if (!$metadata = $crawler->$method(...$args)) {
				continue;
			};

			$this->metadata = $metadata;

			break;
		}

		return [
			$this->options['id'] => $this->metadata
		];
	}
}
