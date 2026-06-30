<?php
$host="localhost";
$usuario="root";
$senha="";
$banco="senac";
$conexao=mysqli_connect($host,$usuario,$senha,$banco);
if(!$conexao){
die("Erro ao conectar.");
}
?>