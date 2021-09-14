<?php

namespace Omnipay\MPay\Common;

/**
 * RSA 工具類
 */
class RsaEncrypt
{
    private $_privateKey;
    public $_publicKey;
    public function __construct($privatePemPath, $publicPemPath)
    {
        $this->_pemPath = $publicPemPath;
        $this->get_private_key($privatePemPath);
        $this->get_public_key($publicPemPath);
    }

    /**
     * 字母重新排序
     */
    public function sort($obj, $deep)
    {
        if (is_object($obj) && json_encode($obj) != "{}") {
            $arr = (array)$obj;
            ksort($arr);
            $obj = $arr;
        } elseif (is_array($obj)) {
            ksort($obj);
        }
        if ($deep) {
            foreach ($obj as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    $obj[$key] = $this->sort($obj[$key], true);
                }
            }
        }
        return $obj;
    }

    /**
     * 獲取私鑰證書
     */
    private function get_private_key($privatePemPath)
    {
        $this->_privateKey = openssl_get_privatekey(file_get_contents($privatePemPath));
        //print $this->_privateKey;
    }

    /**
     * 獲取公鑰證書
     */
    private function get_public_key($publicPemPath)
    {
        $this->_publicKey = openssl_pkey_get_public(file_get_contents($publicPemPath));
    }


    /**
     * RSA1簽名
     */
    public function sign($data)
    {
        $signature = '';
        openssl_sign($data, $signature, $this->_privateKey, OPENSSL_ALGO_SHA1);
        return base64_encode($signature);
    }

    /**
     * RSA2簽名
     */
    public function rsa_sign($data)
    {
        $signature = "";
        openssl_sign($data, $signature, $this->_privateKey, "sha256WithRSAEncryption");
        return base64_encode($signature);
    }


    /**
     * RSA驗簽
     */
    public function check_sign($data, $signature)
    {
        $signature = base64_decode($signature);
        return openssl_verify($data, $signature, $this->_publicKey);
    }

    /**
     * RSA2验签
     */
    public function check_rsa_sign($data, $signature)
    {
        $signature = base64_decode($signature);
        return openssl_verify($data, $signature, $this->_publicKey, "sha256WithRSAEncryption");
    }
}
