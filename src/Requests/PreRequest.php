<?php

namespace Omnipay\MPay\Requests;

use Omnipay\MPay\Responses\PreResponse;

/**
 * 預創建訂單
 * 
 */
class PreRequest extends AbstractBaseRequest
{
    protected $service = 'mpay.trade.precreate';

    public function setOutTransId($value)
    {
        return $this->setParameter('out_trans_id', $value);
    }
    public function getOutTransId()
    {
        return $this->getParameter('out_trans_id');
    }

    public function setPrice($value)
    {
        return $this->setParameter('price', $value);
    }
    public function getPrice()
    {
        return $this->getParameter("price");
    }

    public function setShowUrl($value)
    {
        return $this->setParameter('show_url', $value);
    }
    public function getShowUrl()
    {
        return $this->getParameter("show_url");
    }

    public function setQuantity($value)
    {
        return $this->setParameter('quantity', $value);
    }
    public function getQuantity()
    {
        return $this->getParameter("quantity");
    }

    public function setBody($value)
    {
        return $this->setParameter('body', $value);
    }
    public function getBody()
    {
        return $this->getParameter("body");
    }

    public function setSubject($value)
    {
        return $this->setParameter('subject', $value);
    }
    public function getSubject()
    {
        return $this->getParameter("subject");
    }

    public function setTotalFee($value)
    {
        return $this->setParameter('total_fee', $value);
    }
    public function getTotalFee()
    {
        return $this->getParameter("total_fee");
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }
    public function getCurrency()
    {
        return $this->getParameter("currency");
    }

    public function setExtendParams($value)
    {
        return $this->setParameter('extend_params', $value);
    }
    public function getExtendParams()
    {
        return $this->getParameter("extend_params");
    }

    public function setGoodsDetail($value)
    {
        return $this->setParameter('goods_detail', $value);
    }
    public function getGoodsDetail()
    {
        return $this->getParameter("goods_detail");
    }

    public function setRiskInfo($value)
    {
        return $this->setParameter('risk_info', $value);
    }
    public function getRiskInfo()
    {
        return $this->getParameter("risk_info");
    }

    public function setItBPay($value)
    {
        return $this->setParameter('it_b_pay', $value);
    }
    public function getItBPay()
    {
        return $this->getParameter("it_b_pay");
    }

    public function setPassbackParameters($value)
    {
        return $this->setParameter('passback_parameters', $value);
    }
    public function getPassbackParameters()
    {
        return $this->getParameter("passback_parameters");
    }

    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }
    public function getNotifyUrl()
    {
        return $this->getParameter("notify_url");
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }
    public function getReturnUrl()
    {
        return $this->getParameter("return_url");
    }

    public function getData()
    {
        $this->validateData();
        $data = $this->get_head();
        $data = array_merge($data, [
            'out_trans_id' => $this->getOutTransId(),
            'total_fee' => $this->getTotalFee(),
            'body' => $this->getBody(),
            'subject' => $this->getSubject(),
            'currency' => $this->getCurrency(),
            'price' => $this->getPrice(),
            'show_url' => $this->getShowUrl(),
            'quantity' => $this->getQuantity(),
            'extend_params' => $this->getExtendParams(),
            'goods_detail' => $this->getGoodsDetail(),
            'it_b_pay' => $this->getItBPay(),
            'passback_parameters' => $this->getPassbackParameters(),
            'notify_url' => $this->getNotifyUrl(),
            'return_url' => $this->getReturnUrl(),
        ]);
        //先获取sign sign 不要加url 和 formUrl
        $data = $this->sign($data);
        $data['curl_url'] = $this->getCurlUrl();
        return $data;
    }

    /**
     外部調用基類的send() -> 實際上是 getData()->sendData()
     */
    public function sendData($data)
    {
        $res = $this->buildRequest($data);
        return $this->response = new PreResponse($this, $res);
    }

    //注销的为非必填
    private function validateData()
    {
        $this->validate(
            'out_trans_id',
            'subject',
            'total_fee',
            'body',
            'currency',
            'price',
            'show_url',
            'quantity',
            'extend_params',
            // 'goods_detail',
            // 'it_b_pay',
            // 'passback_parameters',
            'notify_url',
            'return_url'
        );
    }

}
