<?php

namespace Omnipay\MPay;

use Omnipay\MPay\Requests\QueryRequest;

class QueryGateway extends BaseAbstractGateway
{

    public function getName()
    {
        return 'MPay Query Gateway';
    }

    public function getTradeType()
    {
        return 'Query';
    }


    public function purchase(array $parameters = [])
    {
        return $this->createRequest(QueryRequest::class, $parameters);
    }
}
