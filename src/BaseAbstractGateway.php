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

    public function setNotifyUrl($url)
    {
        $this->setParameter('notify_url', $url);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    /**
     * @return mixed
     */
    public function getCertPath()
    {
        return $this->getParameter('cert_path');
    }

    /**
     * @param mixed $certPath
     */
    public function setCertPath($certPath)
    {
        $this->setParameter('cert_path', $certPath);
    }

    /**
     * @return mixed
     */
    public function getKeyPath()
    {
        return $this->getParameter('key_path');
    }

    /**
     * @param mixed $keyPath
     */
    public function setKeyPath($keyPath)
    {
        $this->setParameter('key_path', $keyPath);
    }
}
