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
}
