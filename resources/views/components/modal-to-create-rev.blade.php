<div class="modal" tabindex="-1" role="dialog" id="confirmCreateRev">
    <form action="{{ route('budgets.create.rev')}}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Atenção</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="id-to-create-rev" type="hidden" name="id">
            </div>
            <div class="modal-body">
            <p>Tem certeza que deseja criar uma revisão deste orçamento ?</p>
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
                $('#confirmCreateRev').modal('hide');

                $('body').on('click', '#create-rev', function (e) {
                    let idCreateRev = $(this).data('id');
                    $('#id-to-create-rev').val(idCreateRev);
                    $('#confirmCreateRev').modal('show');
                })
            });
    </script>
@endpush
