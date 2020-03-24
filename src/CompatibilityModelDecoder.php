<?php

namespace ShopAPI\Client;

use ShopAPI\Client\Entity\CompatibilityAttribute;
use ShopAPI\Client\Entity\CompatibilityAttributeValue;
use ShopAPI\Client\Entity\CompatibilityModel;

class CompatibilityModelDecoder {
    public function decodeModel(\stdClass $data): CompatibilityModel {
        $model = new CompatibilityModel($data->uid);
        $model->setName($data->name);
        if(isset($data->attributes)) {
            foreach ($data->attributes as $attributeData) {
                $attribute = new CompatibilityAttribute($attributeData->uid);
                $attribute->setName($attributeData->name);
                foreach ($attributeData->values as $valueData) {
                    $attribute->addValue((new CompatibilityAttributeValue($valueData->uid))->setName($valueData->name));
                }
                $model->addAttribute($attribute);
            }
        }

        return $model;
    }
}
