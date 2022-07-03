<!DOCTYPE html>
<?php
    include_once "../classes/autoload.php";
    $id = null;
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $ret = new Retangulo('','','','','');
        $lista = $ret->select('*', "id = $id");
    }

    $altura = isset($_POST['altura']) ? $_POST['altura'] : 0;
    $base = isset($_POST['base']) ? $_POST['base'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : 0;
    $idtabuleiro = isset($_POST['idtabuleiro']) ? $_POST['idtabuleiro'] : 0;
    $buscar = isset($_POST["buscar"]) ? $_POST["buscar"] : 0;
    $procurar = isset($_POST["procurar"]) ? $_POST["procurar"] : "";
    $table = "retangulo";

    if(isset($_POST['acao'])) {
        $acao = $_POST['acao'];
    } else if(isset($_GET['acao'])) {
        $acao = $_GET['acao'];
    } else {
        $acao = "";
    }

    if($acao == "insert") {
        try{
            $ret = new Retangulo("", $altura, $base, $cor, $idtabuleiro);
            $ret->inserir();
            header("location:cadRetangulo.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao cadastrar as informações.</h1><br> Erro:".$e->getMessage();
        }
    } else if($acao == "editar") {
        try{
            $ret = new Retangulo($id, $altura, $base, $cor, $idtabuleiro);
            $ret->editar();
            header("location:cadRetangulo.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao editar as informações.</h1><br> Erro:".$e->getMessage();
        }
    } else if($acao == "excluir") {
        try{
            $ret = new Retangulo($id, "", "", "", "");
            $ret->excluir();
            header("location:cadRetangulo.php");
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
    <title>Retangulo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <header>
        <?php include_once "../menu.php"; ?>
    </header>
    <content>
    <form action="<?php if(isset($_GET['id'])) { echo "cadRetangulo.php?id=$id&acao=editar";} else {echo "cadRetangulo.php?acao=insert";}?>" method="post" id="form" style="padding-left: 0.7px;">
        <h1>Criar um Retangulo</h1><br>
        <input readonly type="hidden" name="id" id="id" value="<?php if (isset($id)) echo $lista[0]['id'];?>">
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Altura:</div>
                <input required type="text" name="altura" id="altura" value="<?php if (isset($id)) echo $lista[0]['altura'];?>" class="form-control-sm border border-dark rounded-end">
            </div>
        </div><br>
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Base:</div>
                <input required type="text" name="base" id="base" value="<?php if (isset($id)) echo $lista[0]['base'];?>" class="form-control-sm border border-dark rounded-end">
        </div><br>
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Cor:</div>
                <input required type="color" name="cor" id="cor" value="<?php if (isset($id)) echo $lista[0]['cor'];?>" class="form-control-color border border-dark rounded-end">
        </div><br>
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Tabuleiro:</div>
                <select name="idtabuleiro" id="idtabuleiro" value="" class="form-select-sm border border-dark rounded-end" aria-label="Floating label select example">
                <?php
                    $pdo = Database::iniciaConexao();
                    $consulta = $pdo->query("SELECT * FROM tabuleiro;");
                    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option name="" value="<?php echo $linha['idtabuleiro'];?>"><?php echo $linha['idtabuleiro'];?></option>
                <?php } ?>
                </select>
            </div>
        </div><br>
        <button name="" value="true" id="" type="submit" class="btn btn-dark">Salvar</button>
    </form><br><br>
    <div class="card text-bg-dark mb-3"></div>
    <form method="post" style="padding-left: 0.7px;">
        <h1>Pesquisar Por:</h1>
        <div class="form-check">
            <input type="radio" name="buscar" value="1" <?php if ($buscar == "1") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">ID</label><br>
            <input type="radio" name="buscar" value="2" <?php if ($buscar == "2") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">Altura</label><br>
            <input type="radio" name="buscar" value="3" <?php if ($buscar == "3") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">Base</label><br>
            <input type="radio" name="buscar" value="4" <?php if ($buscar == "4") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">Cor</label><br>
            <input type="radio" name="buscar" value="5" <?php if ($buscar == "5") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">Tabuleiro</label><br>
        </div>
        <div class="col-auto">
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
                        <th scope="col">ALtura</th>
                        <th scope="col">Base</th>
                        <th scope="col">Cor</th>
                        <th scope="col">Tabuleiro</th>
                        <th scope="col">Mostrar</th>
                        <th scope="col">Alterar</th>
                        <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $lista = Retangulo::listar($buscar, $procurar);
                    foreach ($lista as $linha) { 
                ?>
                    <tr>
                        <th scope="row"><?php echo $linha['id'];?></th>
                        <th scope="row"><?php echo $linha['altura'];?></th>
                        <th scope="row"><?php echo $linha['base'];?></th>
                        <th scope="row"><?php echo "<div style='width: 4vh; height: 2vh; background: ".$linha['cor'].";'></div><br>";?></th>
                        <th scope="row"><?php echo $linha['idtabuleiro'];?></th>
                        <td scope="row"><a href="../show/mostrarret.php?id=<?php echo $linha['id'];?>"><img src="../img/eye.svg" alt=""></a></td>
                        <td scope="row"><a href="cadRetangulo.php?id=<?php echo $linha['id'];?>&idtabuleiro=<?php echo $linha['idtabuleiro'];?>"><img src="../img/edit.svg" alt=""></a></td>
                        <td><a onclick="return confirm('Deseja mesmo excluir?')" href="cadRetangulo.php?id=<?php echo $linha['id'];?>&acao=excluir"><img src="../img/trash-2.svg" alt=""></a></td>
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