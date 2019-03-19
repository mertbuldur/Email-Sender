<?php
date_default_timezone_set('Europe/Istanbul');
require_once 'Processor.php';

$processor = new \EmailTask\Processor("localhost","task","root","");
// Add Task
$processor->add("buldurmert@gmail.com","test","Merhaba bu task ile gönderiliyor...");
$processor->add("buldurmert@gmail.com","test","Merhaba bu task ile gönderiliyor...","2019-03-21 12:00:00");



// Start Task
$processor->start();