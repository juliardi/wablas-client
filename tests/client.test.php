<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Tester\Assert;
use Juliardi\Wablas\Client;

$client = new Client('wablas-token');

Assert::false($client->sendMessage('08098999', 'halo'));
Assert::same('Invalid phone number.', $client->getLastError());

Assert::true($client->sendMessage('080989898989', 'testing phase'));
Assert::same('', $client->getLastError());