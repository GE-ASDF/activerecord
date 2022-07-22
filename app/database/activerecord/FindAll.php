<?php
namespace app\database\activerecord;

use Throwable;
use app\database\connection\Connection;
use function app\helpers\formatException;

use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\ActiveRecordExecuteInterface;
use Exception;

class FindAll implements ActiveRecordExecuteInterface{

    
    public function __construct(
        private array $where = [], 
        private string|int $limit = '',
        private string|int $offset = '',
        private string $fields = "*"
    )
    {
        
    }

    public function execute(ActiveRecordInterface $activeRecordInterface){

        try{

            $query = $this->createQuery($activeRecordInterface);
            $conn = Connection::connect();
            $prepare = $conn->prepare($query);
            $prepare->execute($this->where);
            return $prepare->fetchAll();
        }catch(Throwable $throw){
            formatException($throw);
        }

    }

    private function createQuery($activeRecordInterface){

        if(count($this->where) > 1){
            throw new Exception("No WHERE só pode passar um índice");
        }

        $where = array_keys($this->where);
        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()} ";
        $sql.=(!$this->where) ? '': " WHERE {$where[0]} = :{$where[0]}";
        $sql.= (!$this->limit) ? '':" LIMIT {$this->limit}";
        $sql.=($this->offset) != '' ? "OFFSET {$this->offset}":"";
        return $sql;
    }

    
}