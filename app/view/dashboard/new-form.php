<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Nuevo Formulario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <nav class="navbar">
            <div class="navbar-container">
                <h1 class="navbar-title">Generador de Informes</h1>
                <div class="navbar-menu">
                    <span>Bienvenido, <?php echo htmlspecialchars($username); ?></span>
                    <a href="<?php echo BASE_URL; ?>dashboard" class="btn-primary">Historial</a>
                    <a href="<?php echo BASE_URL; ?>login/logout" class="btn-logout">Salir</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <h2>Generar Nuevo Informe de Terreno</h2>

            <form method="POST" enctype="multipart/form-data" class="form-container">
                <!-- Información General -->
                <section class="form-section">
                    <h3>Información del Informe</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="mes_anio">Mes y año del informe</label>
                            <input type="text" id="mes_anio" name="mes_anio" placeholder="Ej.: Agosto 2025">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código del informe</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Ej.: AES_COR_20082025">
                        </div>
                        <div class="form-group">
                            <label for="fecha_emision">Fecha de emisión</label>
                            <input type="text" id="fecha_emision" name="fecha_emision" placeholder="Ej.: 20 de agosto del 2025">
                        </div>
                        <div class="form-group">
                            <label for="temp_muestra">Temperatura primera muestra (°C)</label>
                            <input type="text" id="temp_muestra" name="temp_muestra" placeholder="Ej.: 7,1">
                        </div>
                    </div>
                </section>

                <!-- Mediciones In Situ -->
                <section class="form-section">
                    <h3>Resultados de Mediciones In Situ</h3>
                    <div class="table-responsive">
                        <table class="measurements-table">
                            <thead>
                                <tr>
                                    <th>Estación</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Temp (°C)</th>
                                    <th>Conduc. (μS/cm)</th>
                                    <th>Oxi Dis. (mg/L)</th>
                                    <th>pH</th>
                                    <th>Salinidad (PSU)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stations = [
                                    ['id' => 'eaa', 'label' => 'E AA'],
                                    ['id' => 'edes', 'label' => 'E DES'],
                                    ['id' => 'epta', 'label' => 'E PTA'],
                                    ['id' => 'eaab', 'label' => 'E AAB']
                                ];
                                $fields = ['fecha', 'hora', 'temp', 'conduc', 'oxigeno', 'ph', 'sal'];
                                foreach ($stations as $station): ?>
                                    <tr>
                                        <td><strong><?php echo $station['label']; ?></strong></td>
                                        <?php foreach ($fields as $field): ?>
                                            <td>
                                                <input type="text" name="<?php echo $station['id'] . '_' . $field; ?>" class="input-small">
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Observaciones -->
                <section class="form-section">
                    <h3>Observaciones</h3>
                    <textarea id="observaciones" name="observaciones" class="textarea-large" placeholder="Ingrese observaciones..."></textarea>
                </section>

                <!-- Registro Fotográfico -->
                <section class="form-section">
                    <h3>Registro Fotográfico</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="img_registro1">Imagen 1</label>
                            <input type="file" id="img_registro1" name="img_registro1" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="img_registro2">Imagen 2</label>
                            <input type="file" id="img_registro2" name="img_registro2" accept="image/*">
                        </div>
                    </div>
                </section>

                <!-- Anexos -->
                <section class="form-section">
                    <h3>Anexos</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="anexo1">Anexo 1</label>
                            <input type="file" id="anexo1" name="anexo1" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="anexo2">Anexo 2</label>
                            <input type="file" id="anexo2" name="anexo2" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="anexo3">Anexo 3</label>
                            <input type="file" id="anexo3" name="anexo3" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="anexo4">Anexo 4</label>
                            <input type="file" id="anexo4" name="anexo4" accept="image/*">
                        </div>
                    </div>
                </section>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Guardar Formulario</button>
                    <a href="<?php echo BASE_URL; ?>dashboard" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
