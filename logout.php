<?php
//sluit jou sessie volledig af (destroy)
session_start();
session_destroy();
header('Location: index.php');
exit;
