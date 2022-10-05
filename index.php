<?php
require_once "Pessoa.php";
$p = new Pessoa("CRUDPDO","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP PDO</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php
        if(isset($_POST['nome'])){//Verificar se foi passado algum valor e clicado no botão cadastrar/atualizar
            
            if(isset($_GET['id_up']) && !empty($_GET['id_up'])){//Foi selecionado o botão atualizar
                $nome = addslashes($_POST['nome']); 
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                $id_upd = addslashes($_GET['id_up']);

                if(!empty($nome) && !empty($telefone) && !empty($email) ){
                    $p->atualizarDados($id_upd,$nome,$telefone,$email);
                    header("Location: index.php");                
                }else{
                    echo "<div class='aviso'> <img src='aviso.png'> <h4>Preencha todos os campos</h4> </div>";
                }
            }else {//Foi selecionado o botão cadastrar 
                $nome = addslashes($_POST['nome']); // o addslashes faz a proteção contra alguns códigos maliciosos
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);

                if(!empty($nome) && !empty($telefone) && !empty($email) ){
                    if(!$p->cadastrarPessoa($nome,$telefone,$email)){
                        echo "<div class='aviso'> <img src='aviso.png'> <h4>Email já está cadastrado</h4> </div>";
                    }                
                }else{
                    echo "<div class='aviso'> <img src='aviso.png'> <h4>Preencha todos os campos</h4> </div>";
                }
            }
        }
    ?>
    <?php
        if(isset($_GET['id_up'])){//verifica se a pessoa clicou no botão editar
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
            

        }

    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){ echo $res['nome'];} ?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){ echo $res['telefone'];} ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)){ echo $res['email'];} ?>">
            <input type="submit" value="<?php if(isset($res)){ echo "Atualizar"; }else{echo "Cadastrar";} ?>">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>
            <?php
                $dados = $p->buscarDados();
                $count_linha = count($dados);
                if($count_linha > 0){     
                    for ($i=0;$i<$count_linha;$i++){
                        echo "<tr>";
                        foreach ($dados[$i] as $k => $v) {
                            if($k != "id"){
                                echo "<td>".$v."</td>";
                            }
                        }
                        ?>
                        <td>
                            <a href="index.php?id_up=<?= $dados[$i]['id']; ?>">Editar</a>
                            <a href="index.php?id=<?= $dados[$i]['id']; ?>">Excluir</a>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                }else{
                    
                ?>
        </table>
        <div class='aviso'> <h4>Ainda não há pessoas cadastradas!</h4> </div>
        <?php
                }
        ?>
    </section>
    
</body>
</html>


<?php

if(isset($_GET['id'])){
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("Location: index.php"); // A função Header serve para montar um cabeçalho para o pacote HTTP que será transmitido naquela requisição
}

?>