<div class="col-md-8 mt-3 bg-white">
    <!-- EVENTOS DO DIA - TODO'S -->
    <div class="eventos-diarios">
        <h1>Programação para Hoje</h1>
        <div class="table-responsive">
            <table class="table table-striped table-hover display" id="tabelaSSP">
                <thead class="table-dark">
                    <tr>
                        <th>Data/Período</th>
                        <th>Evento</th>
                        <th>Por</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="row">
            <div class="col d-grid">
                <button class="btn btn-block btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEventos">Adicionar Evento</button>
            </div>
        </div>
        <div class="serverResponse"></div>
    </div>
    <!-- MODAL DE EVENTOS -->
    <div class="modal fade" id="modalEventos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalEventos" aria-hidden="true">
        <form class="formulario">
            <input type="text" name="acao" hidden='true' value='evento_cadastro'>

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="modalEventosTittle">Adicionar Evento</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="modalDataInicio">Data Início:<span class="required-text">*</span></label>
                                <input id="modalDataInicio" type="date" class="form-control" name="eventos__data_ini" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                            <div class="col">
                                <label for="modalDataFim">Data Fim:</label>
                                <input id="modalDataFim" type="date" class="form-control" name="eventos__data_fim">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="modalTexto">Texto:<span class="required-text">*</span></label>
                                <textarea id="modalTexto" rows="5" class="form-control" name="eventos__texto" maxlength="255" required></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button class="btn btn-primary botaoFormulario" onclick="submitThrouthAjax(this)" type="button">Cadastrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $('#tabelaSSP').DataTable({
            ajax: 'public/home/ssp/home_ssp.php',
            processing: true,
            serverSide: true,
            order: [0, "desc"],
            columnDefs: [{
                target: [4],
                visible: false
            }],
            language: {
                url: "plugins/dataTables/js/ptbr.json"
            },
        });
    </script>
</div>