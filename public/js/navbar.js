/* 
ajax que controla o nav-bar e a navegação pelo sistema
monitora os botõs no nav-bar, quando o usuário clicar é 
feito a requisição ao arquivo correspondente e o corpo do arquivo é preenchido 
com a resposta. 
*/
// Declarando a função no escopo global
window.chamarProcessarLinkManual = function (dataFor) {
    processarLinkAjax(dataFor);
};


// Função para fazer a requisição AJAX
function fazerRequisicaoAjax(url, sucessoCallback, erroCallback) {
    $.ajax({
        url: url,
        type: 'POST',
        success: sucessoCallback,
        error: erroCallback
    });
}

// Função para processar e fazer a requisição AJAX
function processarLinkAjax(dataFor) {
    if (dataFor != null) {
        // Adiciona a classe 'active' ao label apropriado
        $('.link-ajax').removeClass('active');
        $('.link-ajax[data-for="' + dataFor + '"]').addClass('active');

        // Faz a requisição AJAX usando a função definida anteriormente
        fazerRequisicaoAjax(dataFor + '.php', function (data) {
            // Em caso de sucesso, atualize a div de conteúdo com os dados recuperados
            $('#mainContent').html(data);
        }, function (xhr, status, error) {
            // Trata erro, se houver algum
            console.error('Erro:', status, error);
        });
    }
}

$(document).ready(function () {
    // Manipulador de evento para os links .link-ajax
    $('.link-ajax').click(function (e) {
        // Obtém o atributo id do atributo for do label clicado
        var dataFor = $(this).attr('data-for');
        processarLinkAjax(dataFor);
    });

    // Função para atualizar o número de visitantes
    function atualizarNumeroUsuarios() {
        // Fazer uma requisição AJAX para obter o número atual de visitantes
        $.ajax({
            url: 'public/ajax/navbarSpan.php', // Arquivo PHP que retorna o número de visitantes
            type: 'POST',
            success: function (data) {
                // Atualizar o conteúdo do span com o número de visitantes retornado pela requisição
                $('#numeroUsuarios').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição: ' + status + ', ' + error);
            }
        });
    }

    // Chamar a função para atualizar o número de visitantes ao carregar o documento
    atualizarNumeroUsuarios();

    // Chamar a função para atualizar o número de visitantes a cada intervalo de tempo (por exemplo, a cada 5 segundos)
    setInterval(atualizarNumeroUsuarios, 5000); // 5000 milissegundos = 5 segundos
})