<?php

namespace Omnipay\MPay;

use Omnipay\MPay\Requests\RefundRequest;

class RefundGateway extends BaseAbstractGateway
{

    public function getName()
    {
        return 'MPay Refund Gateway';
    }

    public function getTradeType()
    {
        return 'Refund';
    }


    public function purchase(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }
}
