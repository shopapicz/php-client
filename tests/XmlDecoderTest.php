<?php
namespace ShopAPI\TestClient;

use ShopAPI\Client\Entity\Availability;
use ShopAPI\Client\XmlDecoder;

class XmlDecoderTest extends \PHPUnit_Framework_TestCase {
    function testAvailability() {
        $decoder = new XmlDecoder();
        $availability = $decoder->decodeAvailability($this->getXml()->availability);

        $this->assertEquals('ihned k odeslání', $availability->getText());
        $this->assertEquals(0, $availability->getHours());
        $this->assertEquals(Availability::IN_STOCK, $availability->getCode());
        $this->assertEquals(6, $availability->getQuantity());
    }

    function testCategory() {
        $decoder = new XmlDecoder();
        $category = $decoder->decodeCategory($this->getXml()->category);

        $this->assertEquals('eab3s6feorw4', $category->getUid());
        $this->assertEquals('vyztužené', $category->getName());
        $this->assertEquals(['Podprsenky', 'vyztužené'], $category->getPath());
    }

    function testImage() {
        $decoder = new XmlDecoder();
        $image = $decoder->decodeImage($this->getXml()->img[0]);

        $this->assertEquals('v2ae564zkhcs', $image->getUid());
        $this->assertEquals(new \DateTime('2016-03-07 15:30:04'), $image->getUpdated());
        $this->assertEquals('https://cdn.shopapi.cz/img/orig/9/8/69/986943cc69c7292472e6f9146934bfa8.jpg', $image->getUrl());
    }

    function testProduct() {
        $decoder = new XmlDecoder();
        $product = $decoder->decodeProduct($this->getXml());

        $this->assertEquals('2mtqj837tow0', $product->getUid());
        $this->assertEquals('Hladká vyztužená podprsenka CHANGE Tactel černá', $product->getName());
        $this->assertEquals(new \DateTime('2016-03-07 15:30:05'), $product->getCreated());
        $this->assertEquals(new \DateTime('2016-03-28 13:59:06'), $product->getUpdated());
        $this->assertFalse($product->isDeleted());

        $this->assertEquals(Availability::IN_STOCK, $product->getAvailability()->getCode());
        $this->assertEquals(0, $product->getAvailability()->getHours());
        $this->assertEquals(6, $product->getAvailability()->getQuantity());
        $this->assertEquals('ihned k odeslání', $product->getAvailability()->getText());

        $this->assertEquals('v2ae564zkhcs', $product->getImages()[0]->getUid());
        $this->assertEquals('https://cdn.shopapi.cz/img/orig/9/8/69/986943cc69c7292472e6f9146934bfa8.jpg', $product->getImages()[0]->getUrl());

        $this->assertEquals(420, $product->getPrice());
        $this->assertEquals(635, $product->getPriceRetail());
        $this->assertEquals(21, $product->getVatRate());

        $this->assertEquals('88000011212', $product->getEan());
        $this->assertEquals('CB19604108-BLACK', $product->getCode());

        $this->assertEquals('89suej9s5ukg', $product->getBrand()->getUid());
        $this->assertEquals('CHANGE Lingerie', $product->getBrand()->getName());

        $this->assertEquals('description', $product->getDescription());
        $this->assertEquals('fulldescription', $product->getFullDescription());

        $this->assertEquals(24, $product->getWarranty());
        $this->assertEquals('https://www.perfektnipradlo.cz/Podprsenky/vyztuzene/Hladka-vyztuzena-podprsenka-CHANGE-Tactel-cerna', $product->getUrl());

        $this->assertEquals('3vbdae456tc0', $product->getVariants()[0]->getUid());
        $this->assertEquals('28q0qb1pvl5w', $product->getVariants()[1]->getUid());


        $this->assertEquals('b9i9ssr4lxk4', $product->getAttributes()[0]->getAttribute()->getUid());
        $this->assertEquals('Barva', $product->getAttributes()[0]->getAttribute()->getName());
        $this->assertEquals(['bílá', 'modrá', 'ocelová'], $product->getAttributes()[0]->getValues());
    }

    function testVariant() {
        $decoder = new XmlDecoder();
        $variant = $decoder->decodeVariant($this->getXml()->variant[0]);

        $this->assertEquals('3vbdae456tc0', $variant->getUid());
        $this->assertEquals('CB19604108-BLACK-E75', $variant->getCode());
        $this->assertEquals('75E', $variant->getName());
        $this->assertEquals(new \DateTime('2016-03-21 15:17:29'), $variant->getUpdated());
        $this->assertEquals(Availability::IN_STOCK, $variant->getAvailability()->getCode());
        $this->assertEquals(0, $variant->getAvailability()->getHours());
        $this->assertEquals(1, $variant->getAvailability()->getQuantity());
        $this->assertEquals('ihned k odeslání', $variant->getAvailability()->getText());

        $this->assertEquals('1ldzlxumqjwk', $variant->getImages()[0]->getUid());
        $this->assertEquals('https://cdn.shopapi.cz/img/orig/c/7/b9/c7b955ce143370c5e9895ef9ab2d5c76.jpg', $variant->getImages()[0]->getUrl());

        $this->assertEquals(420, $variant->getPrice());
        $this->assertEquals(635, $variant->getPriceRetail());

        $this->assertEquals('b9i9ssr4lxk4', $variant->getAttributes()[0]->getAttribute()->getUid());
        $this->assertEquals('Barva', $variant->getAttributes()[0]->getAttribute()->getName());
        $this->assertEquals(['bílá', 'modrá', 'ocelová'], $variant->getAttributes()[0]->getValues());
    }

    function testBrand() {
        $decoder = new XmlDecoder();
        $brand = $decoder->decodeBrand($this->getXml()->brand);

        $this->assertEquals('89suej9s5ukg', $brand->getUid());
        $this->assertEquals('CHANGE Lingerie', $brand->getName());
    }

    function testAttribute() {
        $decoder = new XmlDecoder();
        $attributeValue = $decoder->decodeAttribute($this->getXml()->attribute[0]);

        $this->assertEquals('b9i9ssr4lxk4', $attributeValue->getAttribute()->getUid());
        $this->assertEquals('Barva', $attributeValue->getAttribute()->getName());
        $this->assertEquals(['bílá', 'modrá', 'ocelová'], $attributeValue->getValues());
    }

    private $xml;

    private function getXml() {
        if(!$this->xml) {
            $this->xml = (new \SimpleXMLElement(file_get_contents(__DIR__ . '/single.xml')))->product[0];
        }
        return $this->xml;
    }
}
