<?php

namespace Omnipay\MPay\Requests;

use Omnipay\MPay\Responses\PreResponse;

/**
 * 交易查詢
 * 
 */
class RefundRequest extends AbstractBaseRequest
{
    protected $service = 'mpay.trade.refund';

    public function setOutTransId($value)
    {
        return $this->setParameter('out_trans_id', $value);
    }
    public function getOutTransId()
    {
        return $this->getParameter('out_trans_id');
    }

    public function setTransId($value)
    {
        return $this->setParameter('trans_id', $value);
    }
    public function getTransId()
    {
        return $this->getParameter('trans_id');
    }

    public function setOutRefundId($value)
    {
        return $this->setParameter('out_refund_id', $value);
    }
    public function getOutRefundId()
    {
        return $this->getParameter('out_refund_id');
    }

    public function setRefundAmount($value)
    {
        return $this->setParameter('refund_amount', $value);
    }
    public function getRefundAmount()
    {
        return $this->getParameter('refund_amount');
    }

    public function setRefundReason($value)
    {
        return $this->setParameter('refund_reason', $value);
    }
    public function getRefundReason()
    {
        return $this->getParameter('refund_reason');
    }

    public function getData()
    {
        $this->validateData();
        $data = $this->get_head();
        $data = array_merge($data, [
            'out_trans_id' => $this->getOutTransId(),
            'trans_id' => $this->getTransId(),
            'out_refund_id' => $this->getOutRefundId(),
            'refund_amount' => $this->getRefundAmount(),
            'refund_reason' => $this->getRefundReason(),
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
            // 'trans_id',
            'out_refund_id',
            'refund_amount',
            'refund_reason'
        );
    }
}
