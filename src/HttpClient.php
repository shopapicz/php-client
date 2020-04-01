<?php

namespace ShopAPI\Client;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

final class HttpClient {

    public function postJson(string $url, array $data, string $username, string $password) {
        $data = json_encode($data);
        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        ];
        $ch = $this->createCurl($url, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        return $this->send($ch);
    }

    public function get(string $url, array $query, string $username, string $password) {
        $headers = [
            'Content-Type: application/json',
        ];
        if(!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        $ch = $this->createCurl($url, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

        return $this->send($ch);
    }

    public function download(string $url, string $apiUser = null, string $apiPassword = null) {
        $tmpFile = tmpfile();
        if(!$tmpFile) {
            throw new IOException('Temporary file couldn\'t be created');
        }
        $ch = $this->createCurl($url);
        curl_setopt($ch, CURLOPT_FILE, $tmpFile);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15 * 60);

        if($apiUser !== null && $apiPassword !== null) {
            curl_setopt($ch, CURLOPT_USERPWD, $apiUser . ':' . $apiPassword);
        }

        $response = $this->send($ch);
        if($response->getStatusCode() !== 200) {
            throw new IOException('ShopAPI download failed with code : HTTP ' . $response->getStatusCode());
        }
        return $tmpFile;
    }

    private function send($ch): ResponseInterface {
        $result = curl_exec($ch);
        if($result === false) {
            throw new IOException('Unable to establish connection to ShopAPI: curl error (' . curl_errno($ch) . ') - ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $responseHeaders = '';
        $responseContent = $result;

        $headersSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        if($headersSize) {
            $responseHeaders = rtrim(substr($result, 0, $headersSize));
            $responseContent = (strlen($result) === $headersSize)
                ? ''
                : substr($result, $headersSize);
        }
        // Split headers blocks
        $responseHeaders = preg_split('/(\\r?\\n){2}/', $responseHeaders);
        $responseHeaders = preg_split('/\\r?\\n/', array_pop($responseHeaders));
        $headers = [];
        foreach ($responseHeaders as $header) {
            if(preg_match('/^HTTP\/(1\.\d) +([1-5][0-9]{2}) +.+$/', $header, $matches)) {
                $headers['Protocol-Version'] = $matches[1];
                $headers['Status'] = $matches[2];
            } elseif(strpos($header, ':') !== false) {
                list($name, $value) = explode(':', $header, 2);
                $headers[$name] = trim($value);
            }
        }


        return new Response($httpCode, $headers, $responseContent);
    }

    private function createCurl(string $url, array $headers = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            'User-agent: Mozilla/5.0 (compatible; ShopAPI/0.1; +https://shopapi.cz)'
        ], $headers));
        curl_setopt($ch, CURLOPT_HEADER, true);

        if(class_exists('Composer\CaBundle\CaBundle')) {
            curl_setopt($ch, CURLOPT_CAINFO, \Composer\CaBundle\CaBundle::getBundledCaBundlePath());
        }
        return $ch;
    }
}
