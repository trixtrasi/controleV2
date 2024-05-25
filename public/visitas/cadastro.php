<?php
include "../../connect.php";
include "../../auth/session/index.php";
// Verifica se existe algum visitante abandonado
$sql_abandonado = "SELECT * FROM `visitantes` WHERE `visitantes__status` = 66 AND `visitantes__create_by` = '$id_user'";
$query_abandonado = mysqli_query($conn, $sql_abandonado);

if (mysqli_num_rows($query_abandonado) > 0) {
    $visitantePre = mysqli_fetch_assoc($query_abandonado);
    $visitantePre__id = $visitantePre["visitantes__id"];
} else {
    // Insere um novo visitante com status 66 se não houver um pre cadastro
    $sql_pre_abandono = "INSERT INTO `visitantes` (`visitantes__status`, `visitantes__create_by`) VALUES (66, $id_user)";
    $query_pre_abandono = mysqli_query($conn, $sql_pre_abandono);

    if ($query_pre_abandono) {
        $lastInsertedId = mysqli_insert_id($conn);
        $visitantePre__id = $lastInsertedId;
    } else {
        echo "Erro ao pré cadastrar visitante. Contate o suporte!";
    }
}
?>
<div class="col-lg-8 mt-3 bg-white">
    <form class="formulário" id="visitanteForm" enctype="multipart/form-data">
        <div class="d-none">
            <input name="acao" value="visitante_cadastrar" readonly="true" hidden="true">
            <input name="visitantes__id" id="idVisitante" value="<?php echo $visitantePre__id; ?>" readonly="true" hidden="true">
        </div>
        <div class="row justify-content-between">
            <h1>Cadastro de Visitante</h1>
            <!--COLUNA FOTO-->
            <div class="col-md-3">
                <p class="mb-0">Foto do Visitante:</p>
                <label class="input-group-text bg-transparent d-flex justify-content-center" for="files">
                    <img id='imagePreview' src="public/img/png/add-user.png" alt="foto do visitante" class="img-fluid">
                </label>
                <input id='url_foto' name='url_foto' type='text' hidden value="">
                <div class="input-group d-none">
                    <input name='foto_visitante' accept="image/*" type="file" id="files" class="form-control">
                </div>
            </div>
            <!--COLUNA DADOS PESSOAIS-->
            <div class="col-md-9">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="visitante_nome">Nome Completo:<span class="required-text">*</span></label>
                        <input id="visitante_nome" name="visitante_nome" type="text" class="form-control" placeholder="Nome Completo" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 mb-0" id="genero_group">
                        <label class="mb-0" for="genero">Gênero:<span class="required-text">*</span></label><br>
                        <div class="form-check form-check-inline my-1">
                            <input class="form-check-input" id="generoMasculino" type="radio" name="genero" value="Masculino" required>
                            <label class="form-check-label" for="generoMasculino">- Masculino</label>
                        </div>
                        <div class="form-check form-check-inline my-1">
                            <input class="form-check-input" id="generoFeminino" type="radio" name="genero" value="Feminino">
                            <label class="form-check-label" for="generoFeminino">- Feminino</label>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-6">
                        <label for="documentoTipo">Documento<span class="required-text">*</span></label>
                        <input class="form-control" name="tipoDocumento" id="documentoTipo" required value="RG" readonly>
                    </div>
                    <div class="col-6">
                        <label for="documentoNumero">Número do RG: <span class="required-text">*</span></label>
                        <input name="numeroDocumento" id="numeroDocumento" type="text" placeholder="Número" class="form-control" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label type="text">Data de Nascimento:</label>
                        <input name="aniversario" id="aniversario" type="date" class="form-control" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="visitante_telefone">Telefone:</label>
                        <input class="form-control phone_with_ddd" name="telefone" type="text" placeholder="Telefone" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="endereco">Endereço Completo:</label>
                        <input type="text" class="form-control" placeholder="Endereço Completo do Visitante. Rua dos pássaros, n°1. Bairro Alto - Curitiba" name="endereco" value="">
                    </div>
                </div>
            </div>
        </div>
        <!--MOTIVO / PM RESPONSÁVEL PELO VISITANTE-->
        <div class="row my-4 pt-4 border-top">
            <div class="form-group col-md-12">
                <label for="pm_acompanhate">Responsável pelo visitante:</label>
                <input id="pm_responsavel" name="pm_acompanhate" type="text" class="form-control" placeholder="Pessoa que guiará o visitante" value="">
            </div>
            <div class="form-group col-md-12">
                <label for="visitante_motivo">Motivo da Visita:</label>
                <textarea id="visitante_motivo" name="visitante_motivo" class="form-control" placeholder="Motivo da Visita" rows="4"></textarea>
            </div>
        </div>

        <!--VEICULO DO VISITANTE-->
        <div class="row my-4">
            <h3>Veículo</h3>
            <div class="form-group col-md-4">
                <label for="veiculo_placa">Placa:</label>
                <input id="veiculo_placa" name="veiculo_placa" type="text" class="form-control" placeholder="Placa" value="">
            </div>
            <div class="form-group col-md-4">
                <label for="veiculo_marca">Marca:</label>
                <input id="veiculo_marca" name="veiculo_marca" type="text" class="form-control" placeholder="Marca" value="">
            </div>
            <div class="form-group col-md-4">
                <label for="veiculo_modelo">Modelo:</label>
                <input id="veiculo_modelo" name="veiculo_modelo" type="text" class="form-control" placeholder="Modelo" value="">
            </div>
        </div>

        <!--OBS GERAIS-->
        <div class="row my-4">
            <h3>Outros</h3>
            <div class="form-group col-md-12">
                <label for="obs_adiconais">Obeservações:</label>
                <textarea id="obs_adiconais" name="obs_adiconais" type="text" class="form-control" placeholder="Obeservações" rows="4"></textarea>
            </div>
        </div>
        <div class="row my-3">
            <div class="form-group d-grid gap-2 col-md-12">
                <button class="btn btn-primary btn-block botaoFormulario" onclick="submitThrouthAjax(this)" type="button">ENVIAR</button>
            </div>
        </div>
        <div class="serverResponse"></div>
    </form>
</div>
<script>
</script>
<!--MODAL DE PESQUISA-->
<div class="modal fade" id="modalCadastroVisitas" tabindex="-1" data-bs-show="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalCadastroVisitas">
    <form class="formulario" id="pesquisaForm">
        <input type="text" name="acao" value="pesquisaVisitante" hidden>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-tittle" id="modalCadastroVisitasTittle">Pesquisar por Visitante</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row my-3">
                        <div class="col-12 d-none">
                            <label for="documentoTipo">RG:<span class="required-text">*</span></label>
                            <input name="tipoDocumento" class="form-control" id="documentoTipo" required value="RG">
                        </div>
                        <div class="col-12">
                            <label for="documentoNumero">Número do RG: <span class="required-text">*</span></label>
                            <input name="numeroDocumento" type="text" placeholder="Número" class="form-control" value="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Pesquisar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Quando o arquivo de imagem for selecionado
        $('#files').change(function() {
            var fileInput = this;
            var src = URL.createObjectURL(fileInput.files[0]);
            var formData = new FormData(); // Cria um objeto FormData
            var serverResponse = $('.serverResponse');

            // Adiciona o arquivo de imagem ao FormData
            formData.append('foto_visitante', fileInput.files[0]);

            // Adiciona mais uma variável ao FormData
            formData.append('acao', 'salvaFotos');
            formData.append('visitantes__id', $("input[name='visitantes__id']").val());

            // Faz uma requisição AJAX para enviar o arquivo de imagem junto com a outra variável
            $.ajax({
                url: 'public/ajax/process_form.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, // Não processa os dados
                contentType: false, // Não define o tipo de conteúdo
                success: function(response) {
                    try {
                        var jsonResponse;
                        if (typeof response === 'string') {
                            // Tentar converter a resposta JSON em um objeto JavaScript
                            jsonResponse = JSON.parse(response);
                        } else {
                            // Se a resposta já for um objeto JavaScript, use-a diretamente
                            jsonResponse = response;
                        }

                        // Exibir a mensagem na div de resposta

                        // Tratar a resposta do servidor
                        if (jsonResponse.status === 'success') {
                            //mostra a foto enviada
                            document.getElementById('imagePreview').src = src;
                            document.getElementById('imagePreview').style.display = 'block';
                            document.getElementById('url_foto').value = jsonResponse.url;
                        } else if (jsonResponse.status === 'error') {
                            // Processo em caso de erro
                            alert('Erro ao enviar a foto: ' + jsonResponse.message);
                            // Exibir mensagem de erro
                        } else {
                            // Processo para outros tipos de resposta
                            alert('Resposta inesperada:', jsonResponse);
                        }
                    } catch (error) {
                        // Se houver um erro ao tentar analisar a resposta JSON
                        console.error('Erro ao analisar resposta JSON:', error);
                        console.log('Resposta do servidor:', response); // Adiciona um log da resposta do servidor para depuração
                    }
                }
            });
        });

        $('#pesquisaForm').submit(function(event) {
            event.preventDefault(); // Evita que o formulário seja enviado normalmente

            // Faz uma requisição AJAX para obter os dados do visitante
            $.ajax({
                url: 'public/ajax/process_form.php',
                type: 'POST',
                data: $(this).serialize(), // Serializa os dados do formulário de pesquisa
                dataType: 'json',
                success: function(response) {

                    if (response.status === 'success') {
                        // Verifica se há pelo menos um visitante na resposta
                        if (response.visitantes.length > 0) {
                            // Preenche os campos do formulário de visitante com os dados do primeiro visitante encontrado
                            var visitante = response.visitantes[0]; // Obtemos o primeiro visitante da lista
                            $("input[name='visitantes__id']").val(visitante.visitantes__id);
                            $("#imagePreview").attr("src", visitante.visitas__img_url);
                            $("#url_foto").val(visitante.visitas__img_url);

                            if (visitante.visitantes__genero === 'Masculino') {
                                $('#generoMasculino').prop('checked', true);
                            } else if (visitante.visitantes__genero === 'Feminino') {
                                $('#generoFeminino').prop('checked', true);
                            }
                            $('#documentoTipo').val(visitante.visitantes__tipo_doc);
                            $('#numeroDocumento').val(visitante.visitantes__num_doc);
                            $('#visitante_nome').val(visitante.visitantes__nome);
                            $('#aniversario').val(visitante.visitantes__aniversario);
                            $("input[name='telefone']").val(visitante.visitantes__telefone);
                            $("input[name='endereco']").val(visitante.visitantes__endereco);
                            // Exibe o formulário de visitante
                            $('#visitanteForm').show();
                        }
                    } else {
                        $('#numeroDocumento').val(response.visitantes_doc);
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Erro ao buscar dados do visitante.');
                }
            });
        });

        $(document).ready(function() {
            $('.phone_with_ddd').mask('(00) 00000-0000');
            $("#modalCadastroVisitas").modal('show');
        });

        $("#modalCadastroVisitas").modal('show');
    });
</script>