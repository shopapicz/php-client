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

    /**
     * @return string
     */
    public function getUid() {
        return $this->uid;
    }

    /**
     * @param string $uid
     * @return $this
     */
    public function setUid($uid) {
        $this->uid = $uid;
        return $this;
    }
}
