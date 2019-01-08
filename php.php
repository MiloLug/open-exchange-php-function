function convert_currency_USD($from,$value){
	$currency=json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'),true);
	$currencyUAH=json_decode(file_get_contents('https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=3'),true);
	$total=(float)$value;
	$code=$from;
	$USD=0;
	if($code=="RUR")
		$code="RUB";
	if($code=="UAH"){
		$UAHtoUSD=0;
		for($i=0;$i<count($currencyUAH);$i++){
			if($currencyUAH[$i]["ccy"]=="USD"){
				$UAHtoUSD=$currencyUAH[$i]["buy"];
				break;
			}
		}
		$USD=$total/$UAHtoUSD;
	}else{
		if($code=="EUR")
			$EUR=$total;
		else
			$EUR=$total/$currency["rates"][$code];
		$USD=$EUR*$currency["rates"]["USD"];
	}
	return $USD;
}
