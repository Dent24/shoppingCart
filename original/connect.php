<?php

$link = @mysqli_connect('localhost', 'root', 'root');
mysqli_query($link, 'set names utf8');
mysqli_select_db($link, 'pid');

?>