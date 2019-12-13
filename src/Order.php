<?php
declare (strict_types = 1);

namespace sanyc\Dada;

/**
 * 达达开放平台订单
 */
class Order extends Dada
{
    protected $apis = [
        'addOrder'             => '/api/order/addOrder',
        'orderQuery'           => '/api/order/status/query',//订单详情
        'orderQueryDeliverFee' => '/api/order/queryDeliverFee',//查询订单运费
        'orderAddAfterQuery'   => '/api/order/addAfterQuery',//查询运费后发单接口
        'reAddOrder'           => '/api/order/reAddOrder',//订单重发
        'orderFormalCancel'    => '/api/order/formalCancel',//订单取消
        'orderCancelReasons'   => '/api/order/cancel/reasons',//订单取消原因
        'orderConfirmGoods'    => '/api/order/confirm/goods'//妥投异常之物品返回完成
    ];

    /**
     * 通过接口，获取城市信息列表。
     * @return json
     */
    public function getCityCodes()
    {
        return $this->dDGet('cityCodeList');
    }

    /**
     * 增加订单
     * @param array
     * @return [type] [<description>]
     */
    public function addOrder($order_params)
    {
        return $this->dDGet('addOrder', $order_params);
    }

    /**
     * 订单详情查询  
     * @param  String  订单id
     * @return [type]
     */
    public function orderQuery($order_id)
    {
        return $this->dDGet('orderQuery', ['order_id' => $order_id]);
    }

    /**
     * 查询订单运费接口
     * @param  [type]
     * @return [type]
     */
    public function orderQueryDeliverFee($order_params)
    {
        return $this->dDGet('orderQueryDeliverFee', $order_params);
    }

    /**
     * 查询运费后发单接口
     * @param  String  平台订单id
     * @return json
     */
    public function orderAddAfterQuery($delivery_no)
    {
        return $this->dDGet('orderAddAfterQuery', ['deliveryNo' => $delivery_no]);
    }

    /**
     * 订单重发
     * @param  [type]
     * @return [type]
     */
    public function reAddOrder($order_params)
    {
        return $this->dDGet('reAddOrder', $order_params);
    }

    public function orderFormalCancel($order_params)
    {
        return $this->dDGet('orderFormalCancel', $order_params);
    }

    public function orderCancelReasons()
    {
        return $this->dDGet('orderCancelReasons');
    }

    public function orderConfirmGoods($order_id)
    {
        return $this->dDGet('orderConfirmGoods', ['order_id' => $order_id]);
    }

}
