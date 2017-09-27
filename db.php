<?php
$con=mysqli_init();
if (!$con) {
    die("mysqli_init failed");
}

/*
if (!mysqli_real_connect($con, "192.168.0.102", "johnny", "Crypto123", "django")) {
    die("Connect Error: " . mysqli_connect_error());
}
 */
mysqli_ssl_set($con,
  "/etc/mysql/ssl/client-key.pem",
  "/etc/mysql/ssl/client-cert.pem", 
  "/etc/mysql/ssl/mysql-ca.crt", 
  NULL, 
  NULL);
if (!mysqli_real_connect($con, 
  "127.0.0.1", 
  "root", 
  "Crypto!@3", 
  "mycourse_20170526", 
  3306, 
  NULL, 
  MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT)) 
{
    die("Connect Error: " . mysqli_connect_error());
}

mysqli_close($con);
