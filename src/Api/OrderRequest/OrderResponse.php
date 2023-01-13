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

    /**
     * @var string|null
     */
    private $artifactsTemporaryUrl;

    public function __construct(?string $code, ?string $message, ?string $artifactsTemporaryUrl) {
        $this->code = $code;
        $this->message = $message;
        $this->artifactsTemporaryUrl = $artifactsTemporaryUrl;
    }

    public function getCode(): ?string {
        return $this->code;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function getArtifactsTemporaryUrl(): ?string {
        return $this->artifactsTemporaryUrl;
    }
}
