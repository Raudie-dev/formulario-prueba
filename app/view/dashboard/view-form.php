<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Formulario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <nav class="navbar">
            <div class="navbar-container">
                <h1 class="navbar-title">Generador de Informes</h1>
                <div class="navbar-menu">
                    <span>Bienvenido, <?php echo htmlspecialchars($username); ?></span>
                    <a href="<?php echo BASE_URL; ?>dashboard" class="btn-link">Historial</a>
                    <a href="<?php echo BASE_URL; ?>login/logout" class="btn-logout">Salir</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="view-header">
                <h2>Informe: <?php echo htmlspecialchars($form['codigo']); ?></h2>
                <a href="<?php echo BASE_URL; ?>dashboard" class="btn-secondary">← Volver</a>
            </div>

            <!-- Información General -->
            <section class="form-section">
                <h3>Información del Informe</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Mes/Año:</label>
                        <p><?php echo htmlspecialchars($form['mes_anio']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Código:</label>
                        <p><?php echo htmlspecialchars($form['codigo']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Fecha de Emisión:</label>
                        <p><?php echo htmlspecialchars($form['fecha_emision']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Temperatura Primera Muestra:</label>
                        <p><?php echo htmlspecialchars($form['temp_muestra']); ?> °C</p>
                    </div>
                </div>
            </section>

            <!-- Mediciones -->
            <?php if (!empty($measurements)): ?>
                <section class="form-section">
                    <h3>Mediciones In Situ</h3>
                    <div class="table-responsive">
                        <table class="measurements-table">
                            <thead>
                                <tr>
                                    <th>Estación</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Temp (°C)</th>
                                    <th>Conduc.</th>
                                    <th>Oxi Dis.</th>
                                    <th>pH</th>
                                    <th>Salinidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grouped = [];
                                foreach ($measurements as $m) {
                                    if (!isset($grouped[$m['row_id']])) {
                                        $grouped[$m['row_id']] = [];
                                    }
                                    $grouped[$m['row_id']][$m['field_id']] = $m['value'];
                                }
                                $stationLabels = ['eaa' => 'E AA', 'edes' => 'E DES', 'epta' => 'E PTA', 'eaab' => 'E AAB'];
                                $fields = ['fecha', 'hora', 'temp', 'conduc', 'oxigeno', 'ph', 'sal'];
                                foreach ($grouped as $rowId => $rowData):
                                ?>
                                    <tr>
                                        <td><strong><?php echo $stationLabels[$rowId] ?? $rowId; ?></strong></td>
                                        <?php foreach ($fields as $field): ?>
                                            <td><?php echo htmlspecialchars($rowData[$field] ?? ''); ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Observaciones -->
            <?php if (!empty($form['observaciones'])): ?>
                <section class="form-section">
                    <h3>Observaciones</h3>
                    <p class="observation-text"><?php echo nl2br(htmlspecialchars($form['observaciones'])); ?></p>
                </section>
            <?php endif; ?>

            <!-- Imágenes -->
            <?php if (!empty($images)): ?>
                <section class="form-section">
                    <h3>Archivos Adjuntos</h3>
                    <div class="images-grid">
                        <?php foreach ($images as $image): ?>
                            <div class="image-item">
                                <p class="image-label"><?php echo htmlspecialchars($image['field_id']); ?></p>
                                <?php $imgSrc = $image['web_path'] ?? $image['image_path'] ?? ''; ?>
                                <?php if ($imgSrc): ?>
                                    <a href="<?php echo htmlspecialchars($imgSrc); ?>" target="_blank">
                                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($image['field_id']); ?>" style="max-width: 200px;">
                                    </a>
                                <?php else: ?>
                                    <p>No disponible</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <div class="form-actions">
                <a href="<?php echo BASE_URL; ?>pdf/generate/<?php echo $form['id']; ?>" target="_blank" class="btn-primary">Ver PDF</a>
                <a href="<?php echo BASE_URL; ?>dashboard" class="btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>
