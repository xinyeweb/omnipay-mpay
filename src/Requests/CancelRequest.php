<?php

namespace Omnipay\MPay\Requests;

use Omnipay\MPay\Responses\PcResponse;

class CancelRequest extends AbstractBaseRequest
{
    public function sendData($data)
    {
        return $this->response = new PcResponse($this, $data);
    }
}
