<?php

class Proposal {
    private $serviceProvidedId;
    private $status;
    private $associateId;

    public function __construct($serviceProvidedId, $status, $associateId)
    {
        $this->serviceProvidedId = $serviceProvidedId;
        $this->status = $status;
        $this->associateId = $associateId;
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
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}