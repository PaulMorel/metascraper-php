<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Collection;

abstract class Extractor {

	protected string $id;
	protected Crawler $crawler;
	protected array $filters;
	protected $metadata = null;

	public function __construct(Crawler $crawler) {
		$this->crawler = $crawler;
	}

	public function extract(): array {
		
		foreach ( $this->filters as [$crawler, $method, $args]) {
			
			if ( $crawler->count() === 0 ) {
				continue;
			}	

			if ( ! $metadata = $crawler->$method(...$args) ) {
				continue;
			};

			$this->metadata = $metadata;

			break;
		}

		return [
			$this->id => $this->metadata
		];

	}

}