<?php

use PaulMorel\Metascraper\Metadata;

it('stores data', function() {

	$data = [];
	$metadata = new Metadata();
	
	expect($metadata->data())->toEqual($data);

	$data = [
		'title' => 'Example',
		'url' => 'https://example.com'
	];
	$metadata = new Metadata($data);

	$this->assertEquals($data, $metadata->data());
});