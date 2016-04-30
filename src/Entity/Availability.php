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

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Availability
     */
    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getHours() {
        return $this->hours;
    }

    /**
     * @param int $hours
     * @return Availability
     */
    public function setHours($hours) {
        $this->hours = $hours;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param int $code
     * @return Availability
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Availability
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

}
