<?php
namespace ShopAPI\Client\Api\OrderRequest;

use ShopAPI\Client\Entity\Address;
use ShopAPI\Client\Entity\Delivery;

class OrderRequest {
    /**
     * @var Address|null
     */
    private $deliveryAddress;

    /**
     * @var Address|null
     */
    private $invoiceAddress;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var Delivery|null
     */
    private $delivery;

    /**
     * @var OrderRequestItem[]
     */
    private $items = [];

    public function getDeliveryAddress():?Address {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Address $deliveryAddress): self {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    public function getInvoiceAddress():?Address {
        return $this->invoiceAddress;
    }

    public function setInvoiceAddress(?Address $invoiceAddress): self {
        $this->invoiceAddress = $invoiceAddress;
        return $this;
    }

    public function getNote():?string {
        return $this->note;
    }

    public function setNote(?string $note): self {
        $this->note = $note;
        return $this;
    }

    public function getDelivery():?Delivery {
        return $this->delivery;
    }

    public function setDeliveryByUid(?string $uid): self {
        $this->delivery = $uid === null ? null : new Delivery($uid);
        return $this;
    }

    /**
     * @return OrderRequestItem[]
     */
    public function getItems(): array {
        return $this->items;
    }

    public function addItemByUid(string $uid, int $quantity): self {
        if(isset($this->items[$uid])) {
            $this->items[$uid]->setQuantity($this->items[$uid]->getQuantity() + $quantity);
        } else {
            $this->items[$uid] = new OrderRequestItem($uid, $quantity);
        }
        return $this;
    }
}
