<?php

namespace Omnipay\MPay\Requests;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MPay\Common\MD5;
use Omnipay\MPay\Common\ParameterFormat;
use Omnipay\MPay\Common\RsaEncrypt;

abstract class AbstractBaseRequest extends AbstractRequest
{
    //POST請求URL【需要更新】
    protected $curlUrl = "https://uatopenapi.macaupay.com.mo/masl/umpg/gateway";
    protected $curlUrlProd = "https://openapi.macaupay.com.mo/masl/v2/umpg/gateway";
    //表單請求URL【需要更新】
    protected $formUrl = "https://uatopenapi.macaupay.com.mo/scanpay/";
    protected $formUrlProd = "https://openapi.macaupay.com.mo/scanpay/v2/";
    //MD5加密的key【需要更新】    
    protected $MD5Key;
    //私鑰證書地址【需要在構造函數更新】
    protected $privatePempath;
    //公鑰證書地址【需要在構造函數更新】
    protected $publicPempath;
    //機構編號
    protected $orgId;
    //版本號
    protected $version = '1.1.0';
    //簽名類型
    protected $signType;
    //請求方式，1=【默認】POST請求，2=表單提交
    protected $method;

    public function setCurlUrl()
    {
        return $this->setParameter("curl_url", YII_ENV_PROD ? $this->curlUrlProd : $this->curlUrl);
    }
    public function getCurlUrl()
    {
        return YII_ENV_PROD ? $this->curlUrlProd : $this->curlUrl;
    }

    public function setFormUrl()
    {
        return $this->setParameter("form_url", YII_ENV_PROD ? $this->formUrlProd :  $this->formUrl);
    }
    public function getFormUrl()
    {
        return YII_ENV_PROD ? $this->formUrlProd : $this->formUrl;
    }

    public function setOrgId($value)
    {
        return $this->setParameter("org_id", $value);
    }
    public function getOrgId()
    {
        return $this->getParameter("org_id");
    }

    public function setVersion($value)
    {
        return $this->setParameter("version", $value);
    }
    public function getVersion()
    {
        return $this->version;
    }

    public function setSignType($value)
    {
        return $this->setParameter("sign_type", $value);
    }
    public function getSignType()
    {
        return $this->getParameter("sign_type");
    }

    public function setMD5Key($value)
    {
        return $this->setParameter("md5_key", $value);
    }
    public function getMD5Key()
    {
        return $this->getParameter("md5_key");
    }

    public function setPublicPempath($value)
    {
        return $this->setParameter("public_pempath", $value);
    }
    public function getPublicPempath()
    {
        return $this->getParameter("public_pempath");
    }

    public function setPrivatePempath($value)
    {
        return $this->setParameter("private_pempath", $value);
    }
    public function getPrivatePempath()
    {
        return $this->getParameter("private_pempath");
    }

    //組裝頭部信息
    protected function get_head()
    {
        return [
            "service" => $this->service,
            "org_id" => $this->getOrgId(),
            "channel_type" => "1",
            //"sign_type" => $this->_sign_type,
            "version" => $this->getVersion(),
            "timestamp" => $this->get_microtime(),
            "nonce_str" => $this->get_nonceStr(),
            "format" => "JSON"
        ];
    }

    protected function sign($data)
    {
        //參數排序
        $array = ParameterFormat::sort($data, false);
        //獲取預簽名字符串
        $link_string = ParameterFormat::link_string($array);
        $sign = "";
        //MD5加密
        if (strcasecmp($this->getSignType(), "MD5") == 0) {
            $md5 = new MD5();
            $sign = $md5->sign($link_string, $this->getMD5Key());
        }
        //RSA加密
        else if (strcasecmp($this->getSignType(), "RSA") == 0) {
            $encrypt = new RsaEncrypt($this->getPrivatePempath(), $this->getPublicPempath());
            $sign = $encrypt->sign($link_string);
        }
        //RSA2加密
        else if (strcasecmp($this->getSignType(), "RSA2") == 0) {
            $encrypt = new RsaEncrypt($this->getPrivatePempath(), $this->getPublicPempath());
            $sign = $encrypt->rsa_sign($link_string);
        }
        $array["sign"] = $sign;
        $array["sign_type"] = $this->getSignType();
        return $array;
    }

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
            $returnvalue = $md5->verify($link_string, $this->getMD5Key(), $sign);
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

    public  function buildRequest($data)
    {
        $url = $data['curl_url'];
        unset($data['curl_url']);
        $postData = json_encode($data, JSON_UNESCAPED_UNICODE);
        if (!$this->check($postData)) {
            return "簽名驗證失敗";
        }
        //校驗數據
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

    public function getRedirectHtml($data)
    {
        //这里要加密数据
        $method = "get";
        $url = $data['form_url'];
        $html = '<div style="display:none"><form name="submitForm" action="' . $url . '" method="' . $method . '">';
        foreach ($data as $key => $value) {
            // 如果值为空 或者 为 url 自己加进去的 是非表单验证数据 需要过滤 否则会报错
            if (empty($value) || $key == "curl_url" || $key == "form_url") continue;
            $val = str_replace("\"", "&quot;", $value);
            $val = str_replace("\'", "&apos;", $val);
            $html .= '<input type="hidden" name="' . $key . '" value="' . $val . '"/>';
        }
        $html .= "</form></div>";
        $html .= '<label>系統正在跳轉中，請稍后...</label>';
        $html .= '<script>window.document.submitForm.submit();</script>';
        // echo $html;die;
        return $html;
    }
}
