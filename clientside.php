<?php

require 'database.php';
require 'clientform.html';
if (isset($_POST['submit'])) {
    if (isset($_POST['orderid']) && !empty($_POST['orderid'])) {
        $orderid = htmlentities($_POST['orderid']);
        $query = 'SELECT * FROM `pinpointme` WHERE `orderid`=?';
        if ($sendquery = $mysqli->prepare($query)) {
            $sendquery->bind_param('i', $orderid);
            if ($sendquery->execute()) {
                $sendquery->store_result();
                $sendquery->bind_result($orderid, $time, $fname, $lname, $ordertime);
                if ($sendquery->num_rows != 1) {
                    echo '<p>We are sorry, but we have no data for the information you entered.</p> <br />';
                } else {
                    while ($sendquery->fetch()) {
                        echo '<table>
  <tr>
    <th>Order ID:</th>
    <th class="th">' . $orderid . '</th>
  </tr>
  <tr>
    <th>Estimate time:</th>
    <th class="th">' . $time . ' minutes </th>
  </tr>
  <tr>
    <th>First Name:</th>
    <th class="th">' . $fname . '</th>
  </tr>
  <tr>
    <th>Last Name:</th>
    <th class="th">' . $lname . '</th>
  </tr>
  <tr>
    <th>Order created on:</th>
    <th class="th">' . $ordertime . '</th>
  </tr>
</table>';
                    }
                }
            } else {
                echo '<p>Could not connect. Please try again later. </p>';
            }
        }
        $sendquery->close();
    }

}

?>