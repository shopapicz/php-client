<?php
namespace ShopAPI\Client\Entity;

class Availability {

    const IN_STOCK = 'in_stock';
    const OUT_OF_STOCK = 'out_of_stock';
    const PRE_ORDER = 'pre_order';
    const UNKNOWN = 'unknown';
    const UNAVAILABLE = 'unavailable';

    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $hours, $code, $quantity;

    public function getText():?string {
        return $this->text;
    }

    public function setText(?string $text): self {
        $this->text = $text;
        return $this;
    }

    public function getHours():?int {
        return $this->hours;
    }

    public function setHours(?int $hours) {
        $this->hours = $hours;
        return $this;
    }

    public function getCode():?string {
        return $this->code;
    }

    public function setCode(?string $code): self {
        $this->code = $code;
        return $this;
    }

    public function getQuantity():?int {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self {
        $this->quantity = $quantity;
        return $this;
    }

    public function isInStock(): bool {
        return $this->getCode() === self::IN_STOCK;
    }

    public function isOutOfStock(): bool {
        return $this->getCode() === self::OUT_OF_STOCK;
    }

    public function isPreOrder(): bool {
        return $this->getCode() === self::PRE_ORDER;
    }

    public function isUnavailable(): bool {
        return $this->getCode() === self::UNAVAILABLE;
    }

}
