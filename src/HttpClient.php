<?php
namespace ShopAPI\Client;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

final class HttpClient {
    public function get(string $url): ResponseInterface {
        $ch = $this->createCurl($url);
        return $this->send($ch);
    }

    public function postJson(string $url, array $data, string $username, string $password) {
        $data = json_encode($data);
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => strlen($data),
        ];
        $ch = $this->createCurl($url, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        return $this->send($ch);
    }

    public function download(string $url) {
        $tmpFile = tmpfile();
        if(!$tmpFile) {
            throw new IOException('Temporary file couldn\'t be created');
        }
        $ch = $this->createCurl($url);
        curl_setopt($ch, CURLOPT_FILE, $tmpFile);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = $this->send($ch, false);
        if($response->getStatusCode() !== 200) {
            throw new IOException('ShopAPI download failed with code : HTTP ' . $response->getStatusCode());
        }
        return $tmpFile;
    }

    private function send($ch, bool $hasHeader = true): ResponseInterface {
        $result = curl_exec($ch);
        if($result === false) {
            throw new IOException('Unable to establish connection to ShopAPI: curl error (' . curl_errno($ch) . ') - ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if(!$hasHeader) {
            return new Response($httpCode, [], $result);
        }

        list($header, $body) = explode("\r\n\r\n", str_replace("HTTP/1.1 100 Continue\r\n\r\n", "", $result), 2);

        return new Response($httpCode, explode("\r\n", $header), $body);
    }

    private function createCurl(string $url, array $headers = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            'User-agent' => 'Mozilla/5.0 (compatible; ShopAPI/0.1; +https://shopapi.cz)'
        ], $headers));
        curl_setopt($ch, CURLOPT_HEADER, true);

        if(class_exists('Composer\CaBundle\CaBundle')) {
            curl_setopt($ch, CURLOPT_CAINFO, \Composer\CaBundle\CaBundle::getBundledCaBundlePath());
        }
        return $ch;
    }
}
