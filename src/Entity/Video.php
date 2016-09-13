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

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param \DateTime $duration
     */
    public function setDuration(\DateTime $duration) {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isTypeYoutube() {
        return $this->getType() === self::TYPE_YOUTUBE;
    }

    /**
     * @return bool
     */
    public function isTypeVimeo() {
        return $this->getType() === self::TYPE_VIMEO;
    }

    /**
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code) {
        $this->code = $code;
    }


}
