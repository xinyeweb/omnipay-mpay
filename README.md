
$orderParams 订单参数

PcGateway
$gateway = Omnipay::create($type);
//设置通用配置
$gateway->setParams()

PcGateway parameters 为请求参数
public function precreate_online(array $parameters = [])
{
    return $this->createRequest(PcRequest::class, $parameters);
}



