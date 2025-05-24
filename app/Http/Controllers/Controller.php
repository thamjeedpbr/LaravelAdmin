<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadFile($request, $file)
    {
        if ($request->has($file)) {
            $file_ = $request->file($file);
            $avatarName = time() . '.' . $file_->getClientOriginalExtension();
            $avatarPath = public_path('/uploads/' . $file . '/');
            $file_->move($avatarPath, $avatarName);
            return 'uploads/' . $file . '/' . $avatarName;
        }
    }
    public function sendWhatsappMessage($mobile, $otp, $user)
    {
        $curl = curl_init();
        if (!$curl) {
            die("Couldn't initialize a cURL handle");
        }

        $msgArray = array(
            'from_phone_number_id' => '379394621917932',
            'phone_number' => $mobile,
            'template_name' => 'wisdom_guide_otp',
            'template_language' => 'en',
            'field_1' => $otp,
            'button_0' => $otp,
            'copy_code' => '',
            'contact' => array('first_name' => $user->name,
                'last_name' => 'WG_OTP',
                'email' => $user->email,
                'country' => 'India',
                'language_code' => 'en'),
        );

        $headers = [
            'Authorization: Bearer J42W6WCb5W4CN8wxtQcVaUlfNbHoc7EjFe5g5rVDFJxfHAoavqtMiWhTpqZcm4Lo',
            'Content-Type: application/json',
        ];

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://synkchat.com/api/fe1808a7-6b00-4ced-bafb-464b9a5277e2/contact/send-template-message",
            CURLOPT_POST => 1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($msgArray),
        ));

        $error = "";
        $smsSentFlg = "N";
        $errorMessage = "";
        $response = curl_exec($curl); // execute

        $res = json_decode($response);

        if (isset($res->error)) {
            $smsSentFlg = "N";
        } else {
            $smsSentFlg = "Y"; //echo "Message Sent Succesfully" ;
            $info = curl_getinfo($curl);
            curl_close($curl); // close cURL handler
        }

        return $smsSentFlg;
    }
}
