<?php
require './DB/Database.php';

class Usuario{

    public int $id;
    public string $nome;
    public string $email;
    public string $senha;

    public function cadastrar(){
        $db = new Database('usuario');
        $result =  $db->insert(
                            [
                            'nome' => $this->nome,
                            'email' => $this->email,
                            'senha' => $this->senha
                            ]
                        );
        
        if($result) {
            return true;
        }
        else{
            return false;
        }
    }

    public function atualizar(){
            return (new Database('usuario'))->update('id ='.$this->id,[
                'nome' => $this->nome,
                'email' => $this->email,
                'senha' => $this->senha,
            ]);
    }

    public static function buscar(){
        //FETCHALL
        return (new Database('cliente'))->select()->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscar_by_id($id){
        //FETCHALL
        return (new Database('cliente'))->select('id = '. $id)->fetchObject(self::class);
    }

    public function excluir($id){
        return (new Database('cliente'))->delete('id = '.$id);
    }

}