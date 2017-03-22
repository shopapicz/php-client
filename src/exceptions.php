<?php
namespace ShopAPI\Client;

use Exception;

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
     * @var
     */
    private $fieldsMessages;

    public function __construct(array $messages = [], array $fieldsMessages = [], $code = 0, Exception $previous = null) {
        parent::__construct(implode("\n", $messages), $code, $previous);
        $this->messages = $messages;
        $this->fieldsMessages = $fieldsMessages;
    }

    public function getMessages(): array {
        return $this->messages;
    }

    public function getFieldsNames(): array {
        return array_keys($this->messages);
    }

    public function getFieldMessages(string $fieldName): array {
        return $this->fieldsMessages[$fieldName]??[];
    }

}
