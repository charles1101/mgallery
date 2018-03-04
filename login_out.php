<?php
header('Content-Type:text/html;charset=utf-8');
include_once './lib/fun.php';
session_start();
//释放user
unset($_SESSION['user']);
msg(1, '退出登录成功', 'index.php');