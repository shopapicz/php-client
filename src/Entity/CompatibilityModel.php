<?php

namespace ShopAPI\Client\Entity;

class CompatibilityModel {
    /** @var string */
    private $uid;

    /** @var string */
    private $name;

    /** @var CompatibilityAttribute[] */
    private $attributes = [];

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
     * @return CompatibilityAttribute[]
     */
    public function getAttributes(): array {
        return $this->attributes;
    }

    public function addAttribute(CompatibilityAttribute $attribute): self {
        $this->attributes[] = $attribute;
        return $this;
    }

}
