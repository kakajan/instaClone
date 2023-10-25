<?php

namespace App\Library;

class SendSMS
{
    public static function sendVerification($phone_number, $vc)
    {
        try {
            $client = new \SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
            $user = "salimbh";
            $pass = "MasterPass";
            $fromNum = "+983000505";
            $toNum = array($phone_number);
            $pattern_code = "ei7s585532";
            $input_data = array("code" => $vc);

            echo $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);

        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
