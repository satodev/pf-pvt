<?php
include_once('../classes/Mailer.class.php');
$mail = new Mailer();
$mail->queryDeleteMails();