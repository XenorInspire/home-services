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

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of serviceProvidedId
     */
    public function getServiceProvidedId()
    {
        return $this->serviceProvidedId;
    }

    /**
     * Set the value of serviceProvidedId
     *
     * @return  self
     */
    public function setServiceProvidedId($serviceProvidedId)
    {
        $this->serviceProvidedId = $serviceProvidedId;

        return $this;
    }

    /**
     * Get the value of additionalPriceId
     */
    public function getAdditionalPriceId()
    {
        return $this->additionalPriceId;
    }

    /**
     * Set the value of additionalPriceId
     *
     * @return  self
     */
    public function setAdditionalPriceId($additionalPriceId)
    {
        $this->additionalPriceId = $additionalPriceId;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}
