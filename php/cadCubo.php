<!DOCTYPE html>
<?php
    include_once "../classes/autoload.php";
    $idcubo = null;
    if(isset($_GET['idcubo'])) {
        $idcubo = $_GET['idcubo'];
        $cubo = new Cubo('','','','');
        $lista = $cubo->select('*', "idcubo = $idcubo");
    }

    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $id = isset($_POST['idquadrado']) ? $_POST['idquadrado'] : 0;
    $buscar = isset($_POST["buscar"]) ? $_POST["buscar"] : 0;
    $procurar = isset($_POST["procurar"]) ? $_POST["procurar"] : "";
    $table = "cubo";

    if(isset($_POST['acao'])) {
        $acao = $_POST['acao'];
    } else if(isset($_GET['acao'])) {
        $acao = $_GET['acao'];
    } else {
        $acao = "";
    }

    if($acao == "insert") {
        try{
            $cubo = new Cubo("", $id, $lado, $cor);
            $cubo->inserir();
            header("location:cadCubo.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao cadastrar as informações.</h1><br> Erro:".$e->getMessage();
        }
    } else if($acao == "editar") {
        try{
            $cubo = new Cubo($idcubo, $id, $lado, $cor);
            $cubo->editar();
            header("location:cadCubo.php");
        } catch(Exception $e) {
            echo "<h1>Erro ao editar as informações.</h1><br> Erro:".$e->getMessage();
        }
    } else if($acao == "excluir") {
        try{
            $cubo = new Cubo($idcubo, "", "", "");
            $cubo->excluir();
            header("location:cadCubo.php");
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
    <title>Cubo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <header>
        <?php include_once "../menu.php"; ?>
    </header>
    <content>
    <form action="<?php if(isset($_GET['idcubo'])) { echo "cadCubo.php?idcubo=$idcubo&acao=editar";} else {echo "cadCubo.php?acao=insert";}?>" method="post" id="form" style="padding-left: 0.7px;">
        <h1>Criar um Cubo</h1><br>
        <input readonly type="hidden" name="idcubo" id="idcubo" value="<?php if (isset($idcubo)) echo $lista[0]['idcubo'];?>">
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Cor:</div>
                <input required type="color" name="cor" id="cor" value="<?php if (isset($idcubo)) echo $lista[0]['cor'];?>" class="form-control-color border border-dark rounded-end">
        </div><br>
        <div class="col-auto">
            <div class="input-group">    
                <div class="input-group-text border border-dark rounded-start">Quadrado:</div>
                <select name="idquadrado" id="idquadrado" value="" class="form-select-sm border border-dark rounded-end" aria-label="Floating label select example">
                <?php
                    $pdo = Database::iniciaConexao();
                    $consulta = $pdo->query("SELECT * FROM quadrado;");
                    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option name="" value="<?php echo $linha['id'];?>"><?php echo $linha['id'];?></option>
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
            <label class="form-check-label" for="flexRadioDefault1">Cor</label><br>
            <input type="radio" name="buscar" value="3" <?php if ($buscar == "3") echo "checked" ?> class="form-check-input">
            <label class="form-check-label" for="flexRadioDefault1">Quadrado</label><br>
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
                        <th scope="col">Cor</th>
                        <th scope="col">Quadrado</th>
                        <th scope="col">Lado</th>
                        <th scope="col">Mostrar</th>
                        <th scope="col">Alterar</th>
                        <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $lista = Cubo::listar($buscar, $procurar);
                    foreach ($lista as $linha) { 
                ?>
                    <tr>
                        <th scope="row"><?php echo $linha['idcubo'];?></th>
                        <th scope="row"><?php echo "<div style='width: 2em; height: 2em; background: ".$linha['cor'].";'></div>";?></th>
                        <th scope="row"><?php echo $linha['idquadrado'];?></th>
                        <th scope="row"><?php echo $linha['lado'];?></th>
                        <td scope="row"><a href="../show/mostrarcubo.php?idcubo=<?php echo $linha['idcubo']; ?>&lado=<?php echo $linha['lado'];?>"><img src="../img/eye.svg" alt=""></a></td>
                        <td scope="row"><a href="cadCubo.php?idcubo=<?php echo $linha['idcubo'];?>&idquadrado=<?php echo $linha['idquadrado'];?>"><img src="../img/edit.svg" alt=""></a></td>
                        <td><a onclick="return confirm('Deseja mesmo excluir?')" href="cadCubo.php?idcubo=<?php echo $linha['idcubo'];?>&acao=excluir"><img src="../img/trash-2.svg" alt=""></a></td>
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