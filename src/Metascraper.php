<?php

namespace PaulMorel\Metascraper;

use InvalidArgumentException;
use PaulMorel\Metascraper\Extractors\Extractor;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Validation;

class Metascraper
{

	protected HttpBrowser $client;
	protected array $extractors;
	protected Crawler $crawler;
	protected $metadata;

	public function __construct(array $extractors = [])
	{
		if (empty($extractors)) {
			throw new \InvalidArgumentException("The provided array of extractors is empty.");
		}

		foreach ($extractors as $extractor) {
			if (!is_subclass_of($extractor, Extractor::class)) {
				throw new \InvalidArgumentException("Extractor [{$extractor}] is not a valid extractor.");
			};
		}

		$this->extractors = $extractors;
	}

	public function request(string $url): void
	{
		$this->validateUrl($url);

		$this->client = new HttpBrowser(HttpClient::create());
		$this->crawler = $this->client->request('GET', $url);

		ray($this->crawler);
	}

	public function getMetadata(): Metadata
	{

		if ( is_null( $this->metadata ) ) {

			ray('extracting');
			$metadata = array_merge(...array_map(function ($extractor) {
				return $extractor->extract($this->crawler);
			}, $this->extractors));
	
			$this->metadata = new Metadata($metadata);

		}

		return $this->metadata;
	}

	protected function validateUrl(string $url): void
	{
		$validator = Validation::createValidator();
		$violations = $validator->validate($url, [
			new Constraints\Url()
		]);
		
		if ( count($violations->findByCodes(Constraints\Url::INVALID_URL_ERROR)) !== 0 ) {
			throw new InvalidArgumentException("The provided value [{$url}] is not a valid URL.");
		}
	}
}
