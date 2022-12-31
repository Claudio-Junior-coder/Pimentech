<div class="modal" tabindex="-1" role="dialog" id="confirmToLowStock">
    <form action="{{ route('budgets.low.stock')}}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Atenção</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="id-to-low-stock" type="hidden" name="id">
            </div>
            <div class="modal-body">
            <p>Tem certeza que deseja dar baixa no estoque sobre os produtos desse orçamento ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-warning">Sim</button>
            </div>
        </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        $(document).ready(function () {
                $('#confirmToLowStock').modal('hide');

                $('body').on('click', '.low-in-stock', function (e) {
                    let idToLowStock = $(this).data('id');
                    $('#id-to-low-stock').val(idToLowStock);
                    $('#confirmToLowStock').modal('show');
                })
            });
    </script>
@endpush
