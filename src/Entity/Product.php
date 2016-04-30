<?php
namespace ShopAPI\Client\Entity;

class Product extends AbstractItem {

    /**
     * @var Variant[]
     */
    protected $variants = [];

    /**
     * @var Category[]
     */
    protected $categories = [];

    /**
     * @var string
     */
    protected $description, $fullDescription, $url;

    /**
     * @var float
     */
    protected $vatRate;

    /**
     * @var int
     */
    protected $warranty;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var bool
     */
    protected $deleted;

    /**
     * @return Variant[]
     */
    public function getVariants() {
        return $this->variants;
    }

    public function addVariant(Variant $variant) {
        $this->variants[] = $variant;
        return $this;
    }

    /**
     * @param Variant[] $variants
     * @return Product
     */
    public function setVariants(array $variants) {
        $this->variants = [];
        foreach ($variants as $variant) {
            $this->addVariant($variant);
        }
        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories() {
        return $this->categories;
    }

    public function addCategory(Category $category) {
        $this->categories[] = $category;
        return $this;
    }

    /**
     * @param Category[] $categories
     * @return Product
     */
    public function setCategories(array $categories) {
        $this->categories = [];
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullDescription() {
        return $this->fullDescription;
    }

    /**
     * @param string $fullDescription
     * @return Product
     */
    public function setFullDescription($fullDescription) {
        $this->fullDescription = $fullDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Product
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * @return float
     */
    public function getVatRate() {
        return $this->vatRate;
    }

    /**
     * @param float $vatRate
     * @return Product
     */
    public function setVatRate($vatRate) {
        $this->vatRate = $vatRate;
        return $this;
    }

    /**
     * @return int
     */
    public function getWarranty() {
        return $this->warranty;
    }

    /**
     * @param int $warranty
     * @return Product
     */
    public function setWarranty($warranty) {
        $this->warranty = $warranty;
        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return Product
     */
    public function setBrand(Brand $brand) {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Product
     */
    public function setCreated(\DateTime $created) {
        $this->created = $created;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted() {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     * @return Product
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
        return $this;
    }

}
