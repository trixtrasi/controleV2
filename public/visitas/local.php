<div class="col-md-8 mt-3 bg-white">
    <h1>Visitantes no Local</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover display" id="tabelaSSP">
            <thead class="table-dark">
                <tr style="text-transform: capitalize;">
                    <th>visualizar</th>
                    <th>nome</th>
                    <th>veículo</th>
                    <th>entrada</th>
                    <th>encerrar visita</th>
                </tr>
            </thead>
            <tbody id="tabela_corpo"></tbody>
        </table>
    </div>
</div>


<script>
    $('#tabelaSSP').DataTable({
        ajax: 'public/visitas/ssp/local_ssp.php',
        processing: true,
        serverSide: true,
        order: [3, "desc"],
        columnDefs:[{
            targets:[5,6,7,8],
            visible: false
        }],
        language: {
            "url": "plugins/dataTables/js/ptbr.json"
        },
    });
</script>