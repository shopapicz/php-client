<?php
namespace ShopAPI\Client\Api\OrderRequest;

class OrderResponse {
    /**
     * @var ?string
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    public function __construct(?string $code, ?string $message) {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(): ?string {
        return $this->code;
    }

    public function getMessage(): ?string {
        return $this->message;
    }
}
