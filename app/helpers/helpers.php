<?php
namespace app\helpers;

use Throwable;

function formatException(Throwable $throw){
    var_dump("Erro no arquivo <strong>{$throw->getFile()}</strong> na linha <strong>{$throw->getLine()}</strong> com a mensagem <strong>{$throw->getMessage()}</strong>");
}