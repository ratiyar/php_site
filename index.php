<?php

require 'database.php';
require 'myform.html';
$flag = 0;
$orderid= '';
if (isset($_POST['submit'])) {
    if (isset($_POST['orderid'], $_POST['fname'], $_POST['lname'], $_POST['time'])) {
        $orderid = strtoupper(trim(htmlentities($_POST['orderid'])));
        $fname = strtoupper(trim(htmlentities($_POST['fname'])));
        $lname = strtoupper(trim(htmlentities($_POST['lname'])));
        $time = strtoupper(trim(htmlentities($_POST['time'])));
    } else {
        echo '<script type="text/javascript">alert("One or more fields are not set.");</script>';
        $flag = 1;
    }
}
$orderid1=$orderid;
function checkEmpty()
{
    global $orderid, $fname, $lname, $time, $flag;
    if (isset($_POST['submit'])) {
        if (empty($orderid) || empty($fname) || empty($lname) || empty($time)) {
            echo '<script type="text/javascript">alert("One or more fields are empty.");</script>';
            $flag = 1;
        } 
        
    }
}
function checkInput()
{
    global $orderid, $fname, $lname, $time, $flag;
    if (isset($_POST['submit'])) {
        if (!preg_match('/^\d{6}$/', $orderid) && !empty($orderid)) {
            echo '<p>Invalid order ID. </p>';
            $flag = 1;
        }
        if (!preg_match('/^[a-zA-Z]+$/', $fname) && !empty($fname)) {
            echo '<p>Invalid First Name. </p>';
            $flag = 1;
        }
        if (!preg_match('/^[a-zA-Z]+$/', $lname) && !empty($lname)) {
            echo '<p>Invalid Last Name. </p>';
            $flag = 1;
        }
        if (!preg_match('/^\d{2}$/', $time) && !empty($time)) {
            echo '<p>Invalid Time Input. </p>';
            $flag = 1;
        }
    }
}
function sendCheckQuery()
{
    global $orderid1, $mysqli, $flag;
    if (isset($_POST['submit'])) {
        if ($sendcheckquery = $mysqli->prepare('SELECT `orderid` FROM `pinpointme` WHERE `orderid`=?')) {
            $sendcheckquery->bind_param('i', $orderid1);
            if ($sendcheckquery->execute()) {
                $sendcheckquery->store_result();
                $sendcheckquery->bind_result($orderid1);
                $sendcheckquery->fetch();
                if ($sendcheckquery->num_rows == 1) {
                    echo '<p><strong>Order ID</strong> already exists.</p>';
                    $flag = 1;
                }
            }
        }
        $sendcheckquery->close();
    }
}
function sendQuery()
{
    global $orderid, $fname, $lname, $time, $mysqli;
        $query = 'INSERT INTO `pinpointme` (`orderid`,`time`,`fname`,`lname`,`ordertime`) VALUES(?,?,?,?,NOW())';
        if ($sendquery = $mysqli->prepare($query)) {
            $sendquery->bind_param('iiss', $orderid, $time, $fname, $lname);
            if ($sendquery->execute()) {
                echo '<script type="text/javascript">alert("Database successfully updated.");</script>';
            }
        } 
}

checkEmpty();
checkInput();
sendCheckQuery();
if ($flag == 0) {
    sendQuery();
}

?>