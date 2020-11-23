<?php
declare(strict_types=1);

namespace App\Application\Actions\Order;

use Psr\Http\Message\ResponseInterface as Response;


class SubmitOrderAction extends OrderAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $appid = $this->request->getAttribute('appid');
        $mch_id = $this->request->getAttribute('mch_id');
        $body = 'SelfOrder-Dish';
        $nonce_str = md5(strval(rand()));
        $sign_params = [
            'appid' => $appid,
            'body' => $body,
            'mch_id' => $mch_id,
            'nonce_str' => $nonce_str
        ];
        $sign = $this->sign($sign_params);

        $form = $this->getFormData();
        $user_id = $form->user_id;
        $amount = $form->total;
        $credit = $form->credit;
        $remark = $form->remark;
        $datetime = date('Y-m-d H:i:s');
        $dine_way = $form->dine_way;
        $dishes = $form->dishes;
        $order_id = $this->create_order($user_id, $amount, $credit, $remark, $datetime, (int) $dine_way, $dishes);

        $out_trade_no = $order_id;
        $open_id = $this->orderRepository->getOpenId($user_id);
        $ip = $this->request->getAttribute('ip_addr');
        $total_cent = $amount * 100;
        $notify_url = '';
        $trade_type = 'JSAPI';
        $prepay_id = md5($sign.strval($total_cent).$open_id.$datetime.$out_trade_no.$ip.$notify_url.$trade_type);

        $nonce_str = md5(strval(rand()));
        $timestamp = time();
        $sign_params = [
            'appId' => $appid,
            'nonceStr' => $nonce_str,
            'package' => 'prepay_id='.$prepay_id,
            'signType' => 'MD5',
            'timeStamp' => $timestamp
        ];
        $sign = $this->sign($sign_params);

        $result = [
            'appId' => $appid,
            'nonceStr' => $nonce_str,
            'package' => 'prepay_id='.$prepay_id,
            'signType' => 'MD5',
            'timeStamp' => $timestamp,
            'paySign' => $sign,
            'order_id' => $order_id
        ];
        return $this->respondWithData($result);
    }

    /**
     * @param string $user_id
     * @param float $amount
     * @param int $credit
     * @param string $remark
     * @param string $datetime
     * @param int $dine_way
     * @param array $dishes
     * @return string
     */
    private function create_order(string $user_id, float $amount, int $credit, string $remark, string $datetime, int $dine_way, array $dishes): string
    {
        $order_id = md5($user_id.$datetime.strval(rand()));
        $status = 0;
        $this->orderRepository->add($order_id, $user_id, $amount, $credit, $remark, $datetime, $status, $dine_way, $dishes);
        return $order_id;
    }

    /**
     * @param array $kvs
     * @return string
     */
    private function sign(array $kvs): string
    {
        $key = md5('qawsedrf');
        $s1 = [];
        foreach ($kvs as $key=>$value)
            array_push($s1, "$key=$value");

        $s1 = implode('&', $s1);
        $sign_temp = $s1 . "&key=$key";
        $sign = strtoupper(md5($sign_temp));
        return $sign;
    }
}