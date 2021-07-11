<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Tester\Assert;
use Juliardi\Wablas\Client;

$client = new Client('wablas-token');

$func = function() use ($client) {
	$client->sendMessage('08098999', 'halo');
};

Assert::exception($func, \Exception::class, 'Invalid phone number.');

Assert::true($client->sendMessage('080989898989', 'testing phase'));