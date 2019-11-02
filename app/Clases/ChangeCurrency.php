<?php


namespace App\Clases;


use App\Currency;

class ChangeCurrency
{
    public function __construct()
    {

        $url="https://api.exchangeratesapi.io/latest";
        $curl = curl_init($url);
        if ( $curl ) {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            unset($curl);
            $decode=json_decode($response);
            foreach ($decode->rates as $name => $rate){
                Currency::updateOrCreate([
                    "name"=>$name,

                ],
                    [
                        "name"=>$name,
                        "exchange"=>$rate,
                    ]);

            }

        }
    }
}
