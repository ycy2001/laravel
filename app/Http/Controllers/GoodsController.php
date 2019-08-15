<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
class GoodsController extends Controller{
    public function shop(){
        $user=DB::select("select goods.id as gid,goods_name,category.name as cname,brand.name as bname,attr_category_id FROM `goods` inner join brand on goods.brand_id=brand.id inner join category on goods.category_id=category.id where goods.online_status=1 order by goods.id asc limit 0,30");
        return response()->json($user);
    }
    public function goodscate(){
        $arr=Db::select("select * from category");
        $ar=$this->gettree($arr,0,0);
        $arr=['code'=>'0','status'=>'ok','data'=>$ar];
        echo json_encode($arr);
    }

    public function gettree($arr,$id,$level)
    {
        $list =array();
        foreach ($arr as $k=>$v){
            if ($v->pid == $id){
                $v->level=$level;
                $v->son =$this-> gettree($arr,$v->id,$level+1);
                $list[] = $v;
            }
        }
        return $list;
    }
    public function floor(){
        $a=DB::select("select goods.id as gid,goods.goods_name,floor.name as f_name from goods inner join floor on goods.f_id=floor.id order by gid asc");
        $floor=[];
        foreach ($a as $key =>$val){
            $floor[$val->f_name][$val->gid][]=$val->goods_name;
        }
        $arr=['code'=>'0','status'=>'ok','data'=>$floor];
        echo json_encode($arr);
    }
    public function product()
    {
        $id = Input::post('id');
        $a=DB::select("select goods.id as gid,goods_name,category.name as cname,brand.name as bname,attr_category_id FROM `goods` inner join brand on goods.brand_id=brand.id inner join category on goods.category_id=category.id where goods.id='$id'");
        $show=DB::select("select * from shop_goods where goods_id='$id'");
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
        $res=['code'=>'0','status'=>'ok','data'=>$show,'goods'=>$a];
        echo json_encode($res);
    }
    function area(Request $request){
        $pid=$request->input('pid');
        $area=DB::select("select * from `area` where parent_id=$pid");
        echo json_encode($area);
    }
}
?>