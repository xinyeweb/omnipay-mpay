<?php

namespace Omnipay\MPay;

class PcGateway extends BaseAbstractGateway {

    public function getName()
    {
        return 'WechatPay JS API/MP';
    }


    public function getTradeType()
    {
        return 'PC';
    }

}