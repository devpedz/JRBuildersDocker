<?php
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

// Get current time
$date = new DateTime();
$hours = $date->format('H');
$minutes = $date->format('i');
$seconds = $date->format('s');
echo $hours.$minutes.$seconds;