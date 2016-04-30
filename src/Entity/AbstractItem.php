<?php
namespace ShopAPI\Client\Entity;

class AbstractItem extends AbstractRecord {
    /**
     * @var string
     */
    protected $name, $ean, $code;

    /**
     * @var float
     */
    protected $price, $priceRetail;

    /**
     * @var Image[]
     */
    protected $images = [];

    /**
     * @var AttributeValue[]
     */
    protected $attributes = [];

    /**
     * @var \DateTime
     */
    protected $updated;

    /**
     * @var Availability
     */
    protected $availability;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEan() {
        return $this->ean;
    }

    /**
     * @param string $ean
     * @return $this
     */
    public function setEan($ean) {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return $this
     */
    public function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceRetail() {
        return $this->priceRetail;
    }

    /**
     * @param float $priceRetail
     * @return $this
     */
    public function setPriceRetail($priceRetail) {
        $this->priceRetail = $priceRetail;
        return $this;
    }

    /**
     * @return Image[]
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * @param Image[] $images
     * @return $this
     */
    public function setImages(array $images) {
        $this->images = [];
        foreach ($images as $image) {
            $this->addImage($image);
        }
        return $this;
    }

    public function addImage(Image $image) {
        $this->images[] = $image;
        return $this;
    }

    /**
     * @return AttributeValue[]
     */
    public function getAttributes() {
        return array_values($this->attributes);
    }

    /**
     * @param string $uid
     * @return null|AttributeValue
     */
    public function getAttribute($uid) {
        return isset($this->attributes[$uid]) ? $this->attributes[$uid] : null;
    }

    /**
     * @param AttributeValue[] $attributeValues
     * @return $this
     */
    public function setAttributes(array $attributeValues) {
        $this->attributes = [];
        foreach ($attributeValues as $attributeValue) {
            $this->addAttribute($attributeValue);
        }
        return $this;
    }

    public function addAttribute(AttributeValue $attributeValue) {
        $this->attributes[$attributeValue->getAttribute()->getUid()] = $attributeValue;
        return $this;
    }

    /**
     * @return Availability
     */
    public function getAvailability() {
        return $this->availability;
    }

    /**
     * @param Availability $availability
     * @return $this
     */
    public function setAvailability(Availability $availability) {
        $this->availability = $availability;
        return $this;
    }


}
