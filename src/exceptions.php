<?php

namespace ShopAPI\Client;

use Psr\Http\Message\ResponseInterface;

abstract class RuntimeException extends \RuntimeException {

}

abstract class LogicException extends \LogicException {

}

class ArgumentException extends LogicException {

}

class InputException extends RuntimeException {

}

class IOException extends RuntimeException {

}

class UnauthorizedException extends IOException {

}

class ApiRequestException extends IOException {
    /**
     * @var array
     */
    private $messages;

    /**
     * @var array
     */
    private $fieldsMessages;

    /**
     * @var ResponseInterface|null
     */
    private $httpResponse;

    public function __construct(array $messages = [], array $fieldsMessages = [], $code = 0, ResponseInterface $response = null) {
        $message = $messages;
        foreach ($fieldsMessages as $name => $value) {
            $valueCopy = $value;
            $values = [];
            array_walk_recursive($valueCopy, function ($a) use (&$values) {
                $values[] = $a;
            });
            $messages[] = $name . ': ' . implode(', ', $values);
        }
        parent::__construct(implode("\n", $message), $code);
        $this->messages = $messages;
        $this->fieldsMessages = $fieldsMessages;
        $this->httpResponse = $response;
    }

    public function getMessages(): array {
        return $this->messages;
    }

    public function getFieldsNames(): array {
        return array_keys($this->messages);
    }

    public function getFieldMessages(string $fieldName): array {
        return $this->fieldsMessages[$fieldName] ?? [];
    }

    public function getHttpResponse(): ?ResponseInterface {
        return $this->httpResponse;
    }

}
