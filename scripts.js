$(document).ready(function() {
    $('#uploadForm').submit(function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        // Exibe a mensagem de carregamento
        $('#loadingMessage').fadeIn();

        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                // Oculta a mensagem de carregamento
                $('#loadingMessage').fadeOut();

                // Exibe a mensagem de sucesso
                $('#successMessage').fadeIn().delay(3000).fadeOut('slow');

                // Limpa o formulário após o upload
                $('#uploadForm')[0].reset();
                // Atualiza a lista de uploads
                updateUploadsList();
            },
            error: function() {
                // Oculta a mensagem de carregamento
                $('#loadingMessage').fadeOut();

                // Exibe uma mensagem de erro
                $('#errorMessage').fadeIn().delay(3000).fadeOut('slow');
            }
        });
    });

    // Função para carregar os uploads existentes ao carregar a página
    updateUploadsList();

    function updateUploadsList() {
        $.getJSON('uploads.json', function(data) {
            $('#uploadsList').empty(); // Limpa a lista antes de atualizar

            $.each(data, function(index, upload) {
                var item = $('<div class="upload-item">');

                // Verifica se é uma imagem ou vídeo para exibir corretamente
                if (upload.type.startsWith('image')) {
                    $('<img>').attr('src', 'uploads/' + upload.filename).attr('alt', upload.description).appendTo(item);
                } else if (upload.type.startsWith('video')) {
                    $('<video controls>').attr('src', 'uploads/' + upload.filename).appendTo(item);
                }

                $('<p>').text(upload.description).appendTo(item);
                item.appendTo('#uploadsList');
            });
        }).fail(function() {
            console.log("Erro ao carregar o uploads.json.");
        });
    }
});


