<?php

namespace Omnipay\MPay\Requests;

use Omnipay\MPay\Responses\PreResponse;

/**
 * 交易查詢
 * 
 */
class QueryRequest extends AbstractBaseRequest
{
    protected $service = 'mpay.trade.query';

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


    public function getData()
    {
        $this->validateData();
        $data = $this->get_head();
        $data = array_merge($data, [
            'out_trans_id' => $this->getOutTransId(),
            'trans_id' => $this->getTransId(),
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
        );
    }
}
