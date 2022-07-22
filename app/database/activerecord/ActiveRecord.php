<?php

namespace app\database\activerecord;

use app\database\interfaces\ActiveRecordExecuteInterface;
use ReflectionClass;
use app\database\interfaces\ActiveRecordInterface;


abstract class ActiveRecord implements ActiveRecordInterface{

    protected $table = null;
    protected $atributos = [];
    protected $valor;

    public function __construct()
    {
        if(!$this->table){
            $this->table = strtolower((new ReflectionClass($this))->getShortName());
        }
    }

    public function getTable(){
        return $this->table;
    }

    public function getAtributos(){
        return $this->atributos;
    }
    
    public function __set($atributos, $valor)
    {
        $this->atributos[$atributos] = $valor;
    }

    public function __get($atributos)
    {
        return $atributos[$atributos];
    }

    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface){
        return $activeRecordExecuteInterface->execute($this);
    }

}