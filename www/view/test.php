<?php
$dateString = '2024-06-23'; // Replace this with your specific date in YYYY-MM-DD format
$currentWeekNumber = date('W', strtotime($dateString));
echo "Week number of $dateString: $currentWeekNumber";

?>