<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Informes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(30, 58, 138, 0.25);
            padding: 40px;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, #1e3a8a 0%, #06b6d4 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }

        .login-container h1 {
            color: #0f172a;
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .login-container p {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.25s, box-shadow 0.25s, background-color 0.25s;
            background-color: white;
            color: #0f172a;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1e3a8a;
            background-color: #f0f9ff;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .errors {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #dc2626;
            color: #7f1d1d;
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            gap: 10px;
        }

        .errors svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .errors li {
            margin-bottom: 6px;
        }

        .success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-left: 4px solid #059669;
            color: #065f46;
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            gap: 10px;
        }

        .success svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.35);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .register-link a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #06b6d4;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 32px 20px;
            }

            .login-container h1 {
                font-size: 24px;
            }

            .form-group input {
                padding: 11px 12px;
                font-size: 16px;
            }

            .btn {
                padding: 11px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="login-icon">
                    <img src="../public/img/logo.jpeg" style="width:220px" alt="Logo">
                </div>
                <h1>Sistema de Informes</h1>
                <p>Gestión de Informes de Terreno</p>
            </div>

            <?php if (!empty($success)): ?>
                <div class="success">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div><?php echo htmlspecialchars($success); ?></div>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>login/show">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" class="btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="stroke-width: 2;">
                        <path d="M15 3h4v4m0-4L9 15M9 3H5v16h14V9" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Iniciar Sesión
                </button>
            </form>

            <!-- Sección de registro eliminada -->
        </div>
    </div>
</body>
</html>
