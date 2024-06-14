$(document).ready(function() {
    $('#uploadForm').submit(function(event) {
        event.preventDefault(); // Previne o envio do formulário para fins de demonstração
        $('#customAlert').fadeIn();

        // Simula um tempo de upload antes de enviar o formulário
        setTimeout(function() {
            $('#customAlert').fadeOut();
            $('#uploadForm')[0].submit(); // Envia o formulário
        }, 3000); // Alerta será exibido por 3 segundos
    });
});
