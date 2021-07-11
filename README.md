### Wablas Client
Library for sending WhatsApp message through Wablas (wablas.com). Please register at [Wablas](https://wablas.com/) to get your token.

### Installation
```
$ composer require juliardi/wablas-client
```

### Usage

```php

use Juliardi\Wablas\Client;

$client = new Client('wablas-token-here');

try {
	$result = $client->sendMessage('0809899999', 'message content');

	var_dump($result);
} catch (\Exception $e) {
	// log error here
}

```