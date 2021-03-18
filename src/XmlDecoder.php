<?php
namespace ShopAPI\Client;

use ShopAPI\Client\Entity\AbstractItem;
use ShopAPI\Client\Entity\Attribute;
use ShopAPI\Client\Entity\AttributeValue;
use ShopAPI\Client\Entity\Availability;
use ShopAPI\Client\Entity\Brand;
use ShopAPI\Client\Entity\Category;
use ShopAPI\Client\Entity\File;
use ShopAPI\Client\Entity\Image;
use ShopAPI\Client\Entity\Product;
use ShopAPI\Client\Entity\RelevantGroup;
use ShopAPI\Client\Entity\Variant;
use ShopAPI\Client\Entity\Video;

class XmlDecoder {
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param \SimpleXMLElement $it
     * @return Product
     */
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

        if(isset($it->video)) {
            foreach ($it->video as $video) {
                $product->addVideo($this->decodeVideo($video));
            }
        }

        if(isset($it->file)) {
            foreach ($it->file as $file) {
                $product->addFile($this->decodeFile($file));
            }
        }

        if(isset($it->variant)) {
            foreach ($it->variant as $variant) {
                $product->addVariant($this->decodeVariant($variant));
            }
        }

        if(isset($it->relevant_group)) {
            foreach ($it->relevant_group as $groupData) {
                $group = new RelevantGroup((string)$groupData['uid']);
                $group->setName((string)$groupData['name']);
                foreach ($groupData->relevant_product as $id) {
                    $group->addProduct((string)$id['uid']);
                }
                $product->addRelevantGroup($group);
            }
        }

        if(isset($it->compatibility_model)) {
            $models = [];
            foreach ($it->compatibility_model as $model) {
                $models[] = (string)$model['uid'];
            }
            $product->setCompatibilityModels($models);
        }

        $product->setChecksum(md5($it->asXML()));
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

        if(isset($it->price_previous_retail_vat)) {
            $item->setPricePreviousRetail((float)$it->price_previous_retail_vat);
        }

        if(isset($it->price_minimal_retail_vat)) {
            $item->setPriceMinimalRetail((float)$it->price_minimal_retail_vat);
        }

        if(isset($it->availability)) {
            $item->setAvailability($this->decodeAvailability($it->availability));

        }

        if(isset($it->weight)) {
            $item->setWeight((int)$it->weight);
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
            $availability->setCode((string)$it['code']);
        }
        if(isset($it['hours'])) {
            $availability->setHours((int)$it['hours']);
        }
        if(isset($it['quantity'])) {
            $availability->setQuantity((int)$it['quantity']);
        }
        if (isset($it['expected'])) {
            $availability->setExpectedDate(\DateTimeImmutable::createFromFormat('Y-m-d', (string)$it['expected']));
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
        $availability->setMd5((string)$it['md5']);

        return $availability;
    }

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return Video
     */
    public function decodeVideo(\SimpleXMLElement $it) {
        if(!isset($it['uid'])) {
            throw new InputException('Missing video attribute "uid"');
        }
        if(!isset($it['code'])) {
            throw new InputException('Missing video attribute "code"');
        }
        if(!isset($it['type'])) {
            throw new InputException('Missing video attribute "type"');
        }
        if(!isset($it['updated'])) {
            throw new InputException('Missing video attribute "updated"');
        }
        $video = new Video((string)$it['uid']);
        $video->setUpdated(\DateTime::createFromFormat(self::DATE_FORMAT, (string)$it['updated']));
        if(isset($it->url)) {
            $video->setUrl((string)$it->url);
        }
        if(isset($it->duration)) {
            $video->setDuration(\DateTime::createFromFormat('H:m:i', $it->duration));
        }
        $video->setCode((string)$it['code']);
        $video->setType((string)$it['type']);

        if(isset($it->title)) {
            $video->setTitle((string)$it->title);
        }

        return $video;
    }

    /**
     * @param \SimpleXMLElement|\SimpleXMLElement[] $it
     * @return File
     */
    public function decodeFile(\SimpleXMLElement $it) {
        if(!isset($it['uid'])) {
            throw new InputException('Missing video attribute "uid"');
        }
        $file = new File((string)$it['uid']);
        if(isset($it->url)) {
            $file->setUrl((string)$it->url);
        }
        if(isset($it->size)) {
            $file->setSize((int)$it->size);
        }
        if(isset($it->language)) {
            $file->setLanguage((string)$it->language);
        }
        if(isset($it->name)) {
            $file->setName((string)$it->name);
        }
        if(isset($it->title)) {
            $file->setTitle((string)$it->title);
        }
        if(isset($it->purpose)) {
            $file->setPurpose((string)$it->purpose);
        }
        if(isset($it->md5)) {
            $file->setMd5((string)$it->md5);
        }
        if(isset($it->type)) {
            $file->setType((string)$it->type);
        }

        return $file;
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
