<?php

namespace ShopAPI\TestClient;

use PHPUnit\Framework\TestCase;
use ShopAPI\Client\Api\ApiEncoder;
use ShopAPI\Client\Api\OrderRequest\OrderRequest;
use ShopAPI\Client\Entity\Address;

class ApiEncoderTest extends TestCase {
    public function testOrderRequest() {
        $orderRequest = new OrderRequest();
        $orderRequest
            ->setNote('Please hurry!')
            ->setDeliveryByUid('ogd9d5d44h')
            ->addItemByUid('w5d5v5vd5f', 2)
            ->addItemByUid('w5d5v5vd5f', 1)
            ->setDeliveryAddress((new Address())
                ->setFirstName('John')
                ->setLastName('Smith')
                ->setStreet('Main Street')
                ->setHouseNumber('10a')
                ->setCity('Prague')
                ->setCountry('CZ')
            )
            ->setMerge(true);

        $encoded = (new ApiEncoder())->encodeOrderRequest($orderRequest);

        $this->assertEquals('Please hurry!', $encoded['note']);
        $this->assertEquals('ogd9d5d44h', $encoded['delivery']);
        $this->assertEquals([
            ['uid' => 'w5d5v5vd5f', 'quantity' => 3,]
        ], $encoded['items']);
        $this->assertEquals('John', $encoded['address']['delivery']['first_name']);
        $this->assertEquals('Smith', $encoded['address']['delivery']['last_name']);
        $this->assertEquals('Main Street', $encoded['address']['delivery']['street']);
        $this->assertEquals('10a', $encoded['address']['delivery']['house_number']);
        $this->assertEquals('Prague', $encoded['address']['delivery']['city']);
        $this->assertEquals('CZ', $encoded['address']['delivery']['country']);
        $this->assertEquals('1', $encoded['merge']);

    }
}
