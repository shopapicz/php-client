<?php
namespace ShopAPI\Client\Entity;

class Category extends AbstractRecord {
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $path;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param \string[] $path
     * @return Category
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }


}
