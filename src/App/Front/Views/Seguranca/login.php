<?php
    global $session;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
<div class="container mt-3">
    <h4>Sistema</h4>
    <hr>
    <form action="http://localhost:8000/seguranca/login" method="post">
        <div class="mb-3 row">
            <label for="usuario" class="col-sm-2 col-form-label">Usuário:</label>
            <div class="col-sm-2">
                <input type="text"
                       class="form-control"
                       id="usuario"
                       name="usuario">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="senha" class="col-sm-2 col-form-label">Senha:</label>
            <div class="col-sm-2">
                <input type="password"
                       class="form-control"
                       id="senha"
                       name="senha">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-4">
                <button type="submit" id="btn-login" class="btn btn-success" >Login</button>
            </div>
        </div>
        <div>
            <?php
            foreach ($session->getFlashBag()->get('aviso', []) as $message) {
                echo '<div class="flash-warning">'.$message.'</div>';
            }
            ?>
        </div>
    </form>
    <hr>
    <div>
    </div>
</div>
</body>
</html>