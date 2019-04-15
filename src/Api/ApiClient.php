<?php

namespace ShopAPI\Client\Api;

use Psr\Http\Message\ResponseInterface;
use ShopAPI\Client\Api\OrderRequest\OrderRequest;
use ShopAPI\Client\Api\OrderRequest\OrderResponse;
use ShopAPI\Client\ApiRequestException;
use ShopAPI\Client\Entity\Delivery;
use ShopAPI\Client\FieldList\DeliveryFields;
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
        return $this->resolveOrderResponse($httpResponse);
    }

    public function validateOrder(OrderRequest $orderRequest): OrderResponse {
        $data = $this->encoder->encodeOrderRequest($orderRequest);

        $httpResponse = $this->http->postJson($this->baseUrl . 'orders?dryRun=true', $data, $this->config->getUsername(), $this->config->getPassword());
        return $this->resolveOrderResponse($httpResponse, true);
    }

    /**
     * @param DeliveryFields $fields
     * @return Delivery[]
     */
    public function getDeliveries(DeliveryFields $fields): array {
        $list = [];
        $response = $this->http->get($this->baseUrl . 'deliveries', ['fields' => (string)$fields], $this->config->getUsername(), $this->config->getPassword());
        $this->resolveError($response);
        $response = json_decode($response->getBody(), true);
        foreach ($response as $item) {
            $delivery = new Delivery($item['id']);
            if(isset($item['name'])) {
                $delivery->setName($item['name']);
            }
            $list[] = $delivery;
        }
        return $list;
    }

    private function resolveOrderResponse(ResponseInterface $httpResponse, bool $validateOnly = false): OrderResponse {
        $this->resolveError($httpResponse);
        $responseData = json_decode($httpResponse->getBody(), true);
        if($httpResponse->getStatusCode() === 201) {
            if($validateOnly) {
                return new OrderResponse('00000000000', $responseData['message']);
            }
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
        if($httpResponse->getStatusCode() >= 400 && $httpResponse->getStatusCode() < 500) {
            if(isset($responseData['error']['messages'])) {
                throw new ApiRequestException($responseData['error']['messages'], $responseData['error']['fields'], $responseData['error']['code'], $httpResponse);
            }
            if(isset($responseData['error'])) {
                throw new ApiRequestException([$responseData['error']['message']], [], $responseData['error']['code'], $httpResponse);
            }
            throw new ApiRequestException([$responseData['message']], [], $responseData['code'], $httpResponse);
        }
    }
}
