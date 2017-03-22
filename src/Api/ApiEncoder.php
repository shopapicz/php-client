<?php
namespace ShopAPI\Client\Api;

use ShopAPI\Client\Api\OrderRequest\OrderRequest;
use ShopAPI\Client\Entity\Address;

class ApiEncoder {
    public function encodeOrderRequest(OrderRequest $orderRequest): array {
        $data = [
            'items' => [],
            'address' => [],
        ];

        foreach ($orderRequest->getItems() as $item) {
            $data['items'][] = [
                'uid' => $item->getUid(),
                'quantity' => $item->getQuantity(),
            ];
        }

        if($orderRequest->getDeliveryAddress() && !$orderRequest->getDeliveryAddress()->isEmpty()) {
            $data['address']['delivery'] = $this->encodeAddress($orderRequest->getDeliveryAddress());
        }
        if($orderRequest->getInvoiceAddress() && !$orderRequest->getInvoiceAddress()->isEmpty()) {
            $data['address']['invoice'] = $this->encodeAddress($orderRequest->getInvoiceAddress());
        }

        if($orderRequest->getNote() !== null) {
            $data['note'] = $orderRequest->getNote();
        }
        if($orderRequest->getDelivery() !== null) {
            $data['delivery'] = $orderRequest->getDelivery()->getUid();
        }
        return $data;
    }

    public function encodeAddress(Address $address): array {
        $data = [
            'phone' => $address->getPhone(),
            'email' => $address->getEmail(),
            'first_name' => $address->getFirstName(),
            'last_name' => $address->getLastName(),
            'company' => $address->getCompany(),
            'street' => $address->getStreet(),
            'house_number' => $address->getHouseNumber(),
            'city' => $address->getCity(),
            'zip' => $address->getZip(),
            'country' => $address->getCountry(),
        ];

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }
}
