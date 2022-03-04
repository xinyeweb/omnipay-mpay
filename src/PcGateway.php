<?php

namespace Omnipay\MPay;

use Omnipay\MPay\Requests\PcRequest;

class PcGateway extends BaseAbstractGateway
{

    public function getName()
    {
        return 'MPay Pc Gateway';
    }

    public function getTradeType()
    {
        return 'PC';
    }


    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PcRequest::class, $parameters);
    }

    // //創建訂單 mpay.trade.create
    // public function create(array $parameters = [])
    // {
    // }

    // //預創建訂單 mpay.trade.precreate
    // public function precreate(array $parameters = [])
    // {
    // }

    // /**
    //  * 統一下單(收銀台模式)【表單提交】
    //  * mpay.online.trade.precreate //若使用本地收銀台請置換接口為mpay.trade.precreate
    //  */
    // public function precreate_online(array $parameters = [])
    // {
    //     return $this->createRequest(PcRequest::class, $parameters);
    // }

    // /**
    //  * 統一下單(APP)
    //  * pay.trade.mobile.pay
    //  */
    // public function pay_mobile(array $parameters = [])
    // {
    // }

    // /**
    //  * 交易撤銷
    //  * mpay.trade.cancel
    //  */
    // public function cancel(array $parameters = [])
    // {
    // }

    // /**
    //  * 交易退款
    //  * mpay.trade.refund
    //  */
    // public function refund(array $parameters = [])
    // {
    // }

    // /**
    //  * 交易查詢
    //  * mpay.trade.query
    //  */
    // public function query(array $parameters = [])
    // {
    // }

    // /**
    //  * 匯率查詢
    //  * mpay.trade.queryRate
    //  */
    // public function query_rate(array $parameters = [])
    // {
    // }

    // /**
    //  * 掃碼支付
    //  * mpay.trade.spotpay
    //  */
    // public function spotpay(array $parameters = [])
    // {
    // }

    // /**
    //  * 統一下單(APP)
    //  * pay.trade.mobile.pay
    //  */
    // public function pay_mobile_testsign(array $parameters = [])
    // {
    // }
}
