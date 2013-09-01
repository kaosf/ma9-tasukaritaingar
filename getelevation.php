<?php
//------------------------------------------------
// 標高取得CGI
//------------------------------------------------
ini_set( 'display_errors', 1 );
include("./inc/function.php");

define( "D_API_GNAVI_KEY" , "37nQczCznAwz9nnwrvB6nAbf9omgsPBvjgLzDAngimwRnQLyeinggzB5nQZv5LpRt8JQoROLF5pRdzTP");

// パラメーター処理
$lat = $_GET["lat"]; // スタート地点
$lon = $_GET["lon"]; // ゴール地点

$elev_url  = "http://test.cgi.e-map.ne.jp/cgi/get_elevation.cgi?key=" .D_API_GNAVI_KEY. "&enc=UTF8&dtype=0&outf=XML";
$elev_url .= "&lldata=" .$lat. ',' .$lon;
$xml = curl( $elev_url, "GET" ,10);
$xml_array  = xml_to_array($xml);
//print "<pre>";
//print_r($xml_array);
//print "</pre>";
//print($xml_array["result"]["item"]["elevation"]);
$pushjson = array();

if ( !empty($xml_array["result"]) ){
	
	$pushjson["elevation"] = $xml_array["result"]["item"]["elevation"];
}
echo json_encode($pushjson);