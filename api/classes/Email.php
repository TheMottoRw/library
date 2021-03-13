<?php

$to = "mnzroger@gmail.com";
$subject = "For your information as engineer";
$txt = "Hello Roger,we are glad to inform you about our plan for having a meeting with you,would you join us?!";
$headers = "From: hasua.mr@gmail.com";

echo mail($to,$subject,$txt,$headers);

?>