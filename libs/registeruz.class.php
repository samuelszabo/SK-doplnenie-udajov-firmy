<?php

class registerUZ {
  private $searchtext;
  private $searchfield = 'ico';
  
  private function getDetailURL($id) {
     return 'http://www.registeruz.sk/cruz-public/api/uctovna-jednotka?id='.$id;
  }
  private function getSearchUrl() {
    return 'http://www.registeruz.sk/cruz-public/api/uctovne-jednotky?zmenene-od=2000-01-01&pokracovat-za-id=1&max-zaznamov=1&'.$this->searchfield.'='.$this->searchtext;
  }
  
  public function getResponse($url) {
    
    $content = file_get_contents($url);
    if(!$content) return false;
    $obj = json_decode($content);
    if(!isset($obj->id)) return false;
    return $obj;
  }
  
  function findFirstRecord() {
     $obj1 = $this->getResponse($this->getSearchUrl());
     if(!isset($obj1->id)) return false;
     $obj2 = $this->getResponse($this->getDetailURL($obj1->id[0]));
     if(!isset($obj2->id)) return false;
     return $this->parseReturn($obj2);
  }
  
  private function parseReturn($obj) {
    $foundico = $obj->ico; 
    if($this->searchfield=='ico' && $this->searchtext!=$foundico) return array();
    
     $return = array();
     $return['nazov'] = $obj->nazovUJ;
     $return['ulica'] = $obj->ulica;
     $return['mesto'] = $obj->mesto;
     $return['psc'] = $obj->psc;
     $return['ico'] = $obj->ico;
     $return['dic'] = $obj->dic;
     return array_map('trim',$return); 
  }
  
  public function setText($text) {
    $this->searchtext = $text;
  }
  public function setField($field) {
    $this->searchfield = $field;
  }
  public function setICO($ico) {
     $this->setText(preg_replace("/[^0-9]/","",$ico));
     $this->searchfield('ico');
  }
  
  
  
  function getResult() {
    $record = $this->findFirstRecord();
    if(!$record) return array();
    return $record; 
  }
  
  
}
