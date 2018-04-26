<?php

$server='localhost';
$username='root';
$password='';
$dbname='project';
$error='Could not connect.';
$mysqli=new mysqli($server,$username,$password,$dbname);
if(!$mysqli)
{
    die($error);
}

?>