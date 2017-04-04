<?php

namespace ShopAPI\Client\FieldList;

abstract class AbstractFields {
    protected $fields = [];

    protected function addField(string $name) {
        $this->fields[$name] = true;
    }

    public function __toString() {
        return implode(',', array_keys($this->fields));
    }
}
