<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
        $data = Db::table('user')->field('background','avartar','name','content')
            ->where('id',1)->select();
        return json($data[0]);
    }

    public function getUser(){
        $data = Db::table('user')->field(['background','avartar','name','content'])
            ->where('id',1)->select();
        if($data[0]){
            return json(['res'=> 1,'data'=>$data[0]]);
        } else{
            return json(['res'=>0,'data'=>[]]);
        }
    }

    public function getUserFile(){
        //return json(['data' => $_FILES]);
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
        return json(['res'=>1,'file_name'=>$new_name]);
    }

    public function changeUserInfo(){
        $data = Db::table('user')->where('id',1)
        ->update(['background'=>$_POST['background'],'avartar'=>$_POST['avartar'],
            'name'=>$_POST['name'],'content'=>$_POST['content']]);
        return json(['res'=> 1]);
    }

    public function getArticles(){
        $page = (integer) $_GET['page'];
        if(!$page){
            $page = 1;
        }
        $line = ($page-1)*5;
        if(!$_GET['cat']){
            $cat = 0;
        }else{
            $cat = (integer) $_GET['cat'];
        }
        $data = array();
        switch ($cat){
            case 1:{
                $data = Db::table('article')->where('cat',1)->limit($line,6)->select();
                break;
            }
            case 2:{
                $data = Db::table('article')->where('cat',2)->limit($line,6)->select();
                break;
            }
            case 3:{
                $data = Db::table('article')->where('cat',3)->limit($line,6)->select();
                break;
            }
            default: {
                $data = Db::table('article')->limit($line,6)->select();
                break;
            }
        }
        return json(['data' => $data]);
    }

    public function getCartoon(){
        $data = Db::table('cartoon')->select();
        return json(['data'=>$data]);
    }

    public function getBlibliInfo(){
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.bilibili.com/x/web-interface/ranking/v2?rid=0&type=all');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        //return $output;

        return json(['info'=> $output]);
    }

    public function getMessage(){
        $data = Db::table('friend')
            ->save(['avartar'=>$_POST['avartar'], 'name'=>$_POST['name'],
                'description'=>$_POST['description'],'message'=>$_POST['message'],
                'createtime'=>date('Y-m-d H:m:s')]);
        return json(['data'=>$data]);
    }

    public function getFriend(){
        if(!$_GET || !$_GET['name']){
            return json(['res'=>0,'data'=>[]]);
        }
        $data = Db::table('friend')->where('name',$_GET['name'])->select();
        if(count($data)){
            return json(['res'=> 1,'data'=>$data[0]]);
        } else{
            return json(['res'=>0,'data'=>[]]);
        }
    }

    public function getFriendsList(){
        $data = Db::table('friend')->select();
        $array = array();
        $keys = array();
        foreach ($data as $key=>$value){
            if((String) array_search($value['name'], $keys) == null){
                array_push($keys, $value['name']);
                array_push($array, $value);
            }
            /*if(count($array) == 4){
                break;
            }*/
        }
        return json(['data' => $array, 'info'=>$data]);
    }

    public function getCommentList(){
        $data = Db::table('friend')->select();
        return json(['data' => $data]);
    }

    public function getArticleDetail(){
        if($_GET && $_GET['id']){
            $data = Db::table('article')->where('id',$_GET['id'])->select();
            return json(['data'=>$data]);
        }else{
            return json(['data'=>[]]);
        }
    }

    public function getPoem(){
        $id = rand(1,10);
        $data = Db::table('poem')->where('id',$id)->select();
        return json(['data'=>$data[0]]);
    }

    public function getMusic(){
        $data = file_get_contents('https://api.uomg.com/api/rand.music?format=json');
        return $data;
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
