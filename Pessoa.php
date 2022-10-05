<?php

class Pessoa{
    private $pdo;

    public function __construct($dbname,$host,$user,$senha){

        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        } catch(Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            exit();
        }
    }

    public function buscarDados(){
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM PESSOA ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarPessoa($nome,$telefone,$email){

        //Verificar se já não possui cadastro
        $cmd = $this->pdo->prepare("SELECT id FROM PESSOA WHERE email = :e");
        $cmd->bindValue(":e",$email);
        $cmd->execute();

        if($cmd->rowCount() > 0){//email já existe
            return false;
        }else{//não foi encontrado o email
            $cmd = $this->pdo->prepare("INSERT INTO PESSOA (nome,telefone,email) VALUES (:n,:t,:e)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
        }

    }

    public function excluirPessoa($id){
        $cmd = $this->pdo->prepare("DELETE FROM PESSOA WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }

    //buscar dados de uma pessoa para depois atualizar
    public function buscarDadosPessoa($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM PESSOA WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    //atualizar dados no banco de dados

    public function atualizarDados($id,$nome,$telefone,$email){
            $cmd = $this->pdo->prepare("UPDATE PESSOA SET nome = :n, telefone = :t, email = :e WHERE id = :id");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            return true;
    }
}
?>