<?php
namespace ShopAPI\Client\Api\OrderRequest;

class OrderRequestItem {
    /**
     * @var string
     */
    private $uid;

    /**
     * @var integer
     */
    private $quantity;

    public function __construct(string $uid, int $quantity) {
        $this->uid = $uid;
        $this->quantity = $quantity;
    }

    public function getUid(): string {
        return $this->uid;
    }

    public function setUid(string $uid): OrderRequestItem {
        $this->uid = $uid;
        return $this;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): OrderRequestItem {
        $this->quantity = $quantity;
        return $this;
    }


}
