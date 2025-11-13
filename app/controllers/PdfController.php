<?php
require_once ROOT_PATH . 'app/models/Form.php';
// Composer autoload (contiene TCPDF u otras dependencias). Si no existe, se muestra un mensaje claro
$autoloadPath = ROOT_PATH . 'vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    // Mensaje amigable en lugar de un fatal error que exponga stack trace
    die("Dependencias de Composer no encontradas. Ejecuta 'composer install' en la raíz del proyecto (ver README o guía).\nRuta esperada: " . $autoloadPath);
}

class PdfController extends Controller {
    private $formModel;

    public function __construct() {
        $this->requireLogin();
        $this->formModel = new Form();
    }

    public function generate($formId) {
        $userId = $this->getCurrentUserId();
        $form = $this->formModel->getFormById($formId, $userId);

        if (!$form) {
            $_SESSION['error_message'] = 'Formulario no encontrado';
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $measurements = $this->formModel->getFormMeasurements($formId);
        $images = $this->formModel->getFormImages($formId);

        // Create PDF using TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetFont('helvetica', '', 10);

        // Page 1: Header and General Information
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 15, 'INFORME DE TERRENO', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(5);

        // General Info
        $html = '<table cellpadding="5" cellspacing="0" style="width:100%; border:1px solid #000;">
            <tr style="background-color:#f0f0f0;">
                <td style="width:50%; border:1px solid #000;"><strong>Mes/Año del Informe:</strong></td>
                <td style="width:50%; border:1px solid #000;">' . htmlspecialchars($form['mes_anio']) . '</td>
            </tr>
            <tr>
                <td style="width:50%; border:1px solid #000;"><strong>Código del Informe:</strong></td>
                <td style="width:50%; border:1px solid #000;">' . htmlspecialchars($form['codigo']) . '</td>
            </tr>
            <tr style="background-color:#f0f0f0;">
                <td style="width:50%; border:1px solid #000;"><strong>Fecha de Emisión:</strong></td>
                <td style="width:50%; border:1px solid #000;">' . htmlspecialchars($form['fecha_emision']) . '</td>
            </tr>
            <tr>
                <td style="width:50%; border:1px solid #000;"><strong>Temperatura Primera Muestra:</strong></td>
                <td style="width:50%; border:1px solid #000;">' . htmlspecialchars($form['temp_muestra']) . ' °C</td>
            </tr>
        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Page 2: Measurements
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'RESULTADOS DE MEDICIONES IN SITU', 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->Ln(5);

        // Build measurements table
        $grouped = [];
        foreach ($measurements as $m) {
            if (!isset($grouped[$m['row_id']])) {
                $grouped[$m['row_id']] = [];
            }
            $grouped[$m['row_id']][$m['field_id']] = $m['value'];
        }

        $html = '<table cellpadding="4" cellspacing="0" style="width:100%; border:1px solid #000; font-size:9px;">
            <tr style="background-color:#667eea; color:white;">
                <th style="border:1px solid #000; text-align:center;"><strong>Estación</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>Fecha</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>Hora</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>Temp (°C)</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>Conduc. (μS/cm)</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>Oxi Dis. (mg/L)</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>pH</strong></th>
                <th style="border:1px solid #000; text-align:center;"><strong>Salinidad (PSU)</strong></th>
            </tr>';

        $stationLabels = ['eaa' => 'E AA', 'edes' => 'E DES', 'epta' => 'E PTA', 'eaab' => 'E AAB'];
        $fields = ['fecha', 'hora', 'temp', 'conduc', 'oxigeno', 'ph', 'sal'];
        $rowCounter = 0;

        foreach ($grouped as $rowId => $rowData) {
            $bgColor = ($rowCounter % 2 == 0) ? '#f9f9f9' : '#ffffff';
            $html .= '<tr style="background-color:' . $bgColor . ';">';
            $html .= '<td style="border:1px solid #000; text-align:center;"><strong>' . ($stationLabels[$rowId] ?? $rowId) . '</strong></td>';

            foreach ($fields as $field) {
                $html .= '<td style="border:1px solid #000; text-align:center;">' . htmlspecialchars($rowData[$field] ?? '') . '</td>';
            }

            $html .= '</tr>';
            $rowCounter++;
        }

        $html .= '</table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        // Page 3: Observations
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'OBSERVACIONES', 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(5);

        $observaciones = $form['observaciones'] ?? 'Sin observaciones';
        $pdf->MultiCell(0, 5, nl2br(htmlspecialchars($observaciones)), 1, 'L');

        // Page 4: Images
        if (!empty($images)) {
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'ARCHIVOS ADJUNTOS', 0, 1, 'L');
            $pdf->Ln(5);

            $imageCounter = 0;
            foreach ($images as $image) {
                if (file_exists($image['image_path'])) {
                    if ($imageCounter > 0 && $imageCounter % 2 == 0) {
                        $pdf->AddPage();
                        $pdf->SetFont('helvetica', 'B', 12);
                        $pdf->Cell(0, 10, 'ARCHIVOS ADJUNTOS (continuación)', 0, 1, 'L');
                        $pdf->Ln(5);
                    }

                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->Cell(0, 5, 'Archivo: ' . htmlspecialchars($image['field_id']), 0, 1);
                    $pdf->Ln(2);

                    $y = $pdf->GetY();
                    $pdf->Image($image['image_path'], 20, $y, 170);
                    $pdf->Ln(85);

                    $imageCounter++;
                }
            }
        }

        // Output PDF
        $filename = 'Informe_' . preg_replace('/[^a-zA-Z0-9]/', '_', $form['codigo']) . '_' . date('YmdHis') . '.pdf';
        $pdf->Output($filename, 'D');
        exit;
    }
}
?>
