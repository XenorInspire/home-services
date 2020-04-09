<?php

class AdditionalPrice
{
    private $additionalPriceId;
    private $serviceProvidedId;
    private $description;
    private $price;

    public function __construct($additionalPriceId, $serviceProvidedId, $description, $price)
    {
        $this->additionalPriceId = $additionalPriceId;
        $this->serviceProvidedId = $serviceProvidedId;
        $this->description = $description;
        $this->price = $price;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    public function getAdditionalPriceId()
    {
        return $this->additionalPriceId;
    }
    public function getServiceProvidedId()
    {
        return $this->serviceProvidedId;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getPrice()
    {
        return $this->price;
    }

    public function setAdditionalPriceId($additionalPriceId)
    {
        $this->additionalPriceId = $additionalPriceId;
        return $this;
    }

    public function setServiceProvidedId($serviceProvidedId)
    {
        $this->serviceProvidedId = $serviceProvidedId;
        return $this;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}
