<?php

namespace app\database\interfaces;

interface ActiveRecordInterface{

    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface);
    public function getTable();
    public function getAtributos();
    public function __set($atributos, $valor);
    public function __get($atributos);

}