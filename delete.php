<?php
header('Content-Type:text/html;charset=utf-8');
include_once './lib/fun.php';

if (!checkLogin()) {
    msg(2, '请登录', 'login.php');
}

$goodsId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';

//商品id不存在则跳转到商品列表
if (!$goodsId) {
    msg(2, '参数非法', 'index.php');
}

//根据商品id查询商品信息
$con = mysqlInit('127.0.0.1', 'root', '0926', 'mgallery');
$sql = "SELECT `id` FROM `m_goods` WHERE `id` = {$goodsId}";
$obj = mysql_query($sql);

//根据id查询商品信息为空则跳转商品列表页
if (!$goods = mysql_fetch_assoc($obj)) {
    msg(2, '画品不存在', 'index.php');
}

//删除处理
$sql = "DELETE FROM `m_goods` where `id` = {$goodsId} LIMIT 1";

if ($result = mysql_query($sql)) {
    msg(1, '操作成功', 'index.php');
} else {
    msg(2, '操作失败', 'index.php');
}

//注意：项目中不会真正删除商品，而是更新商品表中的status 1:正常操作 -1:删除操作