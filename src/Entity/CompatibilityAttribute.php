<?php

namespace ShopAPI\Client\Entity;

class CompatibilityAttribute {
    /** @var string */
    private $uid;

    /** @var string */
    private $name;

    /** @var CompatibilityAttributeValue[] */
    private $values = [];

    public function __construct(string $uid) {
        $this->uid = $uid;
    }

    public function getUid(): string {
        return $this->uid;
    }

    public function setUid(string $uid): self {
        $this->uid = $uid;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * @return CompatibilityAttributeValue[]
     */
    public function getValues(): array {
        return $this->values;
    }

    public function addValue(CompatibilityAttributeValue $value): self {
        $this->values[] = $value;
        return $this;
    }

}
