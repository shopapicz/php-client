<?php
namespace ShopAPI\Client\Entity;

class Image extends AbstractRecord {
    /**
     * @var string
     */
    protected $url;

    /**
     * @var \DateTime
     */
    protected $updated;

    /**
     * @var string
     */
    protected $md5;

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

    public function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
        return $this;
    }

    public function getMd5(): string {
        return $this->md5;
    }

    public function setMd5(string $md5) {
        $this->md5 = $md5;
        return $this;
    }
}
