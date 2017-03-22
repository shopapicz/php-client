<?php
namespace ShopAPI\Client;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class HttpClient {
    public function get(string $url): ResponseInterface {
        $ch = $this->createCurl($url);
        return $this->send($ch);
    }

    public function download(string $url, $file): ResponseInterface {
        $ch = $this->createCurl($url);
        curl_setopt($ch, CURLOPT_FILE, $file);
        $response = $this->send($ch);
        if($response->getStatusCode() !== 200) {
            throw new IOException('ShopAPI HTTP request failed with code : HTTP ' . $response->getStatusCode());
        }
        return $response;
    }

    private function send($ch): ResponseInterface {
        $result = curl_exec($ch);
        if($result === false) {
            throw new IOException('Unable to establish connection to ShopAPI: curl error (' . curl_errno($ch) . ') - ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        list($header, $body) = explode("\r\n\r\n", str_replace("HTTP/1.1 100 Continue\r\n\r\n", "", $result), 2);

        return new Response($httpCode, explode("\r\n", $header), $body);
    }

    private function createCurl(string $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-agent' => 'Mozilla/5.0 (compatible; ShopAPI/0.1; +https://shopapi.cz)'
        ]);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if(class_exists('Composer\CaBundle\CaBundle')) {
            curl_setopt($ch, CURLOPT_CAINFO, \Composer\CaBundle\CaBundle::getBundledCaBundlePath());
        }
        return $ch;
    }
}
