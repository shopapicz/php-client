<?php
namespace ShopAPI\Client;

use ShopAPI\Client\Entity\CompatibilityModel;

class CompatibilityModelReader {

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient = null) {
        $this->httpClient = $httpClient ?: new HttpClient();
    }

    /**
     * @param string $uid
     * @param string|null $apiPassword
     * @return \Generator|CompatibilityModel[]
     */
    public function read(string $uid, string $apiPassword = null) {
        $tmpFile = $this->httpClient->download('https://shopapi.cz/feed/' . $uid . '/models.ndjson', $uid, $apiPassword);

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
     * @param string $jsonFilePath
     * @return \Generator|CompatibilityModel[]
     */
    public function readFromPath(string $jsonFilePath) {
        if(!file_exists($jsonFilePath)) {
            throw new IOException('File "' . $jsonFilePath . '" doesn\'t exist');
        }

        $decoder = new CompatibilityModelDecoder();
        $fp = fopen($jsonFilePath, 'r');
        while(($line = fgets($fp)) !== false) {
            if(empty(trim($line))) {
                continue;
            }
            yield $decoder->decodeModel(json_decode($line));
        }

        fclose($fp);

        yield from [];
    }

}
