<?php
namespace ShopAPI\Client\Entity;

class Address {

    /**
     * @var string
     */
    protected $phone,
        $email,
        $address,
        $firstName,
        $lastName,
        $company,
        $street,
        $houseNumber,
        $city,
        $zip,
        $country;

    public function getPhone():?string {
        return $this->phone;
    }

    public function setPhone(?string $phone): self {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail():?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getFirstName():?string {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName():?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCompany():?string {
        return $this->company;
    }

    public function setCompany(?string $company) {
        $this->company = $company;
        return $this;
    }

    public function getStreet():?string {
        return $this->street;
    }

    public function setStreet(?string $street): self {
        $this->street = $street;
        return $this;
    }

    public function getHouseNumber(): ?string {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): self {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    public function getCity():?string {
        return $this->city;
    }

    public function setCity(?string $city) {
        $this->city = $city;
        return $this;
    }

    public function getZip():?string {
        return $this->zip;
    }

    public function setZip(?string $zip) {
        $this->zip = $zip;
        return $this;
    }

    public function getCountry():?string {
        return $this->country;
    }

    public function setCountry(?string $country) {
        $this->country = $country;
        return $this;
    }

    public function isEmpty() {
        return strlen(implode('', (array)$this)) === 0;
    }

}
