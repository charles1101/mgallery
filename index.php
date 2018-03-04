<?php
header('Content-Type:text/html;charset=utf-8');
include_once './lib/fun.php';

if($login = checkLogin())
{
    $user = $_SESSION['user'];
}

//检查page参数
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//把page与1对比 取中间最大值
$page = max($page, 1);
//每页显示条数
$pageSize = 3;
//偏移量
$offset = ($page - 1) * $pageSize;

//查询数据总数
$con = mysqlInit('127.0.0.1', 'root', '0926', 'mgallery');
$sql = "SELECT COUNT(`id`) AS total FROM `m_goods`";
$obj = mysql_query($sql);
$result = mysql_fetch_assoc($obj);
$total = isset($result['total']) ? $result['total'] : 0;

unset($sql,$result,$obj);

//只查询需要的数据
$sql = "SELECT `id`,`name`,`pic`,`des` FROM `m_goods` ORDER BY `id` ASC,`view` DESC limit {$offset},{$pageSize} ";
$obj = mysql_query($sql);
$goods = array();
while($result = mysql_fetch_assoc($obj))
{
    $goods[] = $result;
}

$pages = pages($total,$page,$pageSize,6);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|首页</title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/index.css"/>
</head>
<body>
<div class="header">
    <div class="logo f1">
        <a href="index.php"><img src="./static/image/logo.png"></a>
    </div>
    <div class="auth fr">
        <ul>
            <?php if($login): ?>
                <li><span>管理员：<?php echo $user['username'] ?></span></li>
                <li><a href="publish.php">发布</a></li>
                <li><a href="login_out.php">退出</a></li>
            <?php else: ?>
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="content">
    <div class="banner">
        <img class="banner-img" src="./static/image/welcome.png" width="732px" height="372" alt="图片描述">
    </div>
    <div class="img-content">
        <ul>
            <?php foreach($goods as $v):?>
            <li>
                <img class="img-li-fix" src="<?php echo $v['pic']?>" width="358px" height="215px" alt="<?php echo $v['name']?>">
                <div class="info">
                    <a href="detail.php?id=<?php echo $v['id']?>"><h3 class="img_title"><?php echo $v['name']?></h3></a>
                    <p>
                        <?php echo $v['des']?>
                    </p>
                    <div class="btn">
                        <a href="edit.php?id=<?php echo $v['id']?>" class="edit">编辑</a>
                        <a href="delete.php?id=<?php echo $v['id']?>" class="del">删除</a>
                    </div>
                </div>
            </li>
            <?php endforeach;?>

        </ul>
    </div>
    <?php echo $pages?>
</div>

<div class="footer">
    <p><span>M-GALLARY</span>©2018 POWERED BY MGALLERY.COM</p>
</div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script>
    $(function () {
        $('.del').on('click',function () {
            if(confirm('确认删除该画品吗?'))
            {
               window.location = $(this).attr('href');
            }
            return false;
        })
    })
</script>

</html>
