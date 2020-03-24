<?php

namespace ShopAPI\Client\Entity;

class CompatibilityAttributeValue {
    /** @var string */
    private $uid;

    /** @var string */
    private $name;

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

}
