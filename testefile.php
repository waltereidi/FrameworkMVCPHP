<?php
// Enter your code here, enjoy!
$string= explode('\\' ,'login?login=walter&senha=123');
var_dump($string);
var_dump(isset($string[1]));
$contains = strpos($string[1] , '?');
var_dump($contains);


$str = substr('\sdsd' , -1);
echo $str;
?>