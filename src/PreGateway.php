<?php

namespace Omnipay\MPay;

use Omnipay\MPay\Requests\PreRequest;

class PreGateway extends BaseAbstractGateway
{

    public function getName()
    {
        return 'MPay Pre Gateway';
    }

    public function getTradeType()
    {
        return 'Pre';
    }


    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PreRequest::class, $parameters);
    }
}
