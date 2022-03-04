<?php

namespace Omnipay\MPay\Responses;

class RefundResponse extends AbstractBaseResponse
{
    public function isSuccessful()
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return false;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return false;
    }

    public function getMessage()
    {
        return $this->data;
    }
}
