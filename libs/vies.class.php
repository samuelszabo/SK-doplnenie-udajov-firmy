<?php
class vies {
  var $countryCode = 'SK';
  var $vatNo;
  
  public function setCountryCode($countryCode) {
    $this->countryCode = strtoupper($countryCode);
  }
  public function setVatNo($vatNo) {
    $this->vatNo =  preg_replace("/[^0-9]/","",$vatNo);
  }
  
  public function getVatNo() {
    if(!$this->vatNo) return false;
     return $this->countryCode.$this->vatNo;
  }
  
  public function isValid() {
    $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
    $obj3 = $client->checkVat(array(
      'countryCode' => $this->countryCode,
      'vatNumber' => $this->vatNo
    ));
  
    if($obj3->valid) {
      return true;
    }
    return false;
  }
}