<?php

class Activities
{
    private $_date;
    private $_type;
    private $_category;
    private $_model;
    private $_imei;
    private $_storage;
    private $_ram;
    private $_color;
    private $_phone;
    private $_price;
    private $_client;
    private $_addedby;
    private $_notes;
    private $_ID;

    public function setID($id) {
        $this->_ID = $id;
    }

    public function getID() {
        return $this->_ID;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }
    public function getDate()
    {
        return $this->_date;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }
    public function getType()
    {
        return $this->_type;
    }

    public function setCategory($category)
    {
        $this->_category = $category;
    }
    public function getcategory()
    {
        return $this->_category;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }
    public function getModel()
    {
        return $this->_model;
    }

    public function setImei($imei)
    {
        $this->_imei = $imei;
    }
    public function getImei()
    {
        return $this->_imei;
    }

    public function setStorage($storage)
    {
        $this->_storage = $storage;
    }
    public function getStorage()
    {
        return $this->_storage;
    }

    public function setRam($ram)
    {
        $this->_ram = $ram;
    }
    public function getRam()
    {
        return $this->_ram;
    }

    public function setColor($color)
    {
        $this->_color = $color;
    }
    public function getColor()
    {
        return $this->_color;
    }

    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }
    public function getPhone()
    {
        return $this->_phone;
    }

    public function setClient($client)
    {
        $this->_client = $client;
    }
    public function getClient()
    {
        return $this->_client;
    }

    public function setAddedby($addedby)
    {
        $this->_addedby = $addedby;
    }
    public function getAddedby()
    {
        return $this->_addedby;
    }

    public function setNotes($notes)
    {
        $this->_notes = $notes;
    }
    public function getNotes()
    {
        return $this->_notes;
    }

    public function setPrice($price){
        $this->_price = $price;
    }
    public function getPrice(){
        $this->_price;
    }
}