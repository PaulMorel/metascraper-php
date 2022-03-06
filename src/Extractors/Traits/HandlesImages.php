<?php

namespace PaulMorel\Metascraper\Extractors\Traits;

use Symfony\Component\DomCrawler\UriResolver;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

trait HandlesImages {

	private function getImageSize(Crawler $node, Crawler $crawler): ?array {
		
		// Create HTTP Client
		$client = HttpClient::create();
		$urlAttr = $node->attr('href') ?? $node->attr('content');
		$url = UriResolver::resolve($urlAttr, $crawler->getUri());

		// Get file info
		$response = $client->request('HEAD', $url);

		// Return early if file is not an image
		if ( mb_strpos($response->getHeaders()['content-type'][0], 'image') === false ) {
			return null;
		}

		// Get file size and type from headers and url
		$size = (int) $response->getHeaders()['content-length'][0];
		$type =  pathinfo($url, PATHINFO_EXTENSION);

		// Get size from `sizes` attribute
		if ( $sizes = $node->attr('sizes') ) {
			$sizes = preg_replace('/×/', 'x', $sizes);
			$sizes = explode(' ', $sizes)[0];
			[$width, $height] = explode('x', $sizes);

			return compact('url', 'width', 'height', 'size', 'type');
		}
		
		// Get size from `href` or `content` attributes
		if ( $urlAttr ) {
			$filename = pathinfo($url, PATHINFO_FILENAME);
			$match = preg_match('/(\d+)x(\d+)$/', $filename, $sizes);

			if ( $match ) {
				[,$width, $height] = $sizes;
				return compact('url', 'width', 'height', 'size', 'type');
			}
		}

		// Get size from the image
		if ( $urlAttr ) {
			// Download file
			$response = $client->request('GET', $url);
	
			// Get image size
			[$width, $height] = getimagesizefromstring($response->getContent());

			return compact('url', 'width', 'height', 'size', 'type');		
		}

		return null;
	}

	
	private function setImagePriority(array $imageInfo): array {
		['url' => $url, 'width' => $width, 'type' => $type ] = $imageInfo;

		$priority = 1 * $width;
		if ( mb_strpos($url, 'apple') !== false ) $priority = 5 * $width;
		if ( mb_strpos($url, 'android') !== false ) $priority = 5 * $width;
		if ( $type == 'png' ) $priority = 5 * $width;
		if ( $type == 'jpg' || $type == 'jpeg' ) $priority = 4 * $width;
		if ( $type == 'svg' ) $priority = 3 * $width;
		if ( $type == 'ico' ) $priority = 2 * $width;

		return array_merge($imageInfo, compact('priority'));		
	}
}