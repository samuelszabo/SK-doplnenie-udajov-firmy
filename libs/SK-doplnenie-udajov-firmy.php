<?php
class skDoplnenieUdajovFirmy {
  private $searchtext;
  private $searchfield = 'ico';
  
  private $result;
  private $orsr_result = array();
  private $registeruz_result = array();
  
  
  public function setSearchText($text) {
    $this->searchtext = $text;
  }
  
  public function setField($field) {
    $this->searchfield = $field;
  }
  
  private function mergeResults($result1) {
    foreach($result1 as $k=>$v) {
      if(empty($this->result[$k])) $this->result[$k] = $v;
    }                      
  }
  
  public function getAllResults() {
    $this->getResult();
    
    return array(
      'result'=>$this->result,
      'orsr_result'=>$this->orsr_result,
      'registeruz_result'=>$this->registeruz_result,
    );
  }
  
  public function getResult() {
    if(!$this->searchtext) return array();
    
    //ak je ICO, skusime ORSR
    if($this->searchfield=='ico') {
      $orsr = new orsr;
      $orsr->setICO($this->searchtext);
      
      $this->orsr_result = $orsr->getResult();
      if(is_array($this->orsr_result) && $this->orsr_result)
        $this->mergeResults($this->orsr_result);
    }
    
    //ak je ICO alebo DIC, skusime registeruz
    if(in_array($this->searchfield,array('ico','dic'))) {
      $registeruz = new registeruz;
      $registeruz->setText($this->searchtext);
      $registeruz->setField($this->searchfield);
      $this->registeruz_result = $registeruz->getResult();
      
      if(is_array($this->registeruz_result) && $this->registeruz_result)
        $this->mergeResults($this->registeruz_result);
    }
    
    //ak vieme dic, overime ICDPH
    if(!empty($this->result['dic'])) {
      $vies = new vies;
      $vies->setVatNo($this->result['dic']);
      if($vies->isValid()) {
        $this->result['icdph'] = $vies->getVatNo();        
      } elseif(!empty($this->result['icdph'])) {
        $this->result['icdph'] = '';
      }
    }
    
    return $this->result;
    
  }
}