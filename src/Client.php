<?php

namespace Juliardi\Wablas;

use Exception;

/**
 *
 * @author Juliardi	<ardi93@gmail.com>
 */
class Client {

	/**
	 * API Base URL
	 * @var string
	 */
	private $base_url;

	/**
	 * API Authorization Token
	 * @var string
	 */
	private $token;

	/**
	 * Latest response from Wablas
	 * @var mixed
	 */
	private $last_response;

	/**
	 * @param string $token    	API Token from Wablas
	 * @param string $base_url	Optional. To set Wablas URL. If empty, it will use `https://console.wablas.com//api/send-message`
	 * as the default URL.
	 */
	public function __construct($token, $base_url = '') {
		$this->base_url = $base_url;

		if(empty($base_url)) {
			$this->base_url = 'https://console.wablas.com/api/send-message';
		}

		$this->token = $token;
	}

	public function getLastResponse() {
		return $this->last_response;
	}

	/**
	 * @param  string $phone_number 
	 * @param  string $message      
	 * @return bool
	 * @throws \Exception When cURL operation failed
	 */
	public function sendMessage($phone_number, $message) {
		if (!preg_match("/^[0-9]+$/i", $phone_number) || (strlen($message) < 9)) {
            throw new Exception('Invalid phone number.');
        }

        $data = [
            'phone' => $phone_number,
            'message' => $message,
        ];
        
        $curlHandle = curl_init($this->base_url);

        curl_setopt_array($curlHandle, [
    	    CURLOPT_HTTPHEADER => ['Authorization:' . $this->token],
        	CURLOPT_CUSTOMREQUEST => 'POST',
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_POSTFIELDS => http_build_query($data),
    	    CURLOPT_SSL_VERIFYHOST => -1,
        	CURLOPT_SSL_VERIFYPEER => -1,
        ]);

        $response = curl_exec($curlHandle);

        if ($response) {
        	$result = json_decode($response, true);

        	$this->last_response = $result;

        	if ($result && isset($result['status'])) {
	            if($result['status'] == true) {
	            	return true;
	            } else {
	                throw new Exception($result['message']);
	            }
        	}
        
        } else {
        	throw new Exception('curl error : ' . curl_error($curlHandle));
        }

        return false;
	}

}
