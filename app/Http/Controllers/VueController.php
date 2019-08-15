<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
//header('Access-Control-Allow-Origin:*');
class VueController extends Controller{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
    public function goodscart(){
        $a=auth()->user();
        $user_id = $a->id;
        $goods_id = Input::post('goods_id');
        $goods_num = Input::post('goods_num');
        DB::insert("insert into shopping_cart(`user_id`,`goods_id`,`goods_num`)value('$user_id','$goods_id','$goods_num')");
        $res=['code'=>'0','status'=>'ok','data'=>'添加成功'];
        echo json_encode($res);
    }
    public function goodscartshow()
    {
        $a=auth()->user();
      $user_id = $a->id;
        $show=DB::select("SELECT shopping_cart.id as sid,shopping_cart.goods_id as gid,goods_name,goods_num,price,goods_attr_id FROM `shop_goods` inner join `goods` on shop_goods.goods_id=goods.id inner join `shopping_cart` on shop_goods.id=shopping_cart.goods_id where user_id='$user_id'");
        for ($i=0;$i<count($show);$i++){
            $abb='';
            $arr=$show[$i]->goods_attr_id;
            $new_attr=explode(',',$arr);
            for ($j=0; $j <count($new_attr); $j++){

                $new_de=DB::select("select * from attr_detaile where id='$new_attr[$j]'");
                $abb=$abb.' '.$new_de[0]->name;
            }
            $show[$i]->key=$abb;

        }
//        var_dump($show);
        $res=['code'=>'0','status'=>'ok','data'=>$show,'goods'=>$a];
        echo json_encode($res);
    }
    public function addUpdate()
    {
        $a=auth()->user();
        $user_id = $a->id;
        $goods_id = Input::post('id');
        $num = Input::post('num')+1;
        DB::update("update shopping_cart set goods_num='$num' where user_id='$user_id'and goods_id='$goods_id'");
        $res=['code'=>'0','status'=>'ok','data'=>'添加成功'];
        echo json_encode($res);
    }
    public function jianUpdate()
    {
        $a=auth()->user();
        $user_id = $a->id;
        $goods_id = Input::post('id');
        $num = Input::post('num')-1;
        DB::update("update shopping_cart set goods_num='$num' where user_id='$user_id'and goods_id='$goods_id'");
        $res=['code'=>'0','status'=>'ok','data'=>'添加成功'];
        echo json_encode($res);
    }
    public function addressadd(){
        $a=auth()->user();
        $user_id = $a->id;
        var_dump($user_id);die;
        $address = Input::post('address');
        DB::insert("insert into address(`u_id`,`address`)value('$user_id','$address')");
        $res=['code'=>'0','status'=>'ok','data'=>'添加成功'];
        echo json_encode($res);
    }
    public function order(){
        $a=auth()->user();
        $user_id = $a->id;
        $bycar = Input::post('bycar');
        $a=explode(',',$bycar);
        array_shift($a);
        $b=implode($a,"'or shopping_cart.goods_id='");
        $show=DB::select("SELECT shopping_cart.id as sid,shopping_cart.goods_id as gid,goods_name,goods_num,price,goods_attr_id FROM `shop_goods` inner join `goods` on shop_goods.goods_id=goods.id inner join `shopping_cart` on shop_goods.id=shopping_cart.goods_id where user_id='$user_id' and shopping_cart.goods_id='$b'");
        for ($i=0;$i<count($show);$i++){
            $abb='';
            $zonjia=$show[$i]->goods_num*$show[$i]->price;
            $arr=$show[$i]->goods_attr_id;
            $new_attr=explode(',',$arr);
            for ($j=0; $j <count($new_attr); $j++){

                $new_de=DB::select("select * from attr_detaile where id='$new_attr[$j]'");
                $abb=$abb.' '.$new_de[0]->name;
            }
            $show[$i]->key=$abb;
            $show[$i]->zonjia=$zonjia;
        }
        $res=['code'=>'0','status'=>'ok','data'=>$show];
        echo json_encode($res);
    }
    public function getaddress(){
        $a=auth()->user();
        $user_id = $a->id;
        $show=DB::select("SELECT * FROM `address` where u_id='$user_id'");
        $res=['code'=>'0','status'=>'ok','data'=>$show];
        echo json_encode($res);
    }
    public function confirm(){
        $a=auth()->user();
        $user_id = $a->id;
        $order_number = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $address=DB::select("SELECT * FROM `address` where u_id='$user_id'");
        $bycar = Input::post('bycar');
        $a=explode(',',$bycar);
        array_shift($a);
        $time=date('Y-m-d H:i:s',time());
        DB::insert("insert into `order`(`time`,`u_id`,`order_id`)value('$time','$user_id','$order_number')");
        for ($j=0;$j<count($a);$j++){
            $show=DB::select("SELECT shopping_cart.id as sid,shopping_cart.goods_id as gid,goods_name,goods_num,price,goods_attr_id FROM `shop_goods` inner join `goods` on shop_goods.goods_id=goods.id inner join `shopping_cart` on shop_goods.id=shopping_cart.goods_id where user_id='$user_id' and shopping_cart.goods_id='$a[$j]'");
                $abb='';
                $arr=$show[0]->goods_attr_id;
                $new_attr=explode(',',$arr);
                for ($i=0; $i <count($new_attr); $i++){
                    $new_de=DB::select("select * from attr_detaile where id='$new_attr[$i]'");
                    $abb=$abb.' '.$new_de[0]->name;
                }
                $show[0]->key=$abb;
                $gid=$show[0]->gid;
                $goods_name=$show[0]->goods_name;
                $type=$show[0]->key;
                $addressadd=$address[0]->address;
                $num=$show[0]->goods_num;
                $price=$show[0]->price;
            DB::insert("insert into `order_details`(`g_id`,`g_name`,`g_type`,`address`,`price`,`num`,`order_id`)value('$gid','$goods_name','$type','$addressadd','$price','$num','$order_number')");
            DB::delete("delete from `shopping_cart` where goods_id='$a[$j]' and user_id='$user_id'");
        }
        $res=['code'=>'0','status'=>'ok','order_id'=>$order_number,'price'=>1000];
        echo json_encode($res);
    }
}