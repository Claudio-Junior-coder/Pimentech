<div class="modal" tabindex="-1" role="dialog" id="add-to-cart">

        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-cart-plus"></i> Adicionar este produto ao carrinho</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="add-cart-product-id" type="hidden" name="id">
            </div>
            <div class="modal-body">
                <p><b>Descritivo:</b> <span id="nameProduct"></span></p>
                <p><b>Peso:</b> <span id="weightProduct"></span></p>
                <p><b>Unid:</b> <span id="unProduct"></span></p>

                <p>Indique a quantidade e selecione o <b>SBR</b> desejado:</p>
                <input type="number" class="form-control" min="0" id="qntd-budget" placeholder="Quantidade">
                <br>
                <select class="form-control" name="sbr-selected" id="sbr-selected">

                </select>
                <div class="msg mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success add-cart">Adicionar</button>
            </div>
        </div>
        </div>

</div>

@push('js')
    <script>
        $(document).ready(function () {
            let idProduct = false;

            $('#add-to-cart').modal('hide');

            $('body').on('click', '.add-to-cart', function (e) {

                $('#sbr-selected').html('');
                $('.msg').html('');

                let maxQntd = $(this).attr('data-qnt');
                let nameProduct = $(this).attr('data-name');
                let weightProduct = $(this).attr('data-weight');
                let unProduct = $(this).attr('data-un');
                idProduct = $(this).attr('data-id');

                $('#qntd-budget').attr('max', maxQntd)
                $('#nameProduct').text(nameProduct);
                $('#weightProduct').text(weightProduct);
                $('#unProduct').text(unProduct);
                $('#add-to-cart').modal('show');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "/sbr/get/by/product/" + idProduct,
                    success: function (data) {
                        data.forEach(function (element) {
                            if(element.provider_name != undefined) {
                                $('#sbr-selected').append(`
                                    <option value="`+ element.budget_sale_price +`">Fornecedor: `+ element.provider_name[0].name +` | Preço de Venda: `+ element.budget_sale_price +`</option>
                                `);
                            }
                        })

                    }
                });

            })

            $('body').on('click', '.add-cart', function (e) {

                var items = JSON.parse(localStorage.getItem("items"));
                let itemsId = [idProduct];
                let itemsName = [$('#nameProduct').text()];
                let itemsUn = [$('#unProduct').text()];
                let itemsQnt = [$('#qntd-budget').val()];
                let itemPrice = $('#sbr-selected').val().replace('R$', '').replace('.', '').replace(',', '.');
                let itemsPrice = [$('#sbr-selected').val()];
                let itemPriceTotal = [(itemPrice * itemsQnt).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })];
                $('.msg').html('');

                if(itemsQnt <= 0) {
                    $('.msg').html(`
                        <div class="alert alert-warning" role="alert">
                            A quantidade precisa ser informada.
                        </div>
                    `);
                    return false;
                }

                //check if already exist item in cart
                //if exist just change quantity
                if(items != null) {

                    items.forEach((element, index) => {
                        if(element.id == itemsId) {
                            items.splice(index, 1);
                        }
                    });

                }

                //add new item in cart
                let items_details = itemsId.map((id, index_value) => {
                    return {
                        id: id,
                        name: itemsName[index_value],
                        qnt: itemsQnt[index_value],
                        price: itemsPrice[index_value],
                        um: itemsUn[index_value],
                        priceTotal: itemPriceTotal[index_value],
                    };
                });

                //keep current items in cart
                if(items != null) {

                    items.forEach(element => {
                        items_details.push(element);
                    });

                }

                localStorage.setItem("items", JSON.stringify(items_details));

                $('#add-to-cart').modal('hide');

            });
        });
    </script>
@endpush
