<?php
require_once ROOT_PATH . 'app/models/Form.php';

class DashboardController extends Controller {
    private $formModel;

    public function __construct() {
        $this->requireLogin();
        $this->formModel = new Form();
    }

    public function index() {
        $userId = $this->getCurrentUserId();
        $forms = $this->formModel->getUserForms($userId);
        
        $this->view('dashboard/index', [
            'forms' => $forms,
            'username' => $this->getCurrentUsername()
        ]);
    }

    public function newForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $this->getCurrentUserId();
            
            $formData = [
                'mes_anio' => $_POST['mes_anio'] ?? '',
                'codigo' => $_POST['codigo'] ?? '',
                'fecha_emision' => $_POST['fecha_emision'] ?? '',
                'temp_muestra' => $_POST['temp_muestra'] ?? '',
                'observaciones' => $_POST['observaciones'] ?? ''
            ];

            $measurements = [];
            $measurementRows = ['eaa', 'edes', 'epta', 'eaab'];
            $measurementFields = ['fecha', 'hora', 'temp', 'conduc', 'oxigeno', 'ph', 'sal'];

            foreach ($measurementRows as $row) {
                foreach ($measurementFields as $field) {
                    $key = "${row}_${field}";
                    if (isset($_POST[$key])) {
                        $measurements[] = [
                            'row_id' => $row,
                            'field_id' => $field,
                            'value' => $_POST[$key]
                        ];
                    }
                }
            }

            $images = [];
            $imageFields = ['img_registro1', 'img_registro2', 'anexo1', 'anexo2', 'anexo3', 'anexo4'];

            foreach ($imageFields as $field) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = ROOT_PATH . 'uploads/forms/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $fileName = uniqid() . '_' . basename($_FILES[$field]['name']);
                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES[$field]['tmp_name'], $filePath)) {
                        $images[] = [
                            'field_id' => $field,
                            'image_path' => $filePath
                        ];
                    }
                }
            }

            $formId = $this->formModel->createForm($userId, $formData, $measurements, $images);

            if ($formId) {
                $_SESSION['success_message'] = 'Formulario creado exitosamente';
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            } else {
                $_SESSION['error_message'] = 'Error al crear el formulario';
            }
        }

        $this->view('dashboard/new-form', ['username' => $this->getCurrentUsername()]);
    }

    // Renamed from `view` to `show` to avoid conflict with Controller::view()
    public function show($formId) {
        $userId = $this->getCurrentUserId();
        $form = $this->formModel->getFormById($formId, $userId);

        if (!$form) {
            $_SESSION['error_message'] = 'Formulario no encontrado';
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $measurements = $this->formModel->getFormMeasurements($formId);
        $images = $this->formModel->getFormImages($formId);

        // Convert filesystem image paths to web-accessible URLs (mantener image_path para uso en servidor/PDF)
        foreach ($images as &$img) {
            if (!empty($img['image_path'])) {
                // Reemplazar ROOT_PATH por BASE_URL para obtener la URL pública
                $img['web_path'] = str_replace(ROOT_PATH, BASE_URL, $img['image_path']);
            }
        }
        unset($img);

        // Llamada al método heredado Controller::view() para cargar la plantilla
        $this->view('dashboard/view-form', [
            'form' => $form,
            'measurements' => $measurements,
            'images' => $images,
            'username' => $this->getCurrentUsername()
        ]);
    }

    public function delete($formId) {
        $userId = $this->getCurrentUserId();

        if ($this->formModel->deleteForm($formId, $userId)) {
            $_SESSION['success_message'] = 'Formulario eliminado exitosamente';
        } else {
            $_SESSION['error_message'] = 'Error al eliminar el formulario';
        }

        header('Location: ' . BASE_URL . 'dashboard');
        exit;
    }
}
?>
