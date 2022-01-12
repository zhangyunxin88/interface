<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;

class Admin extends BaseController
{
    public function index()
    {
        $data = Db::table('user')->field('background','avartar','name','content')
            ->where('id',1)->select();
        return json($data[0]);
    }

    public function login()
    {
        $jwt = new \Jwt();
        $token = $jwt->getToken(1);
        if(!$_POST || !($_POST['user'] == 'admin') || !($_POST['password'] == '123456')){
            return json(['res' => 0, 'data' => '用户名或密码错误']);
        }else{
            return json(['res' => 1, 'token' => $token]);
        }
    }

    public function modifyComment(){
        if($_POST && $_POST['id'] && $_POST['message']){
            $data = Db::table('friend')->where('id',$_POST['id'])
                ->data(['message'=>$_POST['message']])->save();
            return json(['res' => $data]);
        }else{
            return json(['res' => 0, 'data' => '评论修改出错，请重新提交']);
        }
    }

    public function deleteComment(){
        if($_POST && $_POST['id']){
            $data = Db::table('friend')->where('id',$_POST['id'])
                ->delete();
            return json(['res' => $data]);
        }else{
            return json(['res' => 0, 'data' => '评论删除出错，请重新提交']);
        }
    }

    public function uploadFile(){
        $string = '';
        for ($i=1;$i<15;$i++) {
            $randstr = chr(rand(65,90));    //指定为字母
            $string .= $randstr;
        }
        $name = $_FILES['file']['name'];
        $type = '';
        if($name){
            $arr = explode('.', $name);
            $type = '.'.array_pop($arr);
        }
        $new_name = $string.$type;
        move_uploaded_file($_FILES['file']['tmp_name'], '../../images/'.$new_name);
        /*\think\facade\Filesystem::disk('public')->putFileAs( '', request()->file('file'), $new_name);*/
        return json(['res'=>1,'file_name'=>$new_name]);
    }

    public function modifyCartoon(){
        if($_POST && $_POST['id'] && $_POST['title'] && $_POST['pic'] && $_POST['url']){
            $data = Db::table('cartoon')->where('id',$_POST['id'])
                ->data(['title'=>$_POST['title'],'pic'=>$_POST['pic'],'url'=>$_POST['url']])->save();
            return json(['res' => $data]);
        }else{
            return json(['res' => 0, 'data' => '评论修改出错，请重新提交']);
        }
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
