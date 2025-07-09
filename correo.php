<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/correoContra.css">
    <title>Recuperar Contraseña</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        div {
            text-align: center;
            max-width: 600px;
            padding: 20px;
        }

        .btnRecuperar {
            display: inline-block;
            padding: 10px 20px;
            color: white !important;
            background-color: #4359a5;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.5s;
            margin: 20px auto;
        }

        .btnRecuperar:hover {
            background-color: #0e94c1;
        }

        h1 {
            color: #C71585;
        }

        .texto {
            color: #0e94c1;
        }

        img {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>

<body>
    <div>

        <img src="https://drive.google.com/uc?id=1iFhP357-1nOhKN1MCngt33ef7IjSHJ9D" alt="Logo de la empresa" style="max-width: 80%; display: block; margin: 0 auto;">

        <p>
            <a class="btnRecuperar" href="http://localhost/ALMACEN/reset.php?token={{token}}" class="button">Recuperar Contraseña</a>
        </p>
    </div>
</body>

</html>