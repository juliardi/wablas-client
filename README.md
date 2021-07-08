### Wablas Client
Library for sending WhatsApp message through Wablas (wablas.com)

### Installation
```
$ composer require juliardi/wablas-client
```

### Usage
Please register at [Wablas](https://wablas.com/) to get your token.

```php

use Juliardi\Wablas\Client;

$client = new Client('wablas-token-here');

try {
	$result = $client->sendMessage('0809899999', 'message content');

	if($result == false) {
		throw new \Exception($client->getLastError());
	}
} catch (\Exception $e) {
	// log error here
}

```