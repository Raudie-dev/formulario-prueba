<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Formularios</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="dashboard">
        <nav class="navbar">
            <div class="navbar-container">
                <img src="public/img/logo.png" alt="logo" style="height:50px; width:120px;">
                <h1 class="navbar-title">Generador de Informes</h1>
                <div class="navbar-menu">
                    <span>Bienvenido, <?php echo htmlspecialchars($username); ?></span>
                    <a href="<?php echo BASE_URL; ?>dashboard/newForm" class="btn-primary">+ Nuevo Formulario</a>
                    <a href="<?php echo BASE_URL; ?>login/logout" class="btn-logout">Salir</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <h2>Historial de Formularios</h2>

            <?php if (!empty($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_SESSION['success_message']);
                    unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error_message'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_SESSION['error_message']);
                    unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($forms)): ?>
                <div class="empty-state">
                    <p>No hay formularios aún.</p>
                    <a href="<?php echo BASE_URL; ?>dashboard/newForm" class="btn-primary">Crear primer formulario</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="forms-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Mes/Año</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($forms as $form): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($form['codigo']); ?></td>
                                    <td><?php echo htmlspecialchars($form['mes_anio']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($form['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo BASE_URL; ?>dashboard/show/<?php echo $form['id']; ?>" class="btn-view" title="Ver"><i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>pdf/generate/<?php echo $form['id']; ?>" class="btn-download" title="Ver PDF" target="_blank"><i class="bi bi-file-earmark-arrow-down-fill"></i></a>
                                            <a href="<?php echo BASE_URL; ?>dashboard/delete/<?php echo $form['id']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar este formulario?')" title="Eliminar"><i class="bi bi-trash-fill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
