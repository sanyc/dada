<?php

namespace Sanyc\Dada;

use Sanyc\Dada\Http;

class Dada
{
    protected $dd_config = [];

    protected $apis = [
        'cityCodeList'         => '/api/cityCode/list',
        'addOrder'             => '/api/order/addOrder',
        'orderQuery'           => '/api/order/status/query',
        'orderQueryDeliverFee' => '/api/order/queryDeliverFee',
        'orderAddAfterQuery'   => '/api/order/addAfterQuery'
    ];

    public function __construct($config = [])
    {
        $this->dd_config = array_merge(config('dada'), $config);
    }

    public function getConfig()
    {
        return $this->dd_config;
    }

    public function setConfig($config = [])
    {
        $this->dd_config = array_merge($this->dd_config, $config);
        return $this;
    }

    protected function dDGet($method, $my_params = [])
    {
        try {
            $requestParams['app_key']   = $this->dd_config['app_key'];
            $requestParams['body']      = json_encode($my_params);
            $requestParams['format']    = $this->dd_config['format'];
            $requestParams['v']         = $this->dd_config['v'];
            $requestParams['source_id'] = $this->dd_config['source_id'];
            $requestParams['timestamp'] = time();
            $requestParams['signature'] = $this->_sign($requestParams);

            return $this->getHttpRequestWithPost($this->apis[$method], json_encode($requestParams));
        } catch (\Exception $e) {
            //throw $e;                           
        }
    }

    public function getCityCodes()
    {
        return $this->dDGet('cityCodeList');
    }

    public function addOrder($my_params)
    {
        return $this->dDGet('addOrder', $my_params);
    }

    public function orderQuery($order_id)
    {
        return $this->dDGet('orderQuery', ['order_id' => $order_id]);
    }

    public function orderQueryDeliverFee($my_params)
    {
        return $this->dDGet('orderQueryDeliverFee', $my_params);
    }

    public function orderAddAfterQuery($delivery_no)
    {
        return $this->dDGet('orderAddAfterQuery', ['deliveryNo' => $delivery_no]);
    }

    /**
     * 发送请求,POST
     * @param $url 指定URL完整路径地址
     * @param $data 请求的数据
     */
    protected function getHttpRequestWithPost($api_url, $data)
    {
        $url     = $this->dd_config['api_host'] . $api_url;
        $headers = ['Content-Type: application/json'];
        return Http::postRequest($url, $data, $headers);
    }

    /**
     * 签名生成signature
     */
    protected function _sign($data)
    {
        //1.升序排序
        ksort($data);

        //2.字符串拼接
        $args = "";
        foreach ($data as $key => $value) {
            $args.=$key.$value;
        }
        $args = $this->dd_config['app_secret'] . $args . $this->dd_config['app_secret'];
        //3.MD5签名,转为大写
        $sign = strtoupper(md5($args));

        return $sign;
    }

}
