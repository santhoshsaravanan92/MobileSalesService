<?php

class Profile
{
    private $_email;
    private $_companyname;
    private $_name;
    private $_mobile;
    private $_address;
    private $_gst;
    private $_landline;
    private $_website;
    private $_accountNumber;
    private $_branchName;
    private $_bankName;
    private $_ifsc;
    private $_id;

    public function setEmail($email)
    {
        $this->_email = $email;
    }
    public function getEmail()
    {
        return $this->_email;
    }

    public function setCompany($companyname)
    {
        $this->_companyname = $companyname;
    }
    public function getCompany()
    {
        return $this->_companyname;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }
    public function getName()
    {
        return $this->_name;
    }

    public function setMobile($mobile)
    {
        $this->_mobile = $mobile;
    }
    public function getMobile()
    {
        return $this->_mobile;
    }

    public function setAddress($address)
    {
        $this->_address = $address;
    }
    public function getAddress()
    {
        return $this->_address;
    }

    public function setGST($gst)
    {
        $this->_gst = $gst;
    }
    public function getGST()
    {
        return $this->_gst;
    }

    public function setLandline($landline)
    {
        $this->_landline = $landline;
    }
    public function getLandline()
    {
        return $this->_landline;
    }

    public function setWebsite($website)
    {
        $this->_website = $website;
    }
    public function getWebsite()
    {
        return $this->_website;
    }

    public function setAccountNumber($accountNumber)
    {
        $this->_accountNumber = $accountNumber;
    }
    public function getAccountNumber()
    {
        return $this->_accountNumber;
    }

    public function setBranchName($branchName)
    {
        $this->_branchName = $branchName;
    }
    public function getBranchName()
    {
        return $this->_branchName;
    }

    public function setBankName($bankName)
    {
        $this->_bankName = $bankName;
    }
    public function getBankName()
    {
        return $this->_bankName;
    }

    public function setIfsc($ifsc)
    {
        $this->_ifsc = $ifsc;
    }
    public function getIfsc()
    {
        return $this->_ifsc;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }
    public function getId()
    {
        return $this->_id;
    }
}
