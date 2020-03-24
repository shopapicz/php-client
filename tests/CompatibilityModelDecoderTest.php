<?php
namespace ShopAPI\TestClient;

use PHPUnit\Framework\TestCase;
use ShopAPI\Client\CompatibilityModelDecoder;

class CompatibilityModelDecoderTest extends TestCase {
    function testAvailability() {
        $decoder = new CompatibilityModelDecoder();
        $model = $decoder->decodeModel($this->getJson());

        $this->assertSame('74p3dbcjppwc', $model->getUid());
        $this->assertSame('AF1 125 Futura (1990)', $model->getName());

        $this->assertCount(5, $model->getAttributes());
        $this->assertSame('2v188xp7jke8', $model->getAttributes()[0]->getUid());
        $this->assertSame('Typ', $model->getAttributes()[0]->getName());

        $this->assertCount(1, $model->getAttributes()[0]->getValues());
        $this->assertSame('23sfe1vxzp0k', $model->getAttributes()[0]->getValues()[0]->getUid());
        $this->assertSame('Motocykly', $model->getAttributes()[0]->getValues()[0]->getName());
    }

    private function getJson(): \stdClass {
        return json_decode(file_get_contents(__DIR__ . '/compatibility-model.json'));
    }
}
