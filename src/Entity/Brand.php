<?php
namespace ShopAPI\Client\Entity;

class Brand extends AbstractRecord {
    /**
     * @var string
     */
    protected $name;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }


}
