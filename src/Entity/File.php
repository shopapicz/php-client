<?php
namespace ShopAPI\Client\Entity;

class File extends AbstractRecord {
    /** @var string */
    private $url;

    /** @var string */
    private $md5;

    /** @var int */
    private $size;

    /** @var string|null */
    private $type;

    /** @var string */
    private $language;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $purpose;

    public function getUrl(): string {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;
        return $this;
    }

    public function getMd5(): string {
        return $this->md5;
    }

    public function setMd5(string $md5): self {
        $this->md5 = $md5;
        return $this;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function setSize(int $size): self {
        $this->size = $size;
        return $this;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(?string $type): self {
        $this->type = $type;
        return $this;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    public function setLanguage(string $language): self {
        $this->language = $language;
        return $this;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getPurpose(): ?string {
        return $this->purpose;
    }

    public function setPurpose(?string $purpose): self {
        $this->purpose = $purpose;
        return $this;
    }
}
