<?php

class Database{
    public $conn;
    public string $local="localhost";
    public string $db="senha";
    public string $user = "root";
    public string $password = "";
    public $table;


   public function __construct($table = null){
        $this->table = $table;
        $result = $this->conecta();
    }

    public function conecta(){
        try {
            $this->conn = new PDO("mysql:host=".$this->local.";dbname=$this->db",$this->user,$this->password); 
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            //echo "Conectado com Sucesso!!";
        } catch (PDOException $err) {
            //retirar msg em produção
            die("ERRO DE CONEXAO: " . $err->getMessage());
        }
    }

    
    public function execute($query,$binds = []){
        //BINDS = SELECT 
        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);
            return $stmt;
        }catch (PDOException $err) {
            //retirar msg em produção
            die("Connection Failed " . $err->getMessage());
        }
    }

    public function insert($values){
        //DEBUG
        $fields = array_keys($values);
        $binds = array_pad([],count($fields),'?');

        //Montar query
        $query = 'INSERT INTO ' . $this->table .'  (' .implode(',',$fields). ') VALUES (' .implode(',',$binds).')';
        $result = $this->execute($query,array_values($values));
        
        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    public function update($where,$values){
        $fields = array_keys($values);
        //Montar query
        $query = 'UPDATE ' . $this->table .' SET ' .implode('=?,',$fields). '=? WHERE ' .$where;
        $result = $this->execute($query,array_values($values));
        
        return true;
    }

    public function select(string $table = null,string $where = null, string $order = null, string $limit = null, string $fields = '*'): array
    {
        // Montando a query
        $query = "SELECT $fields FROM {$table}";
    
        if ($where) {
            $query .= " WHERE $where";
        }
    
        if ($order) {
            $query .= " ORDER BY $order";
        }
    
        if ($limit) {
            $query .= " LIMIT $limit";
        }
    
        // Preparando e executando a query
        // echo($query);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function delete($where){
        $sql = 'DELETE FROM '.$this->table.' WHERE '.$where;
        $result = $this->execute($sql);
        return true;
    }


}