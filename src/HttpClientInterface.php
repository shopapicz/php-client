<?php

namespace ShopAPI\Client;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface {

    public function postJson(string $url, array $data, string $username, string $password): ResponseInterface;

    public function get(string $url, array $query, string $username, string $password): ResponseInterface;

    /**
     * @return resource
     */
    public function download(string $url, string $apiUser = null, string $apiPassword = null);
}
