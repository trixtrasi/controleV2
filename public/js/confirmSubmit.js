//submit btn on datatables
function confirmSubmit(button) {
    var acao = button.getAttribute('data-acao');
    var id = button.getAttribute('data-id');

    // Acessando o texto dentro do botão
    var buttonText = button.innerText || button.textContent;

    // Confirmar a ação com o usuário
    var agree = confirm("Tem certeza que deseja " + buttonText + "?");

    if (agree) {
        // Construir os dados a serem enviados via AJAX
        var formData = {
            acao: acao,
            id: id
        };

        // Enviar os dados via AJAX
        $.ajax({
            type: 'POST',
            url: 'public/ajax/process_form.php',
            data: formData,
            success: function (response) {
                // Tentar converter a resposta JSON em um objeto JavaScript
                var jsonResponse = JSON.parse(response);

                // Recarregar os dados da tabela DataTables, se houver.
                $('#tabelaSSP').DataTable().ajax.reload(null, false);

                // Trate a resposta do servidor, se necessário
                alert(jsonResponse.message);
            },
            error: function (xhr, status, error) {
                // Trate erros de requisição, se necessário
                console.error(xhr.responseText);
            }
        });

        // Retorna true para enviar os dados via AJAX
        return true;
    } else {
        // Retorna false para cancelar o envio dos dados
        return false;
    }
}
