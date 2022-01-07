<?php

namespace PaulMorel\Metascraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Collection;

abstract class Extractor {

	protected string $id;
	protected Crawler $crawler;
	protected array $filters;
	protected string $metadata;
	
	public function __construct(Crawler $crawler) {
		$this->crawler = $crawler;
	}

	public function extract(): array {
		
		foreach ( $this->filters as [$crawler, $method, $args]) {
			
			if ( $crawler->count() === 0 ) {
				continue;
			}	

			$this->metadata = $crawler->$method(...$args);

			break;
		}

		return [
			$this->id => $this->metadata
		];

	}

}