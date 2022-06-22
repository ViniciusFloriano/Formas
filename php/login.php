<!DOCTYPE html>
<?php
    include_once "../conf/default.inc.php";
    require_once "../conf/Conexao.php";
    require_once "../classes/usuario.class.php";
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    $login = isset($_POST['login']) ? $_POST['login'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <header>
        <?php include_once "../menu.php"; ?>
    </header>
    <content>
        <form action="login.php?acao=login" method="post" id="form">
            <h1>Login</h1><br>
            <div class="col-auto">
                <div class="input-group">    
                    <div class="input-group-text border border-dark rounded-start">Login:</div>
                    <input required type="text" class="form-control-sm border border-dark rounded-end" name="login" id="login" value="<?php if (isset($_POST['login'])){echo $_POST['login'];}?>">
                </div>
            </div><br>
            <div class="col-auto">
                <div class="input-group">    
                    <div class="input-group-text border border-dark rounded-start">Senha:</div>
                    <input required type="password" class="form-control-sm border border-dark rounded-end" name="senha" id="senha" value="<?php if (isset($_POST['senha'])){echo $_POST['senha'];}?>">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit" id="submit" value="true">Logar</button>
        </form><br>
        <div class="card text-bg-dark mb-3"></div>
        <h1>
        <?php
            if(isset($_SESSION['nome'])) {
                echo "Logado com sucesso!";
            } else if(isset($_GET['login']) && !isset($_SESSION['nome'])) {
                echo "Informações incorretas!";
            }
        ?>
        <?php
            if($acao == "login") {
                $usua = new Usuario('', '', '', '');
                $usua->efetuarLogin("$login", "$senha");
                header("location:login.php?login=true");
            } else if($acao == "logout") {
                $_SESSION["nome"] = null;
                header("location:login.php");
            }
        ?>
        </h1>
    </content>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>