<?php

namespace ShopAPI\Client\FieldList;

class DeliveryFields extends AbstractFields {
    public function addName(): self {
        $this->addField('name');
        return $this;
    }
}
