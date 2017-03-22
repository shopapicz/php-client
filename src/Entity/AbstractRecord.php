<?php
namespace ShopAPI\Client\Entity;


abstract class AbstractRecord {
    /**
     * @var string
     */
    protected $uid;

    function __construct($uid) {
        $this->uid = $uid;
    }

    public function getUid(): string {
        return $this->uid;
    }

    public function setUid(string $uid): self {
        $this->uid = $uid;
        return $this;
    }
}
