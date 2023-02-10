<div class="modal" tabindex="-1" role="dialog" id="confirmToDeleteCompany">
    <form action="{{ route('companies.delete')}}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Atenção</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="id-to-delete" type="hidden" name="id">
            </div>
            <div class="modal-body">
            <p>Tem certeza que deseja excluir a empresa: <strong id="name-to-delete"></strong> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-danger">Excluir</button>
            </div>
        </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        $(document).ready(function () {
                $('#confirmToDeleteCompany').modal('hide');

                $('body').on('click', '.delete-company', function (e) {
                    let idToDelete = $(this).data('id');
                    let nameToDelete = $(this).data('name');
                    $('#name-to-delete').text(nameToDelete);
                    $('#id-to-delete').val(idToDelete);
                    $('#confirmToDeleteCompany').modal('show');
                })
            });
    </script>
@endpush
