<?php
//ȷ�������ӿͻ���ʱ���ᳬʱ
set_time_limit(0);
//����IP�Ͷ˿ں�
$address = "127.0.0.1";
$port = 2046; //���Ե�ʱ�򣬿��Զ໻�˿������Գ���
/**
 * ����һ��SOCKET
 * AF_INET=��ipv4 �����ipv6�������Ϊ AF_INET6
 * SOCK_STREAMΪsocket��tcp���ͣ������UDP��ʹ��SOCK_DGRAM
 */
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("socket_create() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n");
//����ģʽ
socket_set_block($sock) or die("socket_set_block() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n");
//�󶨵�socket�˿�
$result = socket_bind($sock, $address, $port) or die("socket_bind() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n");
//��ʼ����
$result = socket_listen($sock, 4) or die("socket_listen() ʧ�ܵ�ԭ����:" . socket_strerror(socket_last_error()) . "/n");
echo "OK\nBinding the socket on $address:$port ... ";
echo "OK\nNow ready to accept connections.\nListening on the socket ... \n";
do { // never stop the daemon
    //�������������󲢵���һ��������Socket������ͻ��˺ͷ����������Ϣ
    $msgsock = socket_accept($sock) or  die("socket_accept() failed: reason: " . socket_strerror(socket_last_error()) . "/n");

    //��ȡ�ͻ�������
    echo "Read client data \n";
    //socket_read������һֱ��ȡ�ͻ�������,ֱ������\n,\t����\0�ַ�.PHP�ű�����д�ַ�����������Ľ�����.
    $buf = socket_read($msgsock, 8192);
    echo "Received msg: $buf   \n";

    //���ݴ��� ��ͻ���д�뷵�ؽ��
    $msg = "$buf \n";
    socket_write($msgsock, $msg, strlen($msg)) or die("socket_write() failed: reason: " . socket_strerror(socket_last_error()) ."/n");
    //һ����������ص��ͻ���,��/��socket��Ӧͨ��socket_close($msgsock)��������ֹ
    socket_close($msgsock);
} while (true);
socket_close($sock);