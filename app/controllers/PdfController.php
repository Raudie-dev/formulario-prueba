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

        // Render view HTML to string
        $candidates = [
            VIEWS_PATH . 'pdf/template-view.php',
            ROOT_PATH . 'app/view/pdf/template-view.php',
            ROOT_PATH . 'view/pdf/template-view.php'
        ];
        $viewPath = null;
        foreach ($candidates as $cand) {
            if (file_exists($cand)) { $viewPath = $cand; break; }
        }

        if (!$viewPath) {
            // Log the attempted paths for debugging
            error_log('PdfController::generate - template not found. Tried: ' . implode(';', $candidates));
            // Fallback: generate basic PDF content if view is missing
            $html = '<h1>Informe</h1><p>Plantilla de PDF no encontrada. Rutas intentadas: ' . htmlspecialchars(implode(', ', $candidates)) . '</p>';
        } else {
            ob_start();
            // Variables disponibles en la vista
            $username = $this->getCurrentUsername();
            $BASE_URL = BASE_URL;
            $form = $form; // mantener nombre
            $measurements = $measurements;
            $images = $images;
            // Preparar attachments (anexos) y rutas de logo
            $attachments = [];
            foreach ($images as $img) {
                $fid = $img['field_id'] ?? '';
                if (stripos($fid, 'anexo') === 0) {
                    // preferir web_path si existe, sino usar image_path
                    $a = $img['web_path'] ?? $img['image_path'] ?? '';
                    if ($a) $attachments[] = $a;
                }
            }

            // Logo paths
            $logo_fs = ROOT_PATH . 'public/img/logo.jpeg';
            $logo_web = rtrim(BASE_URL, '/') . '/public/img/logo.jpeg';
            $antecendentes = rtrim(BASE_URL, '/') . '/public/img/antecedentes.jpg';
            include $viewPath;
            $html = ob_get_clean();
        }

        $filename = 'Informe_' . preg_replace('/[^a-zA-Z0-9]/', '_', $form['codigo']) . '_' . date('YmdHis') . '.pdf';

        // Preparar HTML para PDF: si las <img> tienen atributo data-pdf-src (ruta en servidor),
        // reemplazamos el src por esa ruta para que TCPDF/FPDI lean la imagen desde disco.
        $html_for_pdf = $html;
        $html_for_pdf = preg_replace_callback('/<img\b([^>]*)>/i', function($m) {
            $attrs = $m[1];
            $pdfSrc = '';
            if (preg_match('/data-pdf-src=["\']([^"\']+)["\']/', $attrs, $a)) {
                $pdfSrc = $a[1];
            }
            // eliminar el atributo data-pdf-src de los atributos visibles
            $attrs = preg_replace('/\s*data-pdf-src=["\'][^"\']+["\']/', '', $attrs);
            if ($pdfSrc) {
                // reemplazar o añadir src con la ruta al archivo
                if (preg_match('/src=["\']([^"\']*)["\']/', $attrs)) {
                    $attrs = preg_replace('/src=["\']([^"\']*)["\']/', 'src="' . htmlspecialchars($pdfSrc, ENT_QUOTES) . '"', $attrs);
                } else {
                    $attrs .= ' src="' . htmlspecialchars($pdfSrc, ENT_QUOTES) . '"';
                }
            }
            return '<img' . $attrs . '>';
        }, $html_for_pdf);

        // If FPDI is available, import the PDF template and write the HTML over it
        if (class_exists('\setasign\Fpdi\Tcpdf\Fpdi') || class_exists('\setasign\Fpdi\Fpdi')) {
            // Use FPDI bridge for TCPDF if available
            if (class_exists('\setasign\Fpdi\Tcpdf\Fpdi')) {
                $pdf = new \setasign\Fpdi\Tcpdf\Fpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            } else {
                // older FPDI versions
                $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');
            }

            $pdf->SetAutoPageBreak(true, 10);
            $pdf->SetFont('helvetica', '', 10);

            $templatePath = ROOT_PATH . 'public/pdf/PLANTILLA IA  COORDILLERA.pdf';
            if (file_exists($templatePath)) {
                $pageCount = 0;
                try {
                    $pageCount = $pdf->setSourceFile($templatePath);
                } catch (Exception $e) {
                    $pageCount = 0;
                }

                if ($pageCount > 0) {
                    // Import first page as base
                    $tplId = $pdf->importPage(1);
                    $size = $pdf->getTemplateSize($tplId);
                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($tplId);

                    // Write HTML content on top of the template
                    $pdf->SetXY(10, 10);
                    $pdf->writeHTML($html_for_pdf, true, false, true, false, '');

                } else {
                    // couldn't import template: fallback to plain TCPDF
                    $pdf->AddPage();
                    $pdf->writeHTML($html_for_pdf, true, false, true, false, '');
                }
            } else {
                // template absent -> plain HTML to PDF
                $pdf->AddPage();
                $pdf->writeHTML($html_for_pdf, true, false, true, false, '');
            }

            // Añadir numeración "Página X de Y" en cada página (bottom-right)
            $pageCount = $pdf->getNumPages();
            for ($p = 1; $p <= $pageCount; $p++) {
                $pdf->setPage($p);
                $pdf->SetFont('helvetica', '', 9);
                $pdf->SetY($pdf->getPageHeight() - 15);
                $pdf->Cell(0, 10, 'Página ' . $p . ' de ' . $pageCount, 0, 0, 'R');
            }

            // Output inline in browser
            $pdf->Output($filename, 'I');
            exit;
        }

        // FPDI not available: fallback to TCPDF-only HTML conversion (no PDF template import)
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->AddPage();
        $pdf->writeHTML($html_for_pdf, true, false, true, false, '');
        // Añadir numeración "Página X de Y"
        $pageCount = $pdf->getNumPages();
        for ($p = 1; $p <= $pageCount; $p++) {
            $pdf->setPage($p);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->SetY($pdf->getPageHeight() - 15);
            $pdf->Cell(0, 10, 'Página ' . $p . ' de ' . $pageCount, 0, 0, 'R');
        }

        $pdf->Output($filename, 'I');
        exit;
    }
}
?>
