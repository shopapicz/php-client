<?php
namespace ShopAPI\Client\Entity;

class Product extends AbstractItem {

    /**
     * @var Variant[]
     */
    protected $variants = [];

    /**
     * @var Category[]
     */
    protected $categories = [];

    /**
     * @var Video[]
     */
    protected $videos = [];

    /**
     * @var string
     */
    protected $description, $fullDescription, $url;

    /**
     * @var float
     */
    protected $vatRate;

    /**
     * @var int
     */
    protected $warranty;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var bool
     */
    protected $deleted;

    protected $checksum;

    private $compatibilityModels = [];

    /** @var RelevantGroup[] */
    private $relevantGroups = [];

    /**
     * @return Variant[]
     */
    public function getVariants(): array {
        return $this->variants;
    }

    public function addVariant(Variant $variant): self {
        $this->variants[] = $variant;
        return $this;
    }

    /**
     * @param Variant[] $variants
     * @return Product
     */
    public function setVariants(array $variants): self {
        $this->variants = [];
        foreach ($variants as $variant) {
            $this->addVariant($variant);
        }
        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array {
        return $this->categories;
    }

    public function addCategory(Category $category): self {
        $this->categories[] = $category;
        return $this;
    }

    /**
     * @param Category[] $categories
     * @return Product
     */
    public function setCategories(array $categories): self {
        $this->categories = [];
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
        return $this;
    }

    /**
     * @return Video[]
     */
    public function getVideos(): array {
        return $this->videos;
    }

    public function addVideo(Video $video): self {
        $this->videos[] = $video;
        return $this;
    }

    /**
     * @param Video[] $videos
     * @return Product
     */
    public function setVideos(array $videos): self {
        $this->categories = [];
        foreach ($videos as $video) {
            $this->addVideo($video);
        }
        return $this;
    }

    public function getDescription():?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getFullDescription():?string {
        return $this->fullDescription;
    }

    public function setFullDescription(?string $fullDescription): self {
        $this->fullDescription = $fullDescription;
        return $this;
    }

    public function getUrl():?string {
        return $this->url;
    }

    public function setUrl(?string $url): self {
        $this->url = $url;
        return $this;
    }

    public function getVatRate():?float {
        return $this->vatRate;
    }

    public function setVatRate(?float $vatRate): self {
        $this->vatRate = $vatRate;
        return $this;
    }

    public function getWarranty():?int {
        return $this->warranty;
    }

    public function setWarranty(?int $warranty): self {
        $this->warranty = $warranty;
        return $this;
    }

    public function getBrand():?Brand {
        return $this->brand;
    }

    public function setBrand(Brand $brand): self {
        $this->brand = $brand;
        return $this;
    }

    public function getCreated(): \DateTime {
        return $this->created;
    }

    public function setCreated(\DateTime $created): self {
        $this->created = $created;
        return $this;
    }

    public function isDeleted(): bool {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted) {
        $this->deleted = $deleted;
        return $this;
    }

    public function getChecksum(): string {
        return $this->checksum;
    }

    public function setChecksum(string $checksum) {
        $this->checksum = $checksum;
        return $this;
    }

    public function getCompatibilityModels(): array {
        return $this->compatibilityModels;
    }

    public function setCompatibilityModels(array $compatibilityModels): self {
        $this->compatibilityModels = $compatibilityModels;
        return $this;
    }

    /**
     * @return RelevantGroup[]
     */
    public function getRelevantGroups(): array {
        return $this->relevantGroups;
    }

    public function addRelevantGroup(RelevantGroup $group): self {
        $this->relevantGroups[] = $group;
        return $this;
    }
}
