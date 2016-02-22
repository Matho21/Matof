<?php

try{
	$db=new PDO ('mysql:host=localhost;charset=utf8; dbname=tpsamuel','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

}
catch(Exception $e){
	echo"Impossible de se connecter a la base des donnees".$e->getMessage();
	die ();
}
