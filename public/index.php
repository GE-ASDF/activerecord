<?php


require "../vendor/autoload.php";

use app\database\activerecord\Delete;
use app\database\activerecord\Find;
use app\database\activerecord\FindAll;
use app\database\activerecord\FindBy;
use app\database\activerecord\Insert;
use app\database\classes\Update;
use app\database\models\Usuarios;


$usuarios = new Usuarios;

// $usuarios->nome = "Alexsandro";
// $usuarios->sobrenome = "Souza";
// $usuarios->email = "alexsandro@gmail.com";
// $usuarios->senha = "123";


var_dump($usuarios->execute(new FindAll()));