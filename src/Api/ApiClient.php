<?php

namespace ShopAPI\Client\Api;

use Psr\Http\Message\ResponseInterface;
use ShopAPI\Client\Api\OrderRequest\OrderRequest;
use ShopAPI\Client\Api\OrderRequest\OrderResponse;
use ShopAPI\Client\ApiRequestException;
use ShopAPI\Client\HttpClient;
use ShopAPI\Client\IOException;
use ShopAPI\Client\UnauthorizedException;

class ApiClient {
    /**
     * @var ApiConfig
     */
    private $config;

    /**
     * @var HttpClient
     */
    private $http;

    /**
     * @var string
     */
    private $baseUrl = 'https://shopapi.cz/api/1/';

    /**
     * @var ApiEncoder
     */
    private $encoder;

    public function __construct(ApiConfig $config) {
        $this->config = $config;
        $this->http = new HttpClient();
        $this->encoder = new ApiEncoder();
    }

    public function createOrder(OrderRequest $orderRequest): OrderResponse {
        $data = $this->encoder->encodeOrderRequest($orderRequest);

        $httpResponse = $this->http->postJson($this->baseUrl . 'orders', $data, $this->config->getUsername(), $this->config->getPassword());
        $this->resolveError($httpResponse);
        $responseData = json_decode($httpResponse->getBody(), true);
        if($httpResponse->getStatusCode() === 201) {
            return new OrderResponse($responseData['code'], $responseData['message']);
        }
        throw new IOException('ShopAPI request failed with HTTP code ' . $httpResponse->getStatusCode(), $httpResponse->getStatusCode());
    }


    private function resolveError(ResponseInterface $httpResponse) {
        if($httpResponse->getStatusCode() > 499) {
            throw new IOException('ShopAPI request failed with HTTP code ' . $httpResponse->getStatusCode(), $httpResponse->getStatusCode());
        }
        if(!empty($httpResponse->getHeader('content-type')) && strpos($httpResponse->getHeader('content-type')[0], 'application/json') !== false) {
            $responseData = json_decode($httpResponse->getBody(), true);
        } else {
            $responseData = [];
        }

        if($httpResponse->getStatusCode() === 401 || $httpResponse->getStatusCode() === 403) {
            if(isset($responseData['error'])) {
                throw new UnauthorizedException(
                    $responseData['error']['message'],
                    $responseData['error']['code']
                );
            }
            throw new UnauthorizedException(
                'Access denied',
                $httpResponse->getStatusCode()
            );
        }
        if($httpResponse->getStatusCode() === 400) {
            throw new ApiRequestException($responseData['error']['message'], $responseData['error']['fields'], $responseData['error']['code']);
        }
    }
}
