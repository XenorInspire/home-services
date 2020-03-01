<?php

class Customer
{
    private $id;
    private $firstname;
    private $lastname;
    private $mail;
    private $phone_number;
    private $address;
    private $city;
    private $password;

    public function __construct($firstname, $lastname, $mail, $phone_number, $address, $city, $password)
    {
        $this->firstname = htmlspecialchars(trim($firstname));
        $this->lastname = htmlspecialchars(trim($lastname));
        $this->mail = $mail;
        $this->phone_number = $phone_number;
        $this->address = htmlspecialchars(trim($address));
        $this->city = htmlspecialchars(trim($city));
        $this->password = hash('sha512', $password . 'ChrysaleadProject');
        $this->id = NULL;
    }

    /**
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function setCity($city)
    {
        $this->city = $city;
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

     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get the value of phone_number
     */
    public function getPhone_number()
    {
        return $this->phone_number;
    }

    /**
     * Set the value of phone_number

     */
    public function setPhone_number($phone_number)
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    /**
     * Get the value of mail
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
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
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
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
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId()
    {
        date_default_timezone_set('Europe/Paris');
        $this->id = hash('sha256', $this->getLastname() . date('dMY-H:m:s') . $this->getPhone_number());
        return $this;
    }
}
