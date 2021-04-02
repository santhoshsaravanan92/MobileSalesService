<?php

class Dashboard {
    private $_salesincount;
    private $_salesoutcount;
    private $_salesinamount;
    private $_salesoutamount;
    private $_serviceinamount;
    private $_serviceoutamount;
    private $_serviceincount;
    private $_serviceoutcount;
    private $_totalexpense;

    public function setSalesInCount($salesincount) {
        $this->_salesincount = $salesincount;
    }
    public function getSalesInCount() {
        return $this->_salesincount;
    }

    public function setSalesInAmount($salesinamont) {
        $this->_salesinamount = $salesinamont;
    }
    public function getSalesInAmount() {
        return $this->_salesinamount;
    }

    public function setSalesOutCount($salesoutcount) {
        $this->_salesoutcount = $salesoutcount;
    }
    public function getSalesOutCount() {
        return $this->_salesoutcount;
    }

    public function setSalesOutAmount($salesoutamount) {
        $this->_salesoutamount = $salesoutamount;
    }
    public function getSalesOutAmount() {
        return $this->_salesoutamount;
    }

    public function setTotalExpense($expense){
        $this->_totalexpense = $expense;
    }
    public function getTotalExpense(){
        return $this->_totalexpense;
    }

    public function setServiceInAmount($serviceinamount){
        $this->_serviceinamount = $serviceinamount;
    }
    public function getServiceInAmount(){
        return $this->_serviceinamount;
    }

    public function setServiceOutCount($serviceoutcount){
        $this->_serviceoutcount = $serviceoutcount;
    }
    public function getServiceOutCount(){
        return $this->_serviceoutcount;
    }


    public function setServiceInCount($serviceincount){
        $this->_serviceincount = $serviceincount;
    }
    public function getServiceInCount(){
        return $this->_serviceincount;
    }
    public function setServiceOutAmount($serviceoutamount){
        $this->_serviceoutamount = $serviceoutamount;
    }
    public function getServiceOutAmount(){
        return $this->_serviceoutamount;
    }
}