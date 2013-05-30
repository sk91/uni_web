<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author max
 */
class DB extends PDO {

    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;

    public function __construct() {
        $this->engine = Settings::DB_ENGINE;
        $this->host = Settings::DB_HOST;
        $this->database = Settings::DB_NAME;
        $this->user = Settings::DB_USER;
        $this->pass = Settings::DB_PASSWORD;
        
        $dns = $this->engine . ':dbname=' . $this->database . ";host=" . $this->host;
        parent::__construct($dns, $this->user, $this->pass);
    }
    

    
    public function prepareWhereIdsList(&$ids){
        $where=new stdClass();
        
        $where->format=array(); //for prepered statement formatting
        $where->data=array();
       
        foreach ($ids as  $id) {
            $where->format[]='?';  
            $where->data[]=(int)$id; //id's mast be ints
        }
        $where->data= "WHERE id IN(".implode(",",$where->data).")";
        return $where;
    }
    
    public function  prepareBasicSelect($tablename,$fields="*"){
        
        if(is_array($fields)){
            $fields=  implode(',', $fields);
        }
        
        $baseSql="SELECT $fields FROM $tablename";
        
        return $baseSql;
    }
    
    
    
    public function prepareLimit($offset=0,$limit=-1){
        $limit=(int)$limit;
        if($limit==-1){
            $limit=PHP_INT_MAX; //according the specs unlimited with offset
        }
        $offset=(int)$offset;
        $statement="LIMIT $limit OFFSET $offset";
        return $statement;
    }
    
    public function  prepareOrderBy($orderBy){
        if(is_array($orderBy)){
            $statement=array();
            foreach($orderBy as $key => $field){
                $onefield=$field[0]." ".($field[1]?"ASC":"DESC");
                $statement[]=$onefield;
            }
            $statement="ORDER BY " . implode(",",$statement);
            return $statement;
        }
        return '';
    }
    
    public function deleteObject($table,$ids){
        $sql="DELETE FROM $table ";
        if(is_array($ids)){
            $sql.=$this->prepareWhereIdsList($ids);
        }else{
            $sql.="WHERE id=?";
            $ids=array($ids);
        }
        $stmt=$this->prepare($sql);
        $stmt->execute($ids);
    }

}

?>
