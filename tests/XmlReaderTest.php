<?php
namespace ShopAPI\TestClient;

use ShopAPI\Client\XmlReader;

class XmlReaderTest extends \PHPUnit_Framework_TestCase {

    function testPathReader() {
        $reader = new XmlReader();

        $items = [];
        foreach ($reader->readFromPath($this->getXmlPath()) as $item) {
            $items[] = $item;
        }
        $this->assertCount(2, $items);

        $this->assertEquals('2mtqj837tow0', $items[0]->getUid());
        $this->assertEquals('9aonzpsewrgg', $items[1]->getUid());
    }

    function testUrl() {
        $reader = new XmlReader();
        $this->assertEquals('https://shopapi.cz/feed/aaaaaa41', $reader->createUrl('aaaaaa41'));
        $this->assertEquals('https://shopapi.cz/feed/aaaaaa41?preview=true', $reader->createUrl('aaaaaa41', null, true));
        $this->assertEquals('https://shopapi.cz/feed/aaaaaa41?updatedFrom=-12+hours', $reader->createUrl('aaaaaa41', '-12 hours'));
        $this->assertEquals('https://shopapi.cz/feed/aaaaaa41?updatedFrom=-12+hours&preview=true', $reader->createUrl('aaaaaa41', '-12 hours', true));
    }

    private function getXmlPath() {
        return __DIR__ . '/multi.xml';
    }
}
