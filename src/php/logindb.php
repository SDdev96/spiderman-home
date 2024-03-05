<?php
$host = "localhost";
$port = '5432';
$db = 'gruppo05';
$username = 'www';
$password = 'tsw2023';

$connection_string = "host=$host port=$port dbname=$db user=$username password=$password";
$db = pg_connect($connection_string) or die('Impossibile connettersi al database');


?>