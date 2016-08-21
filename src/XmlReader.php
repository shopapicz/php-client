<?php
namespace ShopAPI\Client;

use ShopAPI\Client\Entity\Product;

class XmlReader {

    /**
     * @param string $uid
     * @param null $updatedFrom
     * @param bool $preview
     * @return \Generator|Entity\Product[]
     */
    public function readFromUrl($uid, $updatedFrom = null, $preview = false) {
        if(preg_match('~https://shopapi.cz/feed/([a-z0-9]+)~', $uid, $m)) {
            trigger_error("Deprecated parameter \$url - use export UID", E_USER_DEPRECATED);
            $uid = $m[1];
        }

        $tmpFile = tmpfile();
        if(!$tmpFile) {
            throw new IOException('Temporary file couldn\'t be created');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->createUrl($uid, $updatedFrom, $preview));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_FILE, $tmpFile);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-agent' => 'Mozilla/5.0 (compatible; ShopAPI/0.1; +https://shopapi.cz)'
        ]);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if(class_exists('Kdyby\CurlCaBundle\CertificateHelper')) {
            curl_setopt($ch, CURLOPT_CAINFO, \Kdyby\CurlCaBundle\CertificateHelper::getCaInfoFile());
        }
        $result = curl_exec($ch);
        if($result === false) {
            throw new IOException('Unable to establish connection to ShopAPI: curl error (' . curl_errno($ch) . ') - ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpCode !== 200) {
            throw new IOException('Feed download failed: HTTP ' . $httpCode);
        }
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
    public function readFromPath($xmlFilePath) {
        $xml = new \XMLReader();
        $xml->open($xmlFilePath);

        while ($xml->read() && $xml->name !== 'product') ;

        $decoder = new XmlDecoder();
        while ($xmlData = $xml->readOuterXml()) {
            yield $decoder->decodeProduct(new \SimpleXMLElement($xmlData));
            $xml->next('product');
        }

        $xml->close();
    }
}
