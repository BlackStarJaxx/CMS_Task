<?php
/*$url = "https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5";
$curl = curl_init($url);
if ( $curl ){
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    $page = curl_exec($curl);
    curl_close($curl);
    unset($curl);
    $xml = new SimpleXMLElement($page);

    echo $xml->row[0]->exchangerate['ccy'][0].': ';
    echo $xml->row[0]->exchangerate['buy'][0].' - ';
    echo $xml->row[0]->exchangerate['sale'][0].' || ';
    echo $xml->row[1]->exchangerate['ccy'][0].': ';
    echo $xml->row[1]->exchangerate['buy'][0].' - ';
    echo $xml->row[1]->exchangerate['sale'][0];
}*/

$url = "https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5";

$curl = curl_init($url);
if ( $curl ) {
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $page = curl_exec($curl);
    curl_close($curl);
    unset($curl);
    $xml = new SimpleXMLElement($page);

    $data = [];
    foreach ($xml->row as $row) {
        $data[] = [
            'ccy' => $row->exchangerate['ccy'][0],
            'buy' => $row->exchangerate['buy'][0],
            'sale' => $row->exchangerate['sale'][0]
        ];
    }
    print_r($data);
}
?>
