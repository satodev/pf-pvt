<?php
require($_SERVER['DOCUMENT_ROOT'].'/classes/Mailer.class.php');
$mailer = new Mailer();
$mailer->getQuery();

// Mailer::getSearchQuery();
// echo $mailer->getQuery();


