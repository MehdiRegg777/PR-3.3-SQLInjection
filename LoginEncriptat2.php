<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO de Filtrar Llengües Con bindParam</title>
    <style>


        form {
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    

    <form method="post">
        <h2>Login con SHA Con bindParam</h2>
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php
    //phpinfo();
    try {
        $hostname = "localhost";
        $dbname = "DatosUsuarios";
        $username = "mehdi";
        $pw = "kingmehdi";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["username"];
        $contraseña = $_POST["password"];

        $querystr = "SELECT usuario FROM usuarios WHERE usuario=:usuario AND password_sha=SHA2(:contrasena, 256)";
        $query = $pdo->prepare($querystr);

        $query->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $query->bindParam(':contrasena', $contraseña, PDO::PARAM_STR);

        $query->execute();

        
        $filas = $query->rowCount();
        if ($filas > 0) {
            echo "Usuario Correcto: Hola $usuario";
        } else {
            echo "Usuario o contraseña incorrectos";
        }
        unset($pdo);
        unset($query);
    }
    

    ?>




</body>
</html>
