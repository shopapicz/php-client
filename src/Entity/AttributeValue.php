<?php
namespace ShopAPI\Client\Entity;

class AttributeValue {
    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @var array
     */
    protected $values = [];

    function __construct(Attribute $attribute) {
        $this->attribute = $attribute;
    }

    /**
     * @return Attribute
     */
    public function getAttribute() {
        return $this->attribute;
    }

    /**
     * @param $value
     * @return $this
     */
    public function addValue($value) {
        $this->values[] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues() {
        return $this->values;
    }


}
