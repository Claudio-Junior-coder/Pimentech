<div class="modal" tabindex="-1" role="dialog" id="confirmToGeneratePDF">
    <form action="{{ route('budgets.create.pdf')}}" method="POST">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Gerar PDF</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="id-budget" type="hidden" name="id">
            </div>
            <div class="modal-body">
                <div class="form-row w-100">
                    <div class="form-group col-md-6">
                        <label for="condition_payment">COND. PAGAMENTO:</label>
                        <input class="form-control" name="condition_payment" id="condition_payment" placeholder="Condição de pagamento">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="time">PRAZO DE ENTREGA:</label>
                        <input class="form-control" name="time" id="time" placeholder="Prazo de entrega">
                    </div>
                </div>
                <div class="form-row w-100">
                    <div class="form-group col-md-6">
                        <label for="inspection">INSPEÇÃO:</label>
                        <input class="form-control" name="inspection" id="inspection" placeholder="Inspeção">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address_to_shipping">END. ENTREGA:</label>
                        <input class="form-control" name="address_to_shipping" id="address_to_shipping" placeholder="Endereço de entrega">
                    </div>
                </div>
                <div class="form-row w-100">
                    <div class="form-group col-md-12">
                        <label for="price_in_string">DESCREVER VALOR TOTAL:</label>
                        <input class="form-control" name="price_in_string" id="price_in_string" placeholder="Insira o valor total por escrito">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Gerar</button>
            </div>
        </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        $(document).ready(function () {
                $('#confirmToGeneratePDF').modal('hide');

                $('body').on('click', '.generate-pdf', function (e) {
                    let idBudget = $(this).data('id');
                    $('#id-budget').val(idBudget);
                    $('#confirmToGeneratePDF').modal('show');
                })
            });
    </script>
@endpush
