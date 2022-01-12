<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('user', 'index/getUser');

Route::post('userFile', 'index/getUserFile');

Route::post('userInfo', 'index/changeUserInfo');

Route::get('articles', 'index/getArticles');

Route::get('cartoon', 'index/getCartoon');

Route::get('blibli', 'index/getBlibliInfo');

Route::post('message', 'index/getMessage');

Route::get('friend', 'index/getFriend');

Route::get('friendsList', 'index/getFriendsList');

Route::get('commentList', 'index/getCommentList');

Route::get('articleDetail', 'index/getArticleDetail');

Route::get('poem', 'index/getPoem');

Route::get('music', 'index/getMusic');

Route::post('login', 'admin/login');

Route::group('admin', function (){
    Route::get('cartoon', 'index/getCartoon');
    Route::get('commentList', 'index/getCommentList');
    Route::get('modifyComment', 'admin/modifyComment');
    Route::get('deleteComment', 'admin/deleteComment');
    Route::post('uploadFile', 'admin/uploadFile');
    Route::post('modifyCartoon', 'admin/modifyCartoon');
    Route::get('articleDetail', 'index/getArticleDetail');
})->middleware([\app\middleware\CheckLogin::class]);
