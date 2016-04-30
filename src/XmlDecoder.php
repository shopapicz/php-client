<?php
namespace ShopAPI\Client;

use ShopAPI\Client\Entity\AbstractItem;
use ShopAPI\Client\Entity\Attribute;
use ShopAPI\Client\Entity\AttributeValue;
use ShopAPI\Client\Entity\Availability;
use ShopAPI\Client\Entity\Brand;
use ShopAPI\Client\Entity\Category;
use ShopAPI\Client\Entity\Image;
use ShopAPI\Client\Entity\Product;
use ShopAPI\Client\Entity\Variant;

class XmlDecoder {
    const DATE_FORMAT = 'Y-m-d H:i:s';

    public function decodeProduct(\SimpleXMLElement $it) {
        if(!isset($it->uid)) {
            throw new InputException('Missing product attribute "uid"');
        }
        foreach (['created', 'updated', 'deleted'] as $attribute) {
            if(!isset($it[$attribute])) {
                throw new InputException('Missing product attribute "' . $attribute . '"');
            }
        }
        $product = new Product((string)$it->uid);
        $product->setCreated(\DateTime::createFromFormat(self::DATE_FORMAT, (string)$it['created']));
        $product->setUpdated(\DateTime::createFromFormat(self::DATE_FORMAT, (string)$it['updated']));
        $product->setDeleted((string)$it['deleted'] === 'true');

        if(isset($it->description)) {
            $product->setDescription((string)$it->description);
        }
        if(isset($it->fulldescription)) {
            $product->setFullDescription((string)$it->fulldescription);
        }
        if(isset($it->warranty)) {
            $product->setWarranty((int)$it->warranty);
        }

        if(isset($it->url)) {
            $product->setUrl((string)$it->url);
        }

        if(isset($it->vat)) {
            $product->setVatRate((float)$it->vat);
        }

        if(isset($it->brand)) {
            $product->setBrand($this->decodeBrand($it->brand));
        }


        if(isset($it->category)) {
            foreach ($it->category as $category) {
                $product->addCategory($this->decodeCategory($category));
            }
        }

        if(isset($it->variant)) {
            foreach ($it->variant as $variant) {
                $product->addVariant($this->decodeVariant($variant));
            }
        }

        $this->decodeItem($it, $product);

        return $product;
    }

    /**
     * @param \SimpleXMLElement $it
     * @param AbstractItem $item
     */
    protected function decodeItem(\SimpleXMLElement $it, AbstractItem $item) {
        if(isset($it->name)) {
            $item->setName((string)$it->name);
        }

        if(isset($it->ean)) {
            $item->setEan((string)$it->ean);
        }

        if(isset($it->code)) {
            $item->setCode((string)$it->code);
        }

        if(isset($it->price_vat)) {
            $item->setPrice((float)$it->price_vat);
        }

        if(isset($it->price_retail_vat)) {
            $item->setPriceRetail((float)$it->price_retail_vat);
        }

        if(isset($it->availability)) {
            $item->setAvailability($this->decodeAvailability($it->availability));

        }

        if(isset($it->img)) {
            foreach ($it->img as $img) {
                $item->addImage($this->decodeImage($img));
            }
        }

        if(isset($it->attribute)) {
            foreach ($it->attribute as $attribute) {
                $item->addAttribute($this->decodeAttribute($attribute));
            }
        }
    }

    /**
     * @var Brand[]
     */
    protected $brands = [];

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return Brand
     */
    public function decodeBrand(\SimpleXMLElement $it) {
        if(!isset($it['uid'])) {
            throw new InputException('Missing brand attribute "uid"');
        }
        if(!isset($this->brands[(string)$it['uid']])) {
            $this->brands[(string)$it['uid']] = (new Brand((string)$it['uid']))
                ->setName((string)$it);
        }

        return $this->brands[(string)$it['uid']];
    }

    protected $availabilityCodes = [
        'in_stock' => Availability::IN_STOCK,
        'out_of_stock' => Availability::OUT_OF_STOCK,
        'unavailable' => Availability::UNAVAILABLE,
        'pre_order' => Availability::PRE_ORDER,
        'unknown' => Availability::UNKNOWN,
    ];

    /**
     * @var Category[]
     */
    protected $categories = [];

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return Category
     */
    public function decodeCategory(\SimpleXMLElement $it) {
        if(!isset($it['uid'])) {
            throw new InputException('Missing category attribute "uid"');
        }
        if(!isset($this->categories[(string)$it['uid']])) {
            $path = explode('|', (string)$it);
            $this->categories[(string)$it['uid']] = (new Category((string)$it['uid']))
                ->setPath($path)
                ->setName($path[count($path) - 1]);
        }

        return $this->categories[(string)$it['uid']];
    }

    /**
     * @var Attribute[]
     */
    protected $attributes = [];

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return AttributeValue
     */
    public function decodeAttribute(\SimpleXMLElement $it) {
        if(!isset($it['uid'])) {
            throw new InputException('Missing attribute attribute "uid"');
        }
        if(!isset($it->name)) {
            throw new InputException('Missing attribute attribute "name"');
        }
        if(!isset($it->value)) {
            throw new InputException('Missing attribute attribute "value"');
        }
        /** @todo "updated" */

        if(!isset($this->attributes[(string)$it['uid']])) {
            $this->attributes[(string)$it['uid']] = (new Attribute((string)$it['uid']))
                ->setName((string)$it->name);
        }
        $attributeValue = new AttributeValue($this->attributes[(string)$it['uid']]);
        foreach ($it->value as $value) {
            $attributeValue->addValue((string)$value);
        }
        return $attributeValue;
    }

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return Availability
     */
    public function decodeAvailability(\SimpleXMLElement $it) {
        $availability = new Availability();
        if(isset($it['code'])) {
            $availability->setCode($this->availabilityCodes[(string)$it['code']]);
        }
        if(isset($it['hours'])) {
            $availability->setHours((int)$it['hours']);
        }
        if(isset($it['quantity'])) {
            $availability->setQuantity((int)$it['quantity']);
        }
        if(strlen((string)$it) > 0) {
            $availability->setText((string)$it);
        }
        return $availability;
    }

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return Image
     */
    public function decodeImage(\SimpleXMLElement $it) {
        if(!isset($it['uid'])) {
            throw new InputException('Missing image attribute "uid"');
        }
        if(!isset($it['updated'])) {
            throw new InputException('Missing image attribute "updated"');
        }
        $availability = new Image((string)$it['uid']);
        $availability->setUpdated(\DateTime::createFromFormat(self::DATE_FORMAT, (string)$it['updated']));
        $availability->setUrl((string)$it);

        return $availability;
    }

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return Variant
     */
    public function decodeVariant(\SimpleXMLElement $it) {
        if(!isset($it->uid)) {
            throw new InputException('Missing variant attribute "uid"');
        }
        if(!isset($it['updated'])) {
            throw new InputException('Missing variant attribute "updated"');
        }
        $variant = new Variant((string)$it->uid);
        $variant->setUpdated(\DateTime::createFromFormat(self::DATE_FORMAT, (string)$it['updated']));

        $this->decodeItem($it, $variant);

        return $variant;
    }
}
