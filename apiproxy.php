<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
//echo '<pre>';
//odstranenie neziaducich znakov z requestu
if(isset($_GET['ico'])) $_GET['ico'] = preg_replace("/[^0-9]/","",$_GET['ico']);
if(isset($_GET['dic'])) $_GET['dic'] = preg_replace("/[^0-9]/","",$_GET['dic']);


include('libs/SK-doplnenie-udajov-firmy.php');
include('libs/registeruz.class.php');
include('libs/orsr.class.php');
include('libs/vies.class.php');


$search = new skDoplnenieUdajovFirmy;

$search->setField('ico');
$search->setSearchText($_GET['ico']);
$result = $search->getResult();

if(!$result) echo json_encode(array('error'=>'ICO nenajdene'));
else echo json_encode($result);

/*
Alternativne, zobrazit vysledky zo vsetkych registrov:
$results = $search->getAllResults();
$print_r($results);

*/