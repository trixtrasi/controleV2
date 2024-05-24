<div class="col-md-8 mt-3 bg-white">
    <h1>Visitas Encerradas</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="tabelaSSP">
            <thead class="bg-danger text-white">
                <tr style="text-transform: capitalize;">
                    <th>visualizar</th>
                    <th>nome</th>
                    <th>veículo</th>
                    <th>entrada</th>
                    <th>saída</th>
                    <th>excluir</th>
                </tr>
            </thead>
            <tbody id="tabela_corpo"></tbody>
        </table>
    </div>
</div>
<script>
    $('#tabelaSSP').DataTable({
        ajax: 'public/visitas/ssp/encerrado_ssp.php',
        processing: true,
        serverSide: true,
        order: [
            [4, "desc"]
        ],
        columnDefs: [{
            targets: [6, 7, 8],
            visible: false
        }],
        language: {
            "url": "plugins/dataTables/js/ptbr.json"
        },
    });
</script>