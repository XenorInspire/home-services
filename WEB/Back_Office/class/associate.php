<?php

class Associate
{
    private $associateId;
    private $lastName;
    private $firstName;
    private $email;
    private $phoneNumber;
    private $address;
    private $town;
    private $sirenNumber;
    private $companyName;
    private $enable;
    private $password;

    public function __construct($associateId, $lastName, $firstName, $email, $phoneNumber, $address, $town, $sirenNumber, $companyName, $enable, $password)
    {
        $this->associateId = $associateId;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->town = $town;
        $this->sirenNumber = $sirenNumber;
        $this->companyName = $companyName;
        $this->enable = $enable;
        $this->password = $password;
    }

    /**
     * Get the value of associateId
     */
    public function getAssociateId()
    {
        return $this->associateId;
    }

    /**
     * Set the value of associateId
     *
     * @return  self
     */
    public function setAssociateId($associateId)
    {
        $this->associateId = $associateId;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

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
     * Get the value of sirenNumber
     */
    public function getSirenNumber()
    {
        return $this->sirenNumber;
    }

    /**
     * Set the value of sirenNumber
     *
     * @return  self
     */
    public function setSirenNumber($sirenNumber)
    {
        $this->sirenNumber = $sirenNumber;

        return $this;
    }

    /**
     * Get the value of companyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set the value of companyName
     *
     * @return  self
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

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

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}