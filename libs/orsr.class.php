<?php
class orsr {
  var $searchtext;
  var $searchfield = 'ICO';
  
  private function getDetailURL($id) {
     return 'http://orsr.sk/vypis.asp?ID='.$id; 
  }
  private function getSearchUrl() {
    return 'http://orsr.sk/hladaj_ico.asp?'.$this->searchfield.'='.$this->searchtext.'&SID=0';
  }
  
  public function getResponse($url) {
    $content = file_get_contents($url);
    if(!$content) return false;
    return iconv('CP1250','UTF-8',$content);
  }
  
  function findFirstRecord() {
    $html1 = $this->getResponse($this->getSearchUrl());
    
    
    preg_match_all('/vypis\.asp\?ID=([0-9a-z\&\=\;]{1,})/i',$html1,$found);
        
    if($found && isset($found[1]) && isset($found[1][0])) {
      $html2 = $this->getResponse($this->getDetailURL(html_entity_decode ($found[1][0])));
      preg_match_all('/<tr>\s+?<td.+?>\s+?(.+?<span class=\'ra\'>.+?<\/span>.+?)<\/tr>/is',$html2,$found2);
      
      
      
      if($found2)
        return $this->parseReturn($found2[1]);
      else
        return array();
    }
  }
  
  private function setText($text) {
    $this->searchtext = $text;
  }
  private function setField($field) {
    $this->searchfield = strtoupper($field);
  }
  
  private function parseReturn($arrayFounds) {
    if(!is_array($arrayFounds) OR !$arrayFounds) return array();

    $founds = array();
    foreach($arrayFounds as $k=>$v) {
      if(preg_match('/<span class="tl">(.+?)<\/span>/is',$v,$f))
        $field = trim(str_replace(array('&nbsp;',':'),'',$f[1]));
      else
        $field = $k;
      if(preg_match_all('/<span class=\'ra\'>(.+?)<\/span>/is',$v,$f))
        $values = array_map('trim',$f[1]);
      else
        $values = '';
      $founds[$field] = $values;
    } 
        
    
    $foundico = preg_replace("/[^0-9]/","",$founds['IČO'][0]);
    
    if($this->searchfield=='ICO' && ($this->searchtext*1)!=($foundico*1)) return array();
     $return = array();
     $return['nazov'] = $founds['Oddiel'][0];
     unset($founds['Sídlo'][count($founds['Sídlo'])-1]);  //vymazanie   (od: .....)
    
     if(count($founds['Sídlo'])==1) { //iba mesto / obec
       $return['ulica'] = '';
       $return['mesto'] = $founds['Sídlo'][0]; 
       $return['psc'] = '';
     } elseif(count($founds['Sídlo'])==2) {   //obec + psc
       $return['ulica'] = '';
       $return['mesto'] = $founds['Sídlo'][0];
       $return['psc'] = $founds['Sídlo'][1];
     } else {   //ulica s/bez cisla + obec + psc
       
       $return['psc'] = $founds['Sídlo'][count($founds['Sídlo'])-1];
       unset($founds['Sídlo'][count($founds['Sídlo'])-1]);
       $return['mesto'] = $founds['Sídlo'][count($founds['Sídlo'])-1];
       unset($founds['Sídlo'][count($founds['Sídlo'])-1]);
       $return['ulica'] = implode(' ',$founds['Sídlo']);
     }
     $return['ico'] = $foundico;
     return array_map('trim',$return);
  }
  public function setICO($ico) {
     $this->setText(preg_replace("/[^0-9]/","",$ico));
     $this->setField('ico');
  }
  
  function getResult() {
     $record = $this->findFirstRecord();
     if(!$record) return array();
     return $record;
  }
  
  
}