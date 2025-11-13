<?php
class Form extends Model {
    public function createForm($userId, $data, $measurements = [], $images = []) {
        try {
            $formData = json_encode($data);
            
            $this->insert('forms', [
                'user_id' => $userId,
                'mes_anio' => $data['mes_anio'] ?? '',
                'codigo' => $data['codigo'] ?? '',
                'fecha_emision' => $data['fecha_emision'] ?? '',
                'temp_muestra' => $data['temp_muestra'] ?? '',
                'observaciones' => $data['observaciones'] ?? '',
                'data' => $formData
            ]);

            $formId = $this->db->lastInsertId();

            // Insert measurements
            foreach ($measurements as $measurement) {
                $this->insert('form_measurements', [
                    'form_id' => $formId,
                    'row_id' => $measurement['row_id'] ?? '',
                    'field_id' => $measurement['field_id'] ?? '',
                    'value' => $measurement['value'] ?? ''
                ]);
            }

            // Insert images
            foreach ($images as $image) {
                $this->insert('form_images', [
                    'form_id' => $formId,
                    'field_id' => $image['field_id'] ?? '',
                    'image_path' => $image['image_path'] ?? ''
                ]);
            }

            return $formId;
        } catch (Exception $e) {
            error_log("Error creating form: " . $e->getMessage());
            return false;
        }
    }

    public function getFormById($id, $userId = null) {
        $params = [$id];
        $sql = "SELECT * FROM forms WHERE id = ?";
        
        if ($userId !== null) {
            $sql .= " AND user_id = ?";
            $params[] = $userId;
        }

        return $this->fetch($sql, $params);
    }

    public function getUserForms($userId) {
        return $this->fetchAll(
            "SELECT * FROM forms WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
    }

    public function getFormMeasurements($formId) {
        return $this->fetchAll(
            "SELECT * FROM form_measurements WHERE form_id = ? ORDER BY row_id, field_id",
            [$formId]
        );
    }

    public function getFormImages($formId) {
        return $this->fetchAll(
            "SELECT * FROM form_images WHERE form_id = ? ORDER BY field_id",
            [$formId]
        );
    }

    public function updatePdfPath($formId, $pdfPath) {
        $this->update('forms', ['pdf_path' => $pdfPath], 'id = ?', [$formId]);
    }

    public function deleteForm($formId, $userId) {
        // Get form to find images
        $form = $this->getFormById($formId, $userId);
        if (!$form) return false;

        // Delete associated images from filesystem
        $images = $this->getFormImages($formId);
        foreach ($images as $image) {
            if (file_exists($image['image_path'])) {
                unlink($image['image_path']);
            }
        }

        // Delete from database
        $this->delete('forms', 'id = ? AND user_id = ?', [$formId, $userId]);
        return true;
    }
}
?>
