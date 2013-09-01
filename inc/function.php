<?PHP
//------------------------------------------------
// 通信関係
//------------------------------------------------
function curl( $url, $method = "GET", $timeout = 10 ) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1");
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS , 3);
	
	if( $method == "POST" ) {
		$u = explode( "?", $url );
		curl_setopt($ch,CURLOPT_URL,$u[0]);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$u[1]);
	} else {
		curl_setopt($ch, CURLOPT_URL, $url);
	}
	
	$res= curl_exec($ch);
	curl_close($ch);
	
	if($res) {
		return $res;
	} else {
		return false;
	}
}



// リダイレクト
function redirect( $url ) {
	header( "location: " . $url );
	
	printf( "<a href='%s'>%s</a>", $url, $url );
	exit;
}



//------------------------------------------------
// もろもろ
//------------------------------------------------
function dms2dig( $ll ) {
	$l = explode( ".", $ll );
	$l = $l[0] + $l[1]/60 + (float)($l[2].".".$l[3])/60/60;

	return $l;
}
function ll_dist($lat1, $lon1, $lat2, $lon2){
	//
	$lat_average = deg2rad( $lat1 + (($lat2 - $lat1) / 2) );//２点の緯度の平均
	$lat_difference = deg2rad( $lat1 - $lat2 );//２点の緯度差
	$lon_difference = deg2rad( $lon1 - $lon2 );//２点の経度差
	$curvature_radius_tmp = 1 - 0.00669438 * pow(sin($lat_average), 2);
	$meridian_curvature_radius = 6335439.327 / sqrt(pow($curvature_radius_tmp, 3));//子午線曲率半径
	$prime_vertical_circle_curvature_radius = 6378137 / sqrt($curvature_radius_tmp);//卯酉線曲率半径
	
	//２点間の距離
	$distance = pow($meridian_curvature_radius * $lat_difference, 2) + pow($prime_vertical_circle_curvature_radius * cos($lat_average) * $lon_difference, 2);
	$distance = sqrt($distance);
	
	return intval($distance);
}
function ll_degree( $lat1, $lng1, $lat2, $lng2 ) {
	$y = intval($lat1 * 36000) - intval($lat2 * 36000);
	$x = intval($lng1 * 36000) - intval($lng2 * 36000);
	
	$i = 0;
	// x と y が 0 の時は算出できない
	if ( ( $x == 0 ) && ( $y == 0 ) ) return false;
	// 角度θを算出
	$i = acos( $x / sqrt( $x * $x + $y * $y ) );
	// ラジアンを度へ変換
	$i = ( $i / pi() ) * 180;
	// θ>πの時
	if ( $y < 0 ) $i = 360 - $i;
	
	return $i;
}

function randhit( $per ) {
	return mt_rand( 0, 100 ) <= $per;
}

function alert( $type = "", $id= "" ) {
	redirect( "./alert.php?type=" . $type . "&id=" . $id );
	exit;
}

function perdice( $per = 10 ) {
	if( floor(mt_rand( 0, 100 )) < $per ) {
		return true;
	} else {
		return false;
	}
}

/**
 * 測地系変換
 */
// 世界測地系→日本測地系
function Wgs2Tky( $lat, $lng ) {
	$lat1 = $lat + 0.00010696*$lat - 0.000017467*$lng - 0.0046020;
	$lng1 = $lng + 0.000046047*$lat + 0.000083049*$lng - 0.010041;
	
	return array( $lat1, $lng1 );
}
// 日本測地系→世界測地系
function Tky2Wgs( $lat, $lng){
	$lat1 = $lat - $lat * 0.00010695 + $lng * 0.000017464 + 0.0046017;
	$lng1 = $lng - $lat * 0.000046038 - $lng * 0.000083043 + 0.010040;
	
	return array( $lat1, $lng1 );
}


/**
 * ちょっと便利
 */
//xmlを配列に変換
function xml_to_array( $xml ){
	$simple_xml = simplexml_load_string($xml);
	$array = json_decode( json_encode( $simple_xml ), true );
	
	return $array;
}

?>
