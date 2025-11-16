<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Informe PDF</title>
<style>
    body { 
        font-family: DejaVu Sans, sans-serif; 
        font-size: 11px; 
        margin: 20mm 15mm 25mm 15mm;
        line-height: 1.3;
    }
    h2 { 
        margin: 0 0 8px 0; 
        padding: 0;
        font-size: 14px;
        color: #333;
    }
    .section-title { 
        font-weight: bold; 
        margin-top: 12px; 
        margin-bottom: 6px; 
        font-size: 13px; 
    }
    table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 8px;
        margin-bottom: 12px;
    }
    th, td { 
        border: 1px solid #666; 
        padding: 5px 6px; 
        font-size: 10px;
        text-align: left;
    }
    th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    .page-break { 
        page-break-after: always; 
    }

    /* Encabezado */
    .header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
    }
    .header-left {
        width: 60%;
    }
    .header-right {
        width: 38%;
        text-align: right;
        font-size: 10px;
        line-height: 1.4;
    }
    .logo-box {
        height: 70px;
        border: 1px dashed #bbb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        background-color: #f9f9f9;
    }

    /* Portada */
    .cover-page {
        height: 270mm;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .cover-content {
        width: 100%;
    }

    /* Fotografías */
    .photo-grid { 
        width: 100%; 
        margin-top: 15px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .photo-container {
        width: 48%;
        margin-bottom: 20px;
        text-align: center;
    }
    .photo-box {
        width: 100%;
        height: 180px;
        border: 1px solid #aaa;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8f8f8;
    }
    .photo-box img { 
        max-width: 70%; 
        max-height: 70%; 
        object-fit: contain;
    }
    .photo-label {
        font-size: 10px;
        font-weight: bold;
        color: #333;
    }

    /* Anexos */
    .anexos-grid {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 15px;
    }
    .anexo-container {
        width: 48%;
        margin-bottom: 20px;
        text-align: center;
    }
    .anexo-box { 
        width: 100%; 
        height: 240px; 
        border: 1px solid #999; 
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8f8f8;
    }
    .anexo-box img { 
        max-width: 95%; 
        max-height: 95%; 
        object-fit: contain;
    }
    .anexo-label {
        font-size: 10px;
        font-weight: bold;
        color: #333;
    }

    /* Observaciones */
    .observaciones {
        margin: 15px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    /* Footer */
    .page-footer {
        position: fixed;
        bottom: -10mm;
        right: 0;
        left: 0;
        text-align: right;
        font-size: 9px;
        color: #666;
        padding-right: 15mm;
    }

    /* Utilidades */
    .text-center { text-align: center; }
    .mb-10 { margin-bottom: 10px; }
    .mt-15 { margin-top: 15px; }
</style>
</head>
<body>

<?php
// --- Helpers para variables ---
function getFormVal($form, $keys, $default = '') {
    foreach ((array)$keys as $k) {
        if (isset($form[$k]) && $form[$k] !== '') return $form[$k];
    }
    return $default;
}

// Variables principales
$fecha_emision = getFormVal($form, ['fecha_emision','fecha','fecha_informe']);
$temp_primera = getFormVal($form, ['temp_muestra','temperatura_primera','temp_1','temp1']);
$inicio_muestreo = getFormVal($form, ['inicio_muestreo','fecha_hora_inicio','inicio','fecha_inicio']);
$fin_muestreo = getFormVal($form, ['fin_muestreo','fecha_hora_fin','fin','fecha_fin']);
?>

<!-- ===================== PORTADA ===================== -->
<div class="cover-page">
    <div class="cover-content">
        <?php
        $logo_fs = $logo_fs ?? (ROOT_PATH . 'public/img/logo.jpeg');
        $logo_web = $logo_web ?? (rtrim(BASE_URL, '/') . '/public/img/logo.jpeg');
        $logo_display = '';
        if (!empty($logo_fs) && file_exists($logo_fs)) {
            $logo_display = $logo_web;
        }
        ?>
        
        <?php if ($logo_display): ?>
            <div class="mb-10">
                <img src="<?php echo htmlspecialchars($logo_display); ?>" 
                     data-pdf-src="<?php echo htmlspecialchars($logo_fs); ?>" 
                     style="max-width: 120px; max-height: 60px; object-fit: contain;">
            </div>
        <?php else: ?>
            <div class="logo-box mb-10" style="margin: 0 auto 20px; width: 120px; height: 60px;">
                LOGO
            </div>
        <?php endif; ?>

        <h1 style="font-size: 28px; margin-bottom: 15px; color: #333;">INFORME DE TERRENO</h1>
        <h2 style="font-size: 20px; margin-bottom: 20px; color: #555;"><?php echo htmlspecialchars($form['codigo'] ?? ''); ?></h2>
        
        <div style="font-size: 16px; margin-top: 30px; color: #666;">
            Mes/Año: <?php echo htmlspecialchars($form['mes_anio'] ?? ''); ?>
        </div>
        
        <div style="margin-top: 40px; font-size: 12px; color: #777;">
            Generado por: <?php echo htmlspecialchars($username ?? 'Sistema'); ?>
        </div>
    </div>
</div>

<div class="page-break"></div>

<!-- ===================== CABECERA SECUNDARIA ===================== -->
<div class="header">
    <div>
        <?php if ($logo_display): ?>
            <div class="mb-10">
                <img src="<?php echo htmlspecialchars(rtrim(BASE_URL, '/').'/public/img/antecedentes.jpg'); ?>" 
                     data-pdf-src="<?php echo htmlspecialchars(ROOT_PATH . 'public/img/antecedentes.jpg'); ?>" 
                     style="max-width: 120px; max-height: 60px; object-fit: contain;">
            </div>
        <?php else: ?>
            <div class="logo-box mb-10" style="margin: 0 auto 20px; width: 120px; height: 60px;">
                LOGO
            </div>
        <?php endif; ?>
    </div>
    <div class="header-left">
        <div style="font-size: 11px; font-weight: 600;">
            Generado por: <?php echo htmlspecialchars($username ?? 'Sistema'); ?>
        </div>
        <div style="font-size: 10px; color: #666; margin-top: 3px;">
            Código: <?php echo htmlspecialchars($form['codigo'] ?? ''); ?>
        </div>
    </div>
    <div class="header-right">
        <div><strong>Fecha de Emisión:</strong><br><?php echo htmlspecialchars($fecha_emision ?: 'No especificada'); ?></div>
        <div style="margin-top: 6px;"><strong>Temperatura Primera Muestra:</strong><br><?php echo htmlspecialchars($temp_primera ?: 'N/A'); ?><?php echo $temp_primera ? ' °C' : ''; ?></div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!-- ===================== 1. INFORMACIÓN DEL INFORME ===================== -->
<h2>1. Información del Informe</h2>

<table>
    <tr>
        <th style="width: 30%;">Mes / Año</th>
        <td style="width: 70%;"><?php echo htmlspecialchars($form['mes_anio'] ?? 'No especificado'); ?></td>
    </tr>
    <tr>
        <th>Código</th>
        <td><?php echo htmlspecialchars($form['codigo'] ?? 'No especificado'); ?></td>
    </tr>
    <tr>
        <th>Fecha de Emisión</th>
        <td><?php echo htmlspecialchars($fecha_emision ?: 'No especificada'); ?></td>
    </tr>
    <tr>
        <th>Temperatura 1ra Muestra</th>
        <td><?php echo htmlspecialchars($temp_primera ?: 'N/A'); ?><?php echo $temp_primera ? ' °C' : ''; ?></td>
    </tr>
    <?php if ($inicio_muestreo || $fin_muestreo): ?>
    <tr>
        <th>Período de Muestreo</th>
        <td>
            <?php if ($inicio_muestreo): ?>Inicio: <?php echo htmlspecialchars($inicio_muestreo); ?><?php endif; ?>
            <?php if ($fin_muestreo): ?><?php echo $inicio_muestreo ? ' - ' : ''; ?>Fin: <?php echo htmlspecialchars($fin_muestreo); ?><?php endif; ?>
        </td>
    </tr>
    <?php endif; ?>
</table>

<!-- ===================== 2. RESULTADOS DE MEDICIONES IN SITU ===================== -->
<h2 class="mt-15">2. Resultados de Mediciones In Situ</h2>

<table>
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
        // Agrupar mediciones
        $grouped = [];
        foreach ($measurements as $m) {
            if (!isset($grouped[$m['row_id']])) $grouped[$m['row_id']] = [];
            $grouped[$m['row_id']][$m['field_id']] = $m['value'];
        }
        
        $stationLabels = [
            'eaa' => 'E AA', 
            'edes' => 'E DES', 
            'epta' => 'E PTA', 
            'eaab' => 'E AAB'
        ];
        
        $fields = ['fecha','hora','temp','conduc','oxigeno','ph','sal'];
        $order = ['eaa','edes','epta','eaab'];
        
        foreach ($order as $rowId):
            $rowData = $grouped[$rowId] ?? [];
        ?>
        <tr>
            <td><strong><?php echo htmlspecialchars($stationLabels[$rowId]); ?></strong></td>
            <?php foreach ($fields as $f): ?>
                <td><?php echo htmlspecialchars($rowData[$f] ?? '-'); ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- ===================== OBSERVACIONES ===================== -->
<h2 class="mt-15">Observaciones</h2>
<div class="observaciones">
    <?php echo nl2br(htmlspecialchars($form['observaciones'] ?? 'Sin observaciones.')); ?>
</div>

<!-- ===================== REGISTRO FOTOGRÁFICO ===================== -->
<div class="page-break"></div>

<h2>Registro Fotográfico</h2>

<div class="photo-grid">
    <?php
    if (!empty($images)):
        foreach ($images as $index => $img):
            $fsPath = $img['image_path'] ?? '';
            $webPath = $img['web_path'] ?? '';
            $display = '';
            
            if ($webPath) {
                $display = $webPath;
            } elseif ($fsPath && file_exists($fsPath)) {
                $display = str_replace(ROOT_PATH, BASE_URL, $fsPath);
            }
            $dataPdf = ($fsPath && file_exists($fsPath)) ? $fsPath : '';
    ?>
    <div class="photo-container">
        <div class="photo-box">
            <?php if ($display || $dataPdf): ?>
                <img src="<?php echo htmlspecialchars($display ?: $dataPdf); ?>" 
                     data-pdf-src="<?php echo htmlspecialchars($dataPdf); ?>" 
                     alt="Imagen <?php echo ($index + 1); ?>">
            <?php else: ?>
                <div style="color: #999;">IMAGEN NO DISPONIBLE</div>
            <?php endif; ?>
        </div>
        <div class="photo-label">Imagen <?php echo ($index + 1); ?></div>
    </div>
    
    <?php 
        // Salto de página después de cada 2 imágenes
        if (($index + 1) % 2 === 0 && ($index + 1) < count($images)):
            echo '</div><div class="page-break"></div><div class="photo-grid">';
        endif;
        ?>
    
    <?php endforeach; 
    else: ?>
    <div class="text-center" style="width: 100%; padding: 20px; color: #999;">
        No hay imágenes disponibles
    </div>
    <?php endif; ?>
</div>

<!-- ===================== ANEXOS ===================== -->
<?php if (!empty($attachments)): ?>
<div class="page-break"></div>

<h2>Anexos</h2>

<div class="anexos-grid">
    <?php
    foreach ($attachments as $index => $aSrc):
        $aFs = '';
        if ($aSrc && file_exists($aSrc)) {
            $aFs = $aSrc;
            $aSrc = str_replace(ROOT_PATH, BASE_URL, $aSrc);
        } else {
            if ($aSrc && strpos($aSrc, BASE_URL) === 0) {
                $possible = str_replace(BASE_URL, ROOT_PATH, $aSrc);
                if (file_exists($possible)) {
                    $aFs = $possible;
                    $aSrc = str_replace(ROOT_PATH, BASE_URL, $possible);
                }
            }
        }
    ?>
    <div class="anexo-container">
        <div class="anexo-box">
            <?php if ($aSrc || $aFs): ?>
                <img src="<?php echo htmlspecialchars($aSrc ?: $aFs); ?>" 
                     data-pdf-src="<?php echo htmlspecialchars($aFs); ?>" 
                     alt="Anexo <?php echo ($index + 1); ?>">
            <?php else: ?>
                <div style="color: #999;">ANEXO NO DISPONIBLE</div>
            <?php endif; ?>
        </div>
        <div class="anexo-label">Anexo <?php echo ($index + 1); ?></div>
    </div>
    
    <?php 
    // Salto de página después de cada 2 anexos
    if (($index + 1) % 2 === 0 && ($index + 1) < count($attachments)):
        echo '</div><div class="page-break"></div><div class="anexos-grid">';
    endif;
    ?>
    
    <?php endforeach; ?>
</div>
<?php endif; ?>

</body>
</html>