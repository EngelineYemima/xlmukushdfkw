<?php
function getnumber(){
	echo "awalan nmer menggunakan 62\n";
	echo "Example : 6287765202202\n";
	echo "msisdn : ";
	$msisdn = trim(fgets(STDIN));
	return $msisdn;
}
function getotp(){
	echo "Masukkan OTP :";
	$otp = trim(fgets(STDIN));
	return $otp;
}

function getserviceid(){
	echo "DAFTAR PAKET\n";
	$list=array(
		'1 waze and chat 1hr',
  		'2 waze and chat 3hr',
  		'3 waze and chat 7hr',
  		'4 unli instagram 1hr sahur',
  		'5 unli instagram 3hr sahur',
  		'6 unli instagram 7hr sahur',
  		'7 unli instagram 1hr ngabubur',
  		'8 unli instagram 3hr ngabubur',
  		'9 unli instagram 7hr ngabubur',
  		'10 unli fb 1 hr sahur',
  		'11 unli fb 3hr sahur',
  		'12 unli fb 7hr sahur',
  		'13 unli fb 1hr ngabuburit',
  		'14 unli fb 3hr ngabuburit',
  		'15 unli fb 7hr  ngabuburit',
  		'16 Xtra Kuota Streaming&Chat Sahur 1hr',
  		'17 Xtra Kuota Streaming&Chat Sahur 3hr',
  		'18 Xtra Kuota Streaming&Chat Sahur 7hr',
  		'19 Xtra Kuota Streaming&Chat ngabuburit 1hr',
  		'20 Xtra Kuota Streaming&Chat ngabuburit 3hr',
  		'21 Xtra Kuota Streaming&Chat ngabuburit 7hr',
                '22 input service id manual');

  		
	foreach($list as $lists){
		echo "$lists\n";
	}

	echo "\nPilih Paket : ";
	$a = trim(fgets(STDIN));

	switch($a){
		case '1' :
			$serviceid = 8211369;
			break;
		case '2' :
			$serviceid = 8211370;
			break;
		case '3' :
			$serviceid = 8211371;
			break;
		case '4' :
			$serviceid = 8211372;
			break;
		case '5' :
			$serviceid = 8211373;
			break;
		case '6' :
			$serviceid = 8211374;
			break;
		case '7' :
			$serviceid = 8211375;
			break;
		case '8' :
			$serviceid = 8211376;
			break;
		case '9' :
			$serviceid = 8211377;
			break;
		case '10' :
			$serviceid = 8211378;
			break;
		case '11' :
			$serviceid = 8211379;
			break;
		case '12' :
			$serviceid = 8211380;
			break;
		case '13' :
			$serviceid = 8211381;
			break;
		case '14' :
			$serviceid = 8211382;
			break;
		case '15' :
			$serviceid = 8211383;
			break;
		case '16' :
			$serviceid = 8211384;
			break;
		case '17' :
			$serviceid = 8211385;
			break;
		case '18' :
			$serviceid = 8211386;
			break;
		case '19' :
			$serviceid = 8211387;
			break;
		case '20' :
			$serviceid = 8211388;
			break;
		case '21' :
			$serviceid = 8211389;
			break;
                case '22' :
	                echo "\nservice id : ";
	                $serviceid = trim(fgets(STDIN));
                        break;
		}
	return $serviceid;
}

function mintaotp($msisdn,$ReqID,$imei){
	$bod = array( 
		"Header"=>null,
 		"Body"=>[
  			"Header"=>[
   				"ReqID"=>"$ReqID054410",
   				"IMEI"=>"$imei"],
  			"LoginSendOTPRq"=>[
   			"msisdn"=>"$msisdn"]],
   		"sessionId"=>null,
 		"onNet"=>"True",
 		"platform"=>"02",
 		"serviceId"=>"",
 		"packageAmt"=>"",
 		"reloadType"=>"",
 		"reloadAmt"=>"",
 		"packageRegUnreg"=>"",
 		"appVersion"=>"3.8.2",
 		"sourceName"=>"Others",
 		"sourceVersion"=>"",
 		"screenName"=>"login.enterLoginNumber");
	$body = json_encode($bod);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/LoginSendOTPRq');
	$header = array(
		'Content-Type: application/json',
  		'Keep-Alive: true');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	$hasil = curl_exec($ch);
	$hasil1 = explode(',', $hasil);
	echo '{{'. $hasil1[1];
}

function login($msisdn,$otp,$ReqID,$imei){
	$bod1 = array(
		"Header"=>null,
	 "Body"=>[
	  "Header"=>[
	   "ReqID"=>"$ReqID054636",
	   "IMEI"=>"$imei"],
	  "LoginValidateOTPRq"=>[
	   "headerRq"=>[
	    "requestDate"=>"20190625",
	    "requestId"=>"$ReqID054636",
	    "channel"=>"MYXLPRELOGIN"],
	   "msisdn"=>"$msisdn",
	   "otp"=>"$otp"]],
	 "sessionId"=>null,
	 "platform"=>"02",
	 "msisdn_Type"=>"P",
	 "serviceId"=>"",
	 "packageAmt"=>"",
	 "reloadType"=>"",
	 "reloadAmt"=>"",
	 "packageRegUnreg"=>"",
	 "appVersion"=>"3.8.2",
	 "sourceName"=>"Others",
	 "sourceVersion"=>"",
	 "screenName"=>"login.enterLoginOTP",
	 "mbb_category"=>"");
	$body1 = json_encode($bod1);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/LoginValidateOTPRq');
	$header = array(
	  'Content-Type: application/json',
	  'Keep-Alive: true',
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body1);
	$hasil = curl_exec($ch);
	$hasil1 = json_decode($hasil);
	$sessionid = $hasil1->sessionId;
	$hasil2 = explode(',', $hasil);
	echo "$hasil2[1]\n";
	return $sessionid;
	}

function beli($msisdn,$sessionid,$serviceid,$imei,$ReqID){
	$bod2 = array(
	  "Header"=>null,
	  "Body"=>[
	   "HeaderRequest"=>[
     "applicationID"=>"3",
     "applicationSubID"=>"1",
     "touchpoint"=>"MYXL",
     "requestID"=>"$ReqID132245",
     "msisdn"=>"$msisdn",
     "serviceID"=>"$serviceid"],
	    "opPurchase"=>[
     "msisdn"=>"$msisdn",
     "serviceid"=>"$serviceid"],
	    "XBOXRequest"=>[
     "requestName"=>"GetSubscriberMenuId",
     "Subscriber_Number"=>"1301235663",
     "Source"=>"mapps",
     "Trans_ID"=>"119520832111",
     "Home_POC"=>"BJ0",
     "PRICE_PLAN"=>"513738114",
     "PayCat"=>"PRE-PAID",
     "Active_End"=>"20190615",
     "Grace_End"=>"20190715",
     "Rembal"=>"0",
     "IMSI"=>"510120032177230",
     "IMEI"=>"$imei",
     "Shortcode"=>"mapps"],
	    "Header"=>[
     "IMEI"=>"$imei",
     "ReqID"=>"$ReqID132245"]],
	   "sessionId"=>"$sessionid",
	   "serviceId"=>"$serviceid",
	   "packageRegUnreg"=>"Reg",
	   "reloadType"=>"",
	   "reloadAmt"=>"",
	   "packageAmt"=>"99.000",
	   "platform"=>"02",
   "appVersion"=>"3.8.2",
   "sourceName"=>"Others",
   "sourceVersion"=>"",
   "msisdn_Type"=>"P",
     "screenName"=>"home.storeFrontReviewConfirm",
   "mbb_category"=>"");
	$body2 = json_encode($bod2);
	$ch = curl_init();
	$header = array('Content-Type: application/json', 'Referer: https://my.xl.co.id/pre/index1.html', 'Accept-Encoding: gzip, deflate, br', 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7');
	curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/opPurchase');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body2);
	$hasil = curl_exec($ch);
	echo "\n$hasil\n";
	return;
}
echo date('l, d-m-Y  h:i:s a');
$ReqID = date('Ymd');
$imei = 1588165532;
for ($o = 1; $o > 0; $o++){
	echo "\nMenu\n";
	echo "1.Minta Password\n";
	echo "2.Login dan beli paket\n";
	echo "3.beli ulang\n";
        echo "4.keluar\n";
        echo "tentukan pilihan : ";
	$i = trim(fgets(STDIN));
	switch($i){
	case '1':
		$anu = getnumber();
		$anu1 = mintaotp($anu,$ReqID,$imei);
		break;
	case '2':
		$anu = getnumber();
		$anu1 = getotp();
		$anu2 = login($anu,$anu1,$ReqID,$imei);
	case '3':
		$anu5 = getserviceid();
		echo "$anu2\n" . "$anu\n" . "$anu1\n";
                system(clear);
		$anu4 = beli($anu,$anu2,$anu5,$imei,$ReqID);
		echo "\njika paket tidak masuk silahkan ketik 3 di menu pilihan\n";
		break;
	case '4':
		exit('terimakasih sudah menggunakan tools ini');
		break;
	}
}
