<?php

namespace Omnipay\MPay\Responses;

use Omnipay\Common\Message\RedirectResponseInterface;

class PreResponse extends AbstractBaseResponse implements RedirectResponseInterface
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
