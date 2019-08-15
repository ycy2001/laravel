<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    protected $config = [
        'alipay' => [
            'app_id' => '2016100100642215',
            'notify_url' => 'http://yt8tex.natappfree.cc/ci/blog/public/api/notify',
            'return_url' => 'http://localhost/ci/blog/public/api/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjuk/RFU1yrpWd+/W/EUGmrY8Z40Z4l5c4T/0Y/fsMa5cMRqPYvul1FaS5x2FQGQUkdntRBOlszioJx6NBRqkfC4xXqliYDLKEBFPWFXEf91USmShHyujbsEbh3CcQiYVHQBdGc8yvIMsP0ToSAmXiTpcrWsENhDyAyhv1PnQ1N0uA7MxRBl6yqVOwtwlG3lTIqpceUOkVlo3wZBQzVDoKmAm/sNVB7aEw4NOVkdBr4cCaIfsF3nzumeNNnfFyhMdpGHCDYZuBDSq+1+/zLMNi0NKoW9CUxREQp5MKkEMzYtviZVbpRTKmMUmw/4vfnoGjbk1L1y5N6MxXoMWpqUdVwIDAQAB',
            'private_key' => 'MIIEowIBAAKCAQEAqpB2/YKEfXCgbNTY8pjTr5c1jAaJaLWwB2PkoRIFMeUsk1/t7NlrXdzHI00VVlk/ujp0+Oomk2INB6CDYZsOoIf29WXxHbwHaSSK/2eHzuVHSer9eA3yOkhOoaZFf6afixdL1D3V/keii4w8USUUtJpY4FUz2+fQG2JxCwrfW2AmPH0ZzqIGgVIN7mkiCYKkJjszeNyzOm/okIaIvZp1FvgZQGb/8alX1CBLEmZvVpY62YI9d0bEQKOfhbysfRW5tgOWNd87/yLX9yZQ6yqxHLcWOQY50yPKjn8Hobf5XlUpX8PxYoFntUUW1ktAkkoICIXpl/gQYYsJoOyfal/QyQIDAQABAoIBAE6SSh4yN7JJZb18t4vZ1vo2X9ZnVHlF6Rcebz27vWTku4oQUNwgtBMDF0EtyzyB1JeHQkdAJhESxAnVaXBXK3/L4nndQht+eLN4wAczvB4VBKgKdkUNt54dnQteOvm42hoK20WkTqXafghmy4pd2JHx4CtHVKJiwT08NfLuSUIf4dJpybDZjTmpO2GaK9GvFhm3CsU4wwgCKSuCv5TTTpzq+lwCfcRw7cLV46rjCublAPjYMrZEFt4Tfa5tw4fdyKggWjNIMCzYodSHxqhL71SjtBp6FMwwKWAwlA4sBaQiDRx6rXOBjDOmYL8hkXYwibiZJfk0bTbg8r75Ii2DNQECgYEA3tEcaNHdvMY5j2HEV1gYSSe5Yxt4wsrpsB7msAbR19g7/OHSORZBElB/tp5HlDy2oFTOoMkYE5n/vwhBxfQhM/M0BgXFgEQrIkhBccdrZNFSw3N3/QqNcHDcQbWZ1ZHqCsidjmnzehz3SAVYxGn3G33QxAthvSDVeD3ylkKZf9ECgYEAw/c6IAf7tdGhcs53ZZDyn/pGSGZzWl+j7FEHhrPgRvRWh+8EFRC0UKzkYPVtyTn+ve46qZDEqwk4pUTkSSOleJFDpYaW5bIbqFfleNuUobaiKt1zG9isa3H1KLzRVTvCMdoFp+RL7Nas2B0xgCUeXjXJBKDVSpesyUSe4w80t3kCgYAhhqtUpkdL8TOV/GrzjYDR+RUu8WJBRRDWfD/Puqb2aEXWbhAYoN2XqN8elkBE8MG17CzPCpMB2AkgMFjdNTeNvolUYqft/dPTq7WVLiFdoRVn7UbfnyfbBFBP3shP102046y5Uf3doOAgSRWrMBqLW2n/JYtGTttv5TpMG6dHEQKBgBCqBFpW83OpqOX/Yq3TXp52BOYBOEv2GBVvaols4GSIQJd8nsc/zWWS3jTUigpzkRMLoBdtRRwaQ6PiMNt7WYXgLHV19X0A4VM2bkARxBjgU/f7Lt+uVDMq1KMrM03hMAlXNeXqBv7T3ozeJqhz/5oZTsfC+YBHV50h5bT/RQdZAoGBALypQXHp25DCFNQoF8KM3N7eFMws/o1PxtT33GFyaGGMiatC8xFqn8VYST2WTV3xcFnOGG9Xd/xPouglK+hSK4QcfsqacTNSmRsmhqAEZ6nxM2LL4+5M4/LT4rdF7EtrJhdeIrzFINO7mk4tZribr/yswQztlCaoM8Qa6/fI6yDD',
        ],
    ];

    public function index(Request $request)
    {
//        $config_biz = [
//            'out_trade_no' => time(),//订单号
//            'total_amount' => '1',//价格
//            'subject'      => 'test subject',
//        ];
        $order_id=$request->input('order_id');
        $price=$request->input('price');
        $config_biz = [
            'out_trade_no' => $order_id,//订单号
            'total_amount' => $price,//价格
            'subject'      => 'test subject',
        ];
        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->verify($request->all());
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            DB::update("update `order` set status=1");
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            DB::update("update `order` set status=2 ");
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}