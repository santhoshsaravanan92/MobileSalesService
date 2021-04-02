<?php

class Expense
{
    private $_date;
    private $_category;
    private $_price;
    private $_notes;
    private $_createdby;
    private $_modifiedby;
    private $_id;

    public function setDate($date)
    {
        $this->_date = $date;
    }
    public function getDate()
    {
        return $this->_date;
    }

    public function setCategory($category)
    {
        $this->_category = $category;
    }
    public function getCategory()
    {
        return $this->_category;
    }

    public function setPrice($price)
    {
        $this->_price = $price;
    }
    public function getPrice()
    {
        return $this->_price;
    }

    public function setNotes($notes)
    {
        $this->_notes = $notes;
    }
    public function getNotes()
    {
        return $this->_notes;
    }

    public function setCreatedby($createdby)
    {
        $this->_createdby = $createdby;
    }
    public function getCreatedby()
    {
        return $this->_createdby;
    }

    public function setModifiedby($modifiedby)
    {
        $this->_modifiedby = $modifiedby;
    }
    public function getModifiedby()
    {
        return $this->_modifiedby;
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