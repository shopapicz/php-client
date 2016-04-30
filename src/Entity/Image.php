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


}
