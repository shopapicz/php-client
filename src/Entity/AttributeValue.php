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

    public function getAttribute(): Attribute {
        return $this->attribute;
    }

    /**
     * @param $value
     * @return self
     */
    public function addValue($value): self {
        $this->values[] = $value;
        return $this;
    }

    public function getValues(): array {
        return $this->values;
    }


}
