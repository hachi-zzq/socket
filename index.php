<?php
$str = <<<EOT
set_time_limit(0);

\$host = "127.0.0.1";
\$port = 2046;
\$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // 创建一个Socket

\$connection = socket_connect(\$socket, \$host, \$port) or die("Could not connet server\n");    //  连接
socket_write(\$socket,\$_POST['msg']) or die("Write failed\n"); // 数据传送 向服务器发送消息
while (\$buff = socket_read(\$socket, 1024, PHP_NORMAL_READ)) {
echo("Response was:" . \$buff . "\n");
}
socket_close(\$socket);
EOT;
if(!empty($_POST['msg'])){
    eval($str);
}
?>
<form method="post" action="?">
    <input type="text" name="msg">
    <input type="submit" value="send">
</form>