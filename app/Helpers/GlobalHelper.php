<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

function sendWhatsApp($number, $otp,$user) {
    $message = "Dear member,
    Your Peace Radio Course OTP is : $otp
    IT Wing,
    Wisdom Islamic Organization";
    $client = new Client();
    $headers = [
        'Content-Type' => 'application/json',
    ];
    $body = json_encode([
        'clientId' => 1,
        'number' => $number,
        'message' => $message,
    ]);

    $request = new Request('POST', 'http://192.3.12.134:3011/send-message', $headers, $body);

    try {
        $response = $client->sendAsync($request)->wait();

        if ($response->getStatusCode() == 200) {
            $smsSentFlg = "Y";
        } else {
            $smsSentFlg = "N"; //echo "Message Sent Succesfully" ;
            $info = curl_getinfo($curl);
            curl_close($curl); // close cURL handler
        }
    
        return $smsSentFlg;
        
    } catch (RequestException $e) {
        return "N";
    }
}
function sendWhatsappMessage($mobile, $otp, $user)
{

}
function sendOtpSms($mobile_no, $otp)
{


}
function sendSms($mobile_no, $text)
{


}
