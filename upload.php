<?php
// Verifica se o formulário foi submetido
if (isset($_POST['upload'])) {
    // Pasta onde os uploads serão armazenados
    $uploadsDir = 'uploads/';

    // Tipos de arquivos permitidos (imagens e vídeos)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/webm'];

    // Obtém informações do arquivo enviado
    $file = $_FILES['file'];
    $description = $_POST['description'];

    // Verifica se o tipo do arquivo é permitido
    if (in_array($file['type'], $allowedTypes)) {
        // Gera um nome único para o arquivo
        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadsDir . $fileName;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Prepara os dados do upload para salvar
            $uploadData = [
                'file' => $filePath,
                'description' => $description,
            ];

            // Caminho para o arquivo JSON onde os dados serão armazenados
            $jsonFile = 'uploads.json';
            $uploadsArray = [];

            // Verifica se o arquivo JSON já existe e carrega seu conteúdo se existir
            if (file_exists($jsonFile)) {
                $uploadsArray = json_decode(file_get_contents($jsonFile), true);
            }

            // Adiciona o novo upload ao array
            $uploadsArray[] = $uploadData;

            // Salva o array atualizado de uploads de volta no arquivo JSON
            file_put_contents($jsonFile, json_encode($uploadsArray));

            // Redireciona para evitar o reenvio do formulário
            header('Location: index.php');
            exit();
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Tipo de arquivo não permitido.";
    }
}
?>