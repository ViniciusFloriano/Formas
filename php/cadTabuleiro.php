<!DOCTYPE html>
<?php
    include_once "../conf/default.inc.php";
    require_once "../conf/Conexao.php";
    require_once "../classes/tabuleiro.class.php";
    $idtabuleiro = null;
    if(isset($_GET['idtabuleiro'])) {
        $idtabuleiro = $_GET['idtabuleiro'];
        $tab = new Tabuleiro('','');
        $lista = $tab->select('*', "idtabuleiro = $idtabuleiro");
    }

    $lado = isset($_POST['lado']) ? $_POST['lado'] : "";
    $buscar = isset($_POST["buscar"]) ? $_POST["buscar"] : 0;
    $procurar = isset($_POST["procurar"]) ? $_POST["procurar"] : "";
    $table = "tabuleiro";

    if(isset($_POST['acao'])) {
        $acao = $_POST['acao'];
    } else if(isset($_GET['acao'])) {
        $acao = $_GET['acao'];
    } else {
        $acao = "";
    }

    if($acao == "insert") {
        try{
            $tab = new Tabuleiro("", $lado);
            $tab->inserir();
            header("location:cadTabuleiro.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao cadastrar as informações.</h1><br> Erro:".$e->getMessage();
        }
    } else if($acao == "editar") {
        try{
            $tab = new Tabuleiro($idtabuleiro, $lado);
            $tab->editar();
            header("location:cadTabuleiro.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao editar as informações.</h1><br> Erro:".$e->getMessage();
        }
    } else if($acao == "excluir") {
        try{
            $tab = new Tabuleiro($idtabuleiro, "");
            $tab->excluir();
            header("location:cadTabuleiro.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao excluir as informações.</h1><br> Erro:".$e->getMessage();
        }
    } 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Tabuleiro</title>
</head>
<body>
    <header>
        <?php include_once "../menu.php"; ?>
    </header>
    <content>
    <form action="<?php if(isset($_GET['idtabuleiro'])) { echo "cadTabuleiro.php?idtabuleiro=$idtabuleiro&acao=editar";} else {echo "cadTabuleiro.php?acao=insert";}?>" method="post" id="form" style="padding-left: 0.7px;">
        <h1>Criar um Tabuleiro</h1><br>
        <input readonly type="hidden" name="idtabuleiro" id="idtabuleiro" value="<?php if (isset($idtabuleiro)) echo $lista[1]['idtabuleirotabuleiro'];?>">
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Lado:</div>
                <input required type="text" name="lado" id="lado" value="<?php if (isset($idtabuleiro)) echo $lista[0]['lado'];?>" class="form-control-sm border border-dark rounded-end">
            </div>
        </div><br>
        <button name="" value="true" id="" type="submit" class="btn btn-dark">Salvar</button>
    </form><br>
    <div class="card text-bg-dark mb-3"></div>
    <form method="post" style="padding-left: 0.7px;">
        <h1>Pesquisar Por:</h1>
        <div class="form-check">
            <input type="radio" name="buscar" value="1" <?php if ($buscar == "1") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">ID</label><br>
            <input type="radio" name="buscar" value="2" <?php if ($buscar == "2") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">Lado</label><br>
        </div>
        <div class="col-auto";>
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Procurar:</div>
                <input type="text" name="procurar" id="procurar" size="25" value="<?php echo $procurar;?>" class="form-control-sm border border-dark rounded-end">
            </div><br>
        </div>
        <button name="acao" id="acao" type="submit" class="btn btn-dark">Procurar</button>
        <br><br>
    </form>
        <div>
            <table border='1' class="table table-light table-striped">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">#ID</th>
                        <th scope="col">Lado</th>
                        <th scope="col">Mostrar</th>
                        <th scope="col">Alterar</th>
                        <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $tab = new Tabuleiro("","");
                    $lista = $tab->listar($buscar, $procurar);
                    foreach ($lista as $linha) { 
                ?>
                    <tr>
                        <th scope="row"><?php echo $linha['idtabuleiro'];?></th>
                        <th scope="row"><?php echo $linha['lado'];?></th>
                        <td scope="row"><a href="../show/mostrartab.php?idtabuleiro=<?php echo $linha['idtabuleiro']; ?>&lado=<?php echo $linha['lado'];?>"><img src="../img/eye.svg" alt=""></a></td>
                        <td scope="row"><a href="cadTabuleiro.php?idtabuleiro=<?php echo $linha['idtabuleiro'];?>"><img src="../img/edit.svg" alt=""></a></td>
                        <td><a onclick="return confirm('Deseja mesmo excluir?')" href="cadTabuleiro.php?idtabuleiro=<?php echo $linha['idtabuleiro'];?>&acao=excluir"><img src="../img/trash-2.svg" alt=""></a></td>
                    </tr>
                <?php } ?> 
                </tbody>
            </table>
        </div>
    </content>
    <div class="card text-bg-dark mb-3"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>