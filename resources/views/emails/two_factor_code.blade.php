<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #4A90E2;
            text-align: center;
        }

        .code-box {
            background: #4A90E2;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 4px;
            border-radius: 8px;
            margin: 20px 0;
        }

        p {
            color: #333333;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #888888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Tu código de verificación</h2>

        <p>Usa el siguiente código para completar tu acceso seguro:</p>

        <div class="code-box">
            {{ $code }}
        </div>

        <p>Este código es válido solo por unos minutos.  
        Si no solicitaste este código, puedes ignorar este mensaje.</p>

        <div class="footer">
            © {{ date('Y') }} - Sistema de Autenticación
        </div>
    </div>
</body>
</html>
