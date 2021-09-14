<?php

namespace Omnipay\MPay;

use Omnipay\MPay\Common\MD5;
use Omnipay\MPay\Common\ParameterFormat;
use Omnipay\MPay\Common\RsaEncrypt;

class Helper
{
    /**
     * 獲取毫秒級的時間戳
     */
    private function get_microtime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

    /**
     * 獲取隨機字符串
     */
    private function get_nonceStr()
    {
        $str = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        $nonceStr = substr(str_shuffle($str), 26, 32);
        return $nonceStr;
    }

    /**
     * 組裝頭部信息
     */
    protected function get_head($service)
    {

        return [
            "service" => $service,
            "org_id" => $this->_ord_id,
            "channel_type" => "1",
            //"sign_type" => $this->_sign_type,
            "version" => $this->_version,
            "timestamp" => $this->get_microtime(),
            "nonce_str" => $this->get_nonceStr(),
            "format" => "JSON"
        ];
    }

    /**
     * 簽名
     */
    protected  function sign($data)
    {
        //參數排序
        $array = ParameterFormat::sort($data, false);
        //獲取預簽名字符串
        $link_string = ParameterFormat::link_string($array);

        $sign = "";
        //MD5加密
        if (strcasecmp($this->_sign_type, "MD5") == 0) {
            $md5 = new MD5();
            $sign = $md5->sign($link_string, $this->_md5_key);
        }
        //RSA加密
        else if (strcasecmp($this->_sign_type, "RSA") == 0) {
            $encrypt = new RsaEncrypt($this->_private_pempath, $this->_public_pempath);
            $sign = $encrypt->sign($link_string);
        }
        //RSA2加密
        else if (strcasecmp($this->_sign_type, "RSA2") == 0) {
            $encrypt = new RsaEncrypt($this->_private_pempath, $this->_public_pempath);
            $sign = $encrypt->rsa_sign($link_string);
        }
        $data["sign"] = $sign;
        $data["sign_type"] = $this->_sign_type;
        return $data;
    }

    /**
     * 驗簽
     */
    protected function check($content)
    {

        $returnvalue = false;

        $json_data = json_decode($content, true);
        $sign = $json_data["sign"];

        $sign_type = $json_data["sign_type"];
        unset($json_data["sign"]);
        unset($json_data["sign_type"]);
        //參數排序
        $array = ParameterFormat::sort($json_data, false);

        //獲取預簽名字符串
        $link_string = ParameterFormat::link_string_check($array);

        if (strcasecmp($sign_type, "MD5") == 0) {
            $md5 = new MD5();
            $returnvalue = $md5->verify($link_string, $this->_md5_key, $sign);
        }
        //RSA驗簽
        else if (strcasecmp($sign_type, "RSA") == 0) {
            $encrypt = new RsaEncrypt($this->_private_pempath, $this->_public_pempath);
            $returnvalue = $encrypt->check_sign($link_string, $sign);
        }
        //RSA2驗簽
        else if (strcasecmp($sign_type, "RSA2") == 0) {
            $encrypt = new RsaEncrypt($this->_private_pempath, $this->_public_pempath);
            $returnvalue = $encrypt->check_rsa_sign($link_string, $sign);
        }
        return $returnvalue;
    }

    /**
     * 請求接口方法
     * 
     * 
     */
    protected function buildRequest($data, $form_url = "", $method = "post")
    {
        $data = $this->sign($data);


        //判斷是post請求
        if ($this->_method == 1) {

            $response_text = $this->request_post($this->_url, json_encode($data, JSON_UNESCAPED_UNICODE));

            if ($this->check($response_text)) {
                return $response_text;
            } else {
                return "簽名驗證失敗";
            }
        }
        //表單請求
        else {

            $this->request_form($this->_form_url . $form_url, $data, $method);
            return "";
        }
    }


    /**
     * Post請求
     */
    protected  function request_post($url, $postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //設置超時時間
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($postData)
            )
        );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response) {
            curl_close($ch);
            return $response;
        } else {
            return curl_error($ch);
        }
    }

    /**
     * Get請求
     */
    protected function request_get($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);

        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); //設置超時時間
        $res = curl_exec($curl);
        if ($res) {
            curl_close($curl);
            return $res;
        } else {
            return curl_error($curl);
        }
    }

    /**
     * 表單請求
     */
    protected function request_form($url, $data, $method)
    {
        print '<div style="display:none"><form name="submitForm" action="' . $url . '" method="' . $method . '">';
        foreach ($data as $key => $value) {
            $val = str_replace("\"", "&quot;", $value);
            $val = str_replace("\'", "&apos;", $val);

            print '<input type="hidden" name="' . $key . '" value="' . $val . '"/>';
        }
        print '</form></div>';
        print '<label>系統正在跳轉中，請稍后...</label>';
        print '<script>window.document.submitForm.submit();</script>';
    }
}
