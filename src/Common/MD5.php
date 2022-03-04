<?php

namespace Omnipay\MPay\Common;

/**
 * MD5工具類
 */
class MD5
{


    /**
     * MD5簽名
     */
    public function sign($text, $key)
    {
        $content = $text . $key;
        return md5($content);
    }

    /**
     * MD5驗簽
     */
    public function verify($text, $key, $sign)
    {
        $content = $text . $key;
        $mySign = md5($content);
        if (strcasecmp($mySign, $sign) == 0) {
            return true;
        } else {
            return false;
        }
    }
}
