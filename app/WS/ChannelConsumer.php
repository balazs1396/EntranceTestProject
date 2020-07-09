<?php

namespace App\WS;

use App\WS\Routes\ChannelRoutes;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ChannelConsumer extends ChannelRoutes
{

	/**
	 * Guzzle client
	 * @var GuzzleHttp\Client $client
	 */
	protected $client;

	/**
	 * Constructor
	 * @param string $location
	 * @param string $user
	 * @param string $password
	 */
	public function __construct($location)
	{
		$this->client = new Client(['base_uri' => $location]);
	}

	/**
	 * Consume the API
	 * @param  string $route
	 * @param  string $method
	 * @param  null|object $params
	 * @return mixed
	 */
	protected function consume($route, $method, $params = null)
	{
		$response = $this->client->request($method, $route, [
			'verify' => false,
			'auth' => [],
			'http_errors' => false,
			'json' => $params,
		]);
		$reasonPhrase = $response->getReasonPhrase();
		if ($reasonPhrase === 'OK') {
			return json_decode($response->getBody());
		}

		if ($reasonPhrase === 'Not Found') {
			return [];
		}

		$message = "";
		try {
			$message = json_decode($response->getBody())->Message;
		} catch (\Exception $ex) {
            //\Log::error("error on consume", [json_decode($response->getBody())->Message]);
        }

	}
}