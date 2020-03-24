<?php

namespace ShopAPI\Client\Entity;

class RelevantGroup {
    /** @var string */
    private $uid;

    /** @var string */
    private $name;

    /** @var string[] */
    private $products = [];

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

    public function getProducts(): array {
        return $this->products;
    }

    public function addProduct(string $uid): self {
        $this->products[] = $uid;
        return $this;
    }
}
