<?php
include("conn.php");
//$query = " SELECT *,A.id app_id FROM tbl_appointments A LEFT JOIN tbl_timeslots T ON A.time_slot_start=T.id where TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),NOW()) < 0 AND TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),NOW()) > -15 AND A.mail_sent!=1";

$sql121 = "UPDATE tbl_user_master SET online_status='0' WHERE TIMESTAMPDIFF(MINUTE,STR_TO_DATE(last_seen_time, '%Y-%m-%d %h:%i:%s'),CONVERT_TZ(NOW(),'+00:00','-04:00')) > 15";
$r21 = $mysqli->query($sql121);
?>