<div class="modal" tabindex="-1" role="dialog" id="add-to-cart">

        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-cart-plus"></i> Adicionar este produto ao orçamento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="add-cart-product-id" type="hidden" name="id">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p><b>Descritivo:</b> <span id="nameProduct"></span></p>
                        <p><b>Peso:</b> <span id="weightProduct"></span></p>
                        <p><b>Unid:</b> <span id="unProduct"></span></p>

                        <p>Selecione o <b>SBR</b> e indique a quantidade desejada:</p>
                    </div>
                    <div class="col-12 mt-3">
                        <select class="form-control calculate-profit-percentage" name="sbr-selected" id="sbr-selected">

                        </select>
                    </div>
                    <div class="col">
                        <label for="">Qntd:</label>
                        <input type="number" class="form-control calculate-profit-percentage" min="0" id="qntd-budget" placeholder="Quantidade">
                    </div>
                    <div class="col">
                        <label for="">Lucro (%):</label>
                        <div class="input-group">
                            <input type="number" id="profitVal" class="form-control calculate-profit-percentage" placeholder="Valor (unit.)">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Total (Unit):</label>
                        <input type="text" class="form-control" min="0" data-value="0" id="resultUnit" disabled>
                    </div>
                    <div class="col">
                        <label for="">Total:</label>
                        <input type="text" class="form-control" min="0" data-value="0" id="result" disabled>
                    </div>
                    <br>
                </div>
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

            $('body').on('change', '.calculate-profit-percentage', function (e) {
                let id = $(this).attr('id');
                calculatePriceToSale(id);
            })

            function calculatePriceToSale(id) {

                //get field values
                let costPrice = $('#sbr-selected').val().replace('R$', '').replace('.', '').replace(',', '.');
                let profitVal = parseFloat($('#profitVal').val().replace(',', '.')) + 100;
                let qntdSelected = $('#qntd-budget').val() == '' ? '0' : $('#qntd-budget').val();
                let salePriceUnit = 0;
                let salePrice = 0;


                //check if field is empty
                if (Number(qntdSelected) !== Number(qntdSelected)){
                    qntdSelected = 0;
                }

                if (Number(profitVal) !== Number(profitVal)){
                    profitVal = 100;
                }

                console.log(costPrice)
                console.log(profitVal)
                console.log(qntdSelected)
                //calculate
                let productWithProfit = costPrice * (profitVal / 100);

                salePriceUnit = productWithProfit;
                salePrice = productWithProfit * qntdSelected;

                if(salePrice == 0) {
                    salePrice = costPrice;
                }

                if(salePriceUnit == 0) {
                    salePriceUnit = costPrice;
                }

                $('#resultUnit').attr('data-value', salePriceUnit)
                $('#resultUnit').val(parseFloat(salePriceUnit).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }))

                $('#result').attr('data-value', salePrice)
                $('#result').val(parseFloat(salePrice).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }))

            }

            $('body').on('click', '.add-to-cart', function (e) {

                $('#sbr-selected').html('<option value="" selected>--- SELECIONE UM SBR ---</option>');
                $('.msg').html('');
                $('#qntd-budget').val('');
                $('#profitVal').val('');
                $('#result').val('');
                $('#result').data('value', '');
                $('#resultUnit').val('');
                $('#resultUnit').data('value', '');

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
                                    <option value="`+ element.cost_price +`">Fornecedor: `+ element.provider_name[0].name +` | Preço de Custo: `+ element.cost_price +`</option>
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
                let itemsPrice = [$('#resultUnit').val()];
                let itemPriceTotal = [$('#result').val()];
                $('.msg').html('');

                if(itemsQnt <= 0) {
                    $('.msg').html(`
                        <div class="alert alert-warning" role="alert">
                            A quantidade precisa ser informada.
                        </div>
                    `);
                    return false;
                }

                if( $('#profitVal').val().length <= 0 ) {
                    $('.msg').html(`
                        <div class="alert alert-warning" role="alert">
                            A porcetagem de lucro precisa ser informada.
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
