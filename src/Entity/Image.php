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

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Image
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Image
     */
    public function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return string
     */
    public function getMd5() {
        return $this->md5;
    }

    /**
     * @param string $md5
     * @return Image
     */
    public function setMd5($md5) {
        $this->md5 = $md5;
        return $this;
    }
}
