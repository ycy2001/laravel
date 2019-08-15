<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 为指定用户显示详情
     *
     * @param int $id
     * @return Response
     * @author LaravelAcademy.org
     */
    public function show()
    {
        return view('user.login');
    }
    public function login(Request $request)
    {
        $name = Input::get('name');
        $pwd = Input::get('pwd');
        if (empty($name)||empty($pwd)){
            $arr=['code'=>'1','status'=>'error','data'=>'账号密码不能为空'];
            return json_encode($arr);
        }else{
            $res=DB::select("select * from users where name='$name'and password='$pwd'");
            if ($res){
                $request->session()->put('user', $name);
                $arr=['code'=>'0','status'=>'ok','data'=>'登陆成功'];
                return json_encode($arr);
            }else{
                $arr=['code'=>'1','status'=>'error','data'=>'登陆失败'];
                return json_encode($arr);
            }
        }

    }
    public function loginout(Request $request){
        $request->session()->forget('user');
        return redirect()->action('UserController@show');
    }
}