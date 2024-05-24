//submit informações do formulário
function submitThrouthAjax(button) {
    var form = $(button).closest('form');
    var serverResponse = form.next('.serverResponse');

    // Função para validar os campos obrigatórios
    function validarCamposObrigatorios(form) {
        var camposObrigatorios = form.find('[required]');
        var camposVazios = [];

        camposObrigatorios.each(function () {
            var valor = $(this).val();
            if (valor.trim() === '') {
                camposVazios.push($(this).attr('name'));
            }
        });

        return camposVazios;
    }

    // Verificar se há campos obrigatórios vazios
    var camposVazios = validarCamposObrigatorios(form);

    if (camposVazios.length > 0) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        return; // Impede o envio do formulário se houver campos vazios
    }

    // cria um objeto formData
    var formData = new FormData(form[0]);

    // Armazenar uma referência ao formulário
    var formRef = form;

    // Enviar os dados via AJAX
    $.ajax({
        type: 'POST',
        url: 'public/ajax/process_form.php',
        data: formData,
        contentType: false, // Não definir o tipo de conteúdo
        processData: false, // Não processar os dados
        success: function (response) {
            try {
                // Tentar converter a resposta JSON em um objeto JavaScript
                var jsonResponse = JSON.parse(response);
                
                // Exibir a mensagem na div de resposta
                serverResponse.html(jsonResponse.message);

                // Tratar a resposta do servidor
                if (jsonResponse.status == 'success') {
                    // Limpa os campos do formulário usando a referência armazenada
                    formRef.trigger('reset');

                    // Recarregar os dados da tabela DataTables, se houver.
                    $('#tabelaSSP').DataTable().ajax.reload(null, false);
                    if (jsonResponse.action == "refresh") {
                        location.reload();
                    } else if (jsonResponse.action == "changeHeader") {
                        // Faz a requisição manualmente e muda a padina
                        chamarProcessarLinkManual('public/visitas/local') ;
                    }
                } else if (jsonResponse.status == 'error') {
                    // Processo em caso de erro
                    alert('Erro ao enviar o formulário: ' + response);
                    // Exibir mensagem de erro
                } else {
                    // Processo para outros tipos de resposta
                    console.log('Resposta inesperada:', jsonResponse);
                }
            } catch (error) {
                // Se houver um erro ao tentar analisar a resposta JSON
                console.error('Erro ao analisar resposta JSON:', error);
            }
        }
    });
}

//visualizar os dados do visitante
function visualizarModal(button) {
    var visitante_id = button.getAttribute('data-visitante-id');
    var visita_id = button.getAttribute('data-visita-id');
    var acao = button.getAttribute('data-acao');

    // Construir os dados a serem enviados via AJAX
    var formData = {
        acao: acao,
        visita_id: visita_id,
        visitante_id: visitante_id
    };

    // Enviar os dados via AJAX
    $.ajax({
        type: 'POST',
        url: 'public/visitas/visualizar.php',
        data: formData,
        success: function (data) {
            // On success, update the content div with the retrieved data
            $('#mainContent').html(data);
        },
        error: function (xhr, status, error) {
            // Handle error if any
            console.error('Error:', status, error);
        }
    });
}