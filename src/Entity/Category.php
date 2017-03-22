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

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getPath(): array {
        return $this->path;
    }

    /**
     * @param string[] $path
     * @return Category
     */
    public function setPath(array $path): self {
        $this->path = $path;
        return $this;
    }


}
