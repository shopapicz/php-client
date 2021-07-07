<?php

namespace ShopAPI\TestClient;

use PHPUnit\Framework\TestCase;
use ShopAPI\Client\IOException;
use ShopAPI\Client\XmlReader;

class XmlReaderIncompleteTest extends TestCase {

    public function testFailOnIncompleteXml(): void {
        $reader = new XmlReader();
        $this->expectException(IOException::class);
        iterator_to_array($reader->readFromPath(__DIR__ . '/incomplete.xml'));
    }

    public function testFailOnIncomplete2Xml(): void {
        $reader = new XmlReader();
        $this->expectException(IOException::class);
        iterator_to_array($reader->readFromPath(__DIR__ . '/incomplete2.xml'));
    }

}
