<?php

namespace Juliardi\Wablas;

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
	 * Error list
	 * @var array
	 */
	private $last_error;


	/**
	 * @param string $token    	API Token from Wablas
	 * @param string $base_url	Optional. To set Wablas URL. If empty, it will use `https://console.wablas.com//api/send-message`
	 * as the default URL.
	 */
	public function __construct($token, $base_url = '') {
		$this->base_url = $base_url;

		if(empty($base_url)) {
			$this->base_url = 'https://console.wablas.com//api/send-message';
		}

		$this->token = $token;
		$this->last_error = '';
	}

	private function setLastError($error) {
		$this->last_error = $error;
	}

	/**
	 * Get last error
	 * @return string
	 */
	public function getLastError() {
		return $this->last_error;
	}

	/**
	 * @param  string $phone_number 
	 * @param  string $message      
	 * @return bool
	 * @throws \Exception When cURL operation failed
	 */
	public function sendMessage($phone_number, $message) {
		$this->setLastError('');
		
		if (!preg_match("/^[0-9]+$/i", $phone_number) || (strlen($message) < 9)) {
            $this->setLastError('Invalid phone number.');

            return false;
        }

        $data = [
            'phone' => $phone_number,
            'message' => $message,
        ];

        $curl = curl_init($this->base_url);
        curl_setopt_array($curl, [
        	CURLOPT_HTTPHEADER => ['Authorization:' . $this->token],
        	CURLOPT_CUSTOMREQUEST => 'POST',
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_POSTFIELDS => http_build_query($data),
        	CURLOPT_SSL_VERIFYHOST => 0,
        	CURLOPT_SSL_VERIFYPEER => 0,
        ]);

        $response = curl_exec($curl);
        $result = json_decode($response, true);

        if($result['status'] == true) {
        	return true;
        } else {
        	$this->setLastError($result['message']);

        	return false;
        }

	}

}