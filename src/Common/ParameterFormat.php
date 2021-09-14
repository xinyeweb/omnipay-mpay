<?php

namespace Omnipay\MPay\Common;

/**
 * 
 * 參數格式化
 */
class ParameterFormat
{

    /**
     * 字母重新排序
     */
    public static function sort($obj, $deep)
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
                    $obj[$key] = self::sort($obj[$key], true);
                }
            }
        }
        return $obj;
    }


    /**
     * 數組轉化成URL參數【加簽時使用】
     * 
     */
    public static function link_string($data)
    {

        $returnvalue = "";

        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $val = $value;

            if (is_array($value)) {
                $val = json_encode($value, JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
            }
            $returnvalue .= "{$key}={$val}&";
        }
        $returnvalue = substr($returnvalue, 0, -1);
        return $returnvalue;
    }

    /**
     * 數組轉化成URL參數【驗簽時使用】
     * 
     */
    public static function link_string_check($data)
    {
        $returnvalue = "";

        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $val = $value;

            if (is_array($value)) {
                $val = json_encode($value, JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
            }
            $returnvalue .= "{$key}={$val}&";
        }
        $returnvalue = substr($returnvalue, 0, -1);
        return $returnvalue;
    }
}
