<?php
namespace ShopAPI\Client\Entity;

class Brand extends AbstractRecord {
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
     * @return Brand
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }


}
