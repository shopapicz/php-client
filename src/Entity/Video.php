<?php
namespace ShopAPI\Client\Entity;

class Video extends AbstractRecord {
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_VIMEO = 'vimeo';
    /**
     * @var string
     */
    protected $url;

    /**
     * @var \DateTime
     */
    protected $updated;

    /**
     * @var \DateTime
     */
    protected $duration;

    /**
     * @var string
     */
    protected $type, $code;

    public function getUrl(): string {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;
        return $this;
    }

    public function getUpdated(): \DateTime {
        return $this->updated;
    }

    public function setUpdated(\DateTime $updated): self {
        $this->updated = $updated;
        return $this;
    }

    public function getDuration():?\DateTime {
        return $this->duration;
    }

    public function setDuration(?\DateTime $duration): self {
        $this->duration = $duration;
        return $this;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;
        return $this;
    }

    public function isTypeYoutube(): bool {
        return $this->getType() === self::TYPE_YOUTUBE;
    }

    public function isTypeVimeo(): bool {
        return $this->getType() === self::TYPE_VIMEO;
    }

    public function getCode():?string {
        return $this->code;
    }

    public function setCode(?string $code): self {
        $this->code = $code;
        return $this;
    }


}
