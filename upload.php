<?php
// Verifica se o formulário foi submetido
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

    // Verifica se o tipo do arquivo é permitido
    if (in_array($file['type'], $allowedTypes)) {
        // Gera um nome único para o arquivo
        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadsDir . $fileName;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Prepara os dados do upload para salvar
