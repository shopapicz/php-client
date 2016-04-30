<?php
namespace ShopAPI\Client\Entity;

class Attribute extends AbstractRecord {
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Attribute
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }


}
