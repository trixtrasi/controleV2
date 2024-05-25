<?php
//Inclui arquivo de coneção
require_once "../../connect.php";

//Define as variaveis com valores vazios
$username = $password = $nome = $status = $nivel = "";
$username_err = $password_err = $login_err = $status_err = "";

// Processamento dos dados ao preencher o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Checa se o nome foi preenchido
    if (empty(trim($_POST["username"]))) {
        $username_err = "Preencha o nome de usuário";
    } else {
        $username = trim($_POST["username"]);
    }

    //Checa se a senha foi preenchida
    if (empty(trim($_POST["password"]))) {
        $password_err = "Preencha uma senha válida.";
    } else {
        $password = trim($_POST["password"]);
    }

    //Validação de credenciais
    if (empty($username_err) && empty($password_err)) {
        //Preparação do 'SELECT'
        $sql = "SELECT `users__id`, `users__username`, `users__nome`, `users__status`, `users__password`, `users__nivel` FROM `users` WHERE `users__username` = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            //Une as variáveis ao 'SELECT' como parametros 
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            //Tentativa de execução
            if (mysqli_stmt_execute($stmt)) {
                //Guarda o resultado
                mysqli_stmt_store_result($stmt);

                //Checa se o usuário já existe, se sim compara a senha
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    //Une as variaveis do resultado
                    mysqli_stmt_bind_result($stmt, $id_user, $username, $nome, $status, $hashed_password, $nivel);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password) and $status > 0) {
                            //Senha correta, sessão inicia e usuário válido. usuarios exluidos ficam negativos 
                            session_start();

                            //guarda os dados em variaveis da seção
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id_user;
                            $_SESSION["username"] = $username;
                            $_SESSION["nome"] = $nome;
                            $_SESSION["nivel"] = $nivel;

                            // redireciona o usuario para página inicial
                            header("location: ../../");
                        } else {
                            //Senha inválida, mensagem de erro
                            $login_err = "Senha ou Usuário inválidos!";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Senha ou Usuário inválidos!";
                }
            } else {
                echo "Oops! Algo deu errado. Contate o Suporte!";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Acesso de Visitantes</title>
    <!--FAV ICONS-->
    <link type="image/png" rel="icon" href="../../public/img/png/password.png">
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="../../plugins/bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../plugins/bootstrap-5.0.2-dist/css/bootstrap-grid.css">
    <!--CSS | COMPLEMENTAR-->
    <link rel="stylesheet" href="../../public/css/complements.css">
    <!--CSS | DATATABLES-->
    <link rel="stylesheet" href="../../plugins/dataTables/css/dataTables.dataTables.min.css">

    <!--BOOTSTRAP-->
    <script src="../../plugins/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <!--JQUERY-->
    <script src="../../plugins/jquery/jquery.js"></script>
    <!-- DATATABLES - JS -->
    <script src="../../plugins/dataTables/js/dataTables.min.js"></script>
</head>
<body class="bg-dark text-light max-vh-100">
    <div class="container mt-5">
        <div class="main row d-flex justify-content-center align-items-center">
            <div class="col-md-6 mt-4">
                <?php
                if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
                <h1 class="text-center">Controle de Acesso de Visitantes</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="pt-5 px-5">
                    <div class="form-group mb-2">
                        <label class="<?php echo (!empty($username_err)) ? 'text-danger' : ''; ?>">Usuário</label>
                        <input type="text" name="username" placeholder="RG" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group mb-4">
                        <label class="<?php echo (!empty($username_err)) ? 'text-danger' : ''; ?>">Senha</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn col-12 btn-success btn-lg " value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
