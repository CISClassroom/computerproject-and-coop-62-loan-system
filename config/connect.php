<?php
    
    $dsn = 'mysql:host=localhost; prot=80; dbname=tot-loan';
    $username = 'root';
    //$password = 'rsrc2totdb2017';
    $password = '';

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    try{
        $dbh = new PDO($dsn, $username, $password, $options);
       
    } catch (PDOException $e) {
        echo 'ไม่สามารถติดต่อฐานข้อมูลได้ : ' . $e->getMessage();
    }
?>

