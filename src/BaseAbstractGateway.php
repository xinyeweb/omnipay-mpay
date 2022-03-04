<?php

namespace Omnipay\MPay;

use Omnipay\Common\AbstractGateway;

abstract class BaseAbstractGateway extends AbstractGateway
{

    public function setOrgId($orgId)
    {
        $this->setParameter('org_id', $orgId);
    }
    public function getOrgId()
    {
        return $this->getParameter('org_id');
    }

    public function setExtendParams($json_params)
    {
        $this->setParameter('extend_params', $json_params);
    }
    public function getExtendParams()
    {
        return $this->getParameter('extend_params');
    }

    public function setItBPay($time_str)
    {
        $this->setParameter('it_b_pay', $time_str);
    }
    public function getItBPay()
    {
        return $this->getParameter('it_b_pay');
    }

    public function setSubMchName($mchName)
    {
        return $this->setParameter('sub_mch_name', $mchName);
    }
    public function getSubMchName()
    {
        return $this->getParameter('sub_mch_name');
    }

    public function getSubMchId()
    {
        return $this->getParameter('sub_mch_id');
    }
    public function setSubMchId($mchId)
    {
        $this->setParameter('sub_mch_id', $mchId);
    }

    public function setSubMchIndustry($mchIndustry)
    {
        return $this->setParameter('sub_mch_industry', $mchIndustry);
    }
    public function getSubMchIndustry()
    {
        return $this->getParameter('sub_mch_industry');
    }

    public function setMD5Key($key)
    {
        $this->setParameter('md5_key', $key);
    }
    public function getMD5Key()
    {
        return $this->getParameter('md5_key');
    }

    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }
    public function setSignType($type)
    {
        $this->setParameter('sign_type', $type);
    }

    public function setNotifyUrl($url)
    {
        $this->setParameter('notify_url', $url);
    }
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    public function getPrivatePempath()
    {
        return $this->getParameter('private_pempath');
    }
    public function setPrivatePempath($path)
    {
        $this->setParameter('private_pempath', $path);
    }

    public function getPublicPempath()
    {
        return $this->getParameter('public_pempath');
    }
    public function setPublicPempath($path)
    {
        $this->setParameter('public_pempath', $path);
    }

    public function completePurchase(array $parameters = [])
    {
        // 這裏還要去進行數據處理
        return $parameters;
    }
}
