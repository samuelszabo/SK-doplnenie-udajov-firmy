<?php

if(isset($_GET['ico'])) $_GET['ico'] = preg_replace("/[^0-9]/","",$_GET['ico']);
if(isset($_GET['dic'])) $_GET['dic'] = preg_replace("/[^0-9]/","",$_GET['dic']); 

$url1 = 'http://www.registeruz.sk/cruz-public/api/uctovne-jednotky?zmenene-od=2000-01-01&pokracovat-za-id=1&max-zaznamov=1&'.http_build_query ($_GET);

$json = file_get_contents($url1);
$obj1 = json_decode($json);


if(!$obj1->id) die(json_encode(array('error'=>'Nenajdeny subjekt')));

$url2 = 'http://www.registeruz.sk/cruz-public/api/uctovna-jednotka?id='.$obj1->id[0];

$obj2 = json_decode(file_get_contents($url2));
$obj2->icdph = '';

if($obj2->dic) {  //kontrola ICDPH
  $countryCode = 'SK';
  $vatNo = $obj2->dic;
  $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
  $obj3 = $client->checkVat(array(
    'countryCode' => $countryCode,
    'vatNumber' => $vatNo
  ));
  
  if($obj3->valid) {
    $obj2->icdph = $countryCode.$vatNo;
  }
}

echo json_encode($obj2);
