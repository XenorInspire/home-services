<?php

class Customer
{
    private $customerId;
    private $firstname;
    private $lastname;
    private $email;
    private $phoneNumber;
    private $address;
    private $town;
    private $password;
    private $enable;

    public function __construct($customerId, $firstname, $lastname, $email, $phoneNumber, $address, $town, $password, $enable)
    {
        $this->customerId = $customerId;
        $this->firstname = htmlspecialchars(trim($firstname));
        $this->lastname = htmlspecialchars(trim($lastname));
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = htmlspecialchars(trim($address));
        $this->town = htmlspecialchars(trim($town));
        $this->password = $password;
        $this->enable = $enable;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId
     *
     * @return  self
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get the value of town
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set the value of town
     *
     * @return  self
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * Get the value of enable
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set the value of enable
     *
     * @return  self
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

}
