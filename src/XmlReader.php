<?php
namespace ShopAPI\Client;

use ShopAPI\Client\Entity\Product;

class XmlReader {

    /**
     * @param string $uid
     * @param string|null $updatedFrom
     * @param bool $preview
     * @param string|null $apiPassword
     * @return resource
     */
    public function download(string $uid, string $updatedFrom = null, bool $preview = false, string $apiPassword = null) {
        $client = new HttpClient();
        return $client->download($this->createUrl($uid, $updatedFrom, $preview), $uid, $apiPassword);
    }

    /**
     * @param string $uid
     * @param null $updatedFrom
     * @param bool $preview
     * @param string|null $apiPassword
     * @return \Generator|Entity\Product[]
     */
    public function readFromUrl($uid, $updatedFrom = null, $preview = false, string $apiPassword = null) {
        if(preg_match('~https://shopapi.cz/feed/([a-z0-9\-]+)~', $uid, $m)) {
            trigger_error("Deprecated parameter \$url - use export UID", E_USER_DEPRECATED);
            $uid = $m[1];
        }

        $tmpFile = $this->download($uid, $updatedFrom, $preview, $apiPassword);

        $tmpFileMeta = stream_get_meta_data($tmpFile);
        if($tmpFileMeta === false) {
            throw new IOException('Couldn\'t read temporary file metadata');
        }
        if(!isset($tmpFileMeta['uri'])) {
            throw new IOException('Couldn\'t read temporary file path');
        }

        foreach ($this->readFromPath($tmpFileMeta['uri']) as $item) {
            yield $item;
        }

        fclose($tmpFile);
    }

    /**
     * @param string $uid
     * @param null|string $updatedFrom
     * @param bool $preview
     * @return string
     */
    public function createUrl($uid, $updatedFrom = null, $preview = false) {
        $query = [];
        if($updatedFrom !== null) {
            if(strtotime($updatedFrom) === FALSE) {
                throw new ArgumentException('Invalid changedFrom format - see https://php.net/strotime');
            }
            $query['updatedFrom'] = $updatedFrom;
        }
        if($preview) {
            $query['preview'] = 'true';
        }

        return 'https://shopapi.cz/feed/' . $uid . (empty($query) ? '' : ('?' . http_build_query($query)));
    }

    /**
     * @param $xmlFilePath
     * @return \Generator|Product[]
     */
    public function readFromPath(string $xmlFilePath) {
        if(!file_exists($xmlFilePath)) {
            throw new IOException('File "' . $xmlFilePath . '" doesn\'t exist');
        }
        $xml = new \XMLReader();
        if(!$xml->open($xmlFilePath)) {
            throw new IOException('Couldn\'t open file ' . $xmlFilePath);
        }

        while ($xml->read() && $xml->name !== 'product') ;

        $decoder = new XmlDecoder();
        do {
            $xmlData = $xml->readOuterXml();
            if(empty($xmlData)) {
                continue;
            }
            yield $decoder->decodeProduct(new \SimpleXMLElement($xmlData));
        } while($xml->next('product'));

        $xml->close();
    }
}
