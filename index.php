<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Upload de Imagens e Vídeos</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Upload de Imagens e Vídeos</h1>
    <form id="uploadForm" action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept="image/*,video/*" required>
        <textarea name="description" placeholder="Descrição do arquivo" required></textarea>
        <button type="submit" name="upload">Enviar</button>
    </form>
    <div id="uploadsList">
        <!-- Aqui serão listados os arquivos já carregados -->
    </div>
</div>
<script src="js/scripts.js"></script>
</body>
</html>

<?php include 'upload.php';?>
