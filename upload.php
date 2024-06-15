<?php
session_start();

if (isset($_POST['upload'])) {
    // Pasta onde os uploads serão armazenados
    $uploadsDir = 'uploads/';

    // Verifica se a pasta existe, se não, cria a pasta
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    // Tipos de arquivos permitidos (imagens e vídeos)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/webm'];

    // Obtém informações do arquivo enviado
    $file = $_FILES['file'];
    $description = $_POST['description'];

    // Função para sanitizar o nome do arquivo
    function sanitizeFileName($filename) {
        // Remove caracteres especiais e espaços, substitui por underscore
        $filename = preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $filename);
        return $filename;
    }

    // Verifica se o tipo do arquivo é permitido
    if (in_array($file['type'], $allowedTypes)) {
        // Obtém a extensão do arquivo
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Sanitiza o nome do arquivo original
        $originalFileName = pathinfo($file['name'], PATHINFO_FILENAME);
        $sanitizedFileName = sanitizeFileName($originalFileName);

        // Gera um nome único para o arquivo
        $uniqueFileName = uniqid() . '_' . $sanitizedFileName . '.' . $extension;
        $filePath = $uploadsDir . $uniqueFileName;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Armazena as informações do upload em um arquivo JSON
            $uploadsListFile = 'uploads.json';
            $uploadsList = json_decode(file_get_contents($uploadsListFile), true);

            $newUpload = [
                'filename' => $uniqueFileName,
                'description' => htmlspecialchars($description),
                'original_name' => htmlspecialchars($file['name']),
                'type' => $file['type']
            ];

            $uploadsList[] = $newUpload;
            file_put_contents($uploadsListFile, json_encode($uploadsList));

            // Define a mensagem de sucesso na sessão
            $_SESSION['success_message'] = 'Arquivo enviado com sucesso!';
            
            // Redireciona para evitar o reenvio do formulário
            header('Location: index.html');
            exit();
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Tipo de arquivo não permitido.";
    }
}
?>
