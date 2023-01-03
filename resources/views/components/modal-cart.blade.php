<div class="modal" tabindex="-1" role="dialog" id="open-cart">

        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-cart-plus"></i> Carrinho</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="add-cart-product-id" type="hidden" name="id">
            </div>
            <div class="modal-body">
                <p>Abaixo está a listagem de todos os itens selecionados para orçamento:</p>
                <div>
                    <table class="table cart-table" style="width:100%">


                        <thead class="table-head">
                            <tr>
                                <th scope="col">Itens</th>
                                <th scope="col">Descritivo</th>
                                <th scope="col">Peso (unit.)</th>
                                <th scope="col">Valor (unit.)</th>
                                <th scope="col">Qntd</th>
                                <th scope="col">Total</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>


                        <tbody id="items-cart">

                        </tbody>


                    </table>
                </div>
                <div id="customer-info">
                    <input class="form-control border border-danger" type="text" placeholder="Nome do cliente" id="customer-name">
                </div>
                <div id="msg-cart" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <div id="resume">

                </div>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success init-budget">Criar Orçamento</button>
                <button type="button" class="btn btn-success add-budget" id="create-budget">Finalizar</button>
            </div>
        </div>
        </div>

</div>

    <script>
        $(document).ready(function () {

            $('#open-cart').modal('hide');
            $('#customer-info').hide();
            $('#create-budget').hide();

            function initCart() {
                let total = 0;
                let totalWeight = 0;
                let items = JSON.parse(localStorage.getItem("items"));

                $('#open-cart').modal('show');
                $('#items-cart').html('');
                $('#msg-cart').html('');

                if(items == null || items.length == 0) {
                    $('#msg-cart').html(`
                        <div class="alert alert-light" role="alert">
                            O carrinho está vazio.
                        </div>
                    `);
                    return false;
                }

                items.forEach((element, i) => {
                    //if(element.name.length > 35) element.name = element.name.substring(0,35) + '...';
                    $('#items-cart').append(`
                        <tr id="item-`+ element.id +`">
                            <td>`+ i + 1 +`</td>
                            <td>`+ element.name +`</td>
                            <td>`+ element.weight +` Kg</td>
                            <td>R$: `+ element.price +`</td>
                            <td>`+ element.qnt +`</td>
                            <td>`+ element.priceTotal +`</td>
                            <td><a class="ml-2 remove-from-cart" data-id="`+ element.id +`" role="button" style="color: #C82333;"><i class="fas fa-minus-circle"></i></a></td>
                        </tr>
                    `);

                    total += parseFloat(element.priceTotal.replace('R$', '').replace('.', '').replace(',', '.'));
                    totalWeight += parseFloat(element.weight);
                });

                $('#resume').html(`<h4 class="mr-3">Peso Total: <span id="totalWeight">`+ totalWeight +` Kg</span> | Total: <span id="totalValue">`+ total.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }) +`</span></h4>`);
            }

            $('body').on('click', '.open-cart', function (e) {

                initCart();

            })

            $('body').on('click', '.init-budget', function (e) {

                let items = JSON.parse(localStorage.getItem("items"));

                if(items == null || items.length == 0) {
                    $('#msg-cart').html(`
                        <div class="alert alert-warning" role="alert">
                            Adicione produtos ao carrinho para criar orçamento.
                        </div>
                    `);
                    return false;
                }

                $('.init-budget').hide();
                $('#customer-info').show();
                $('#create-budget').show();
            })

            $('body').on('click', '.remove-from-cart', function (e) {

                let items = JSON.parse(localStorage.getItem("items"));

                let itemId = $(this).attr('data-id');

                if(items != null) {

                    items.forEach((element, index) => {
                        if(element.id == itemId) {
                            items.splice(index, 1);
                            $('#items-cart #item-' + itemId).remove();
                        }
                    });

                }

                localStorage.setItem("items", JSON.stringify(items));

                initCart();
            });

            $('body').on('click', '.add-budget', function (e) {

                $('#msg-cart').html('');

                if($("#customer-name").val() == "") {
                    $('#msg-cart').html(`
                        <div class="alert alert-warning" role="alert">
                            O nome do cliente precisa ser informado.
                        </div>
                    `);
                    return false;
                }

                let items = localStorage.getItem("items");

                if(items != null) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name=_token]').val()
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "/budgets/create",
                        data: { data: items, customer_name: $("#customer-name").val(), total: $("#totalValue").text(), total_weight: $("#totalWeight").text()},
                        dataType: 'json',
                        success: function (data) {
                            localStorage.removeItem('items');
                            window.location="/budgets/view/" + data.id;
                        }
                    });
                }

            });

        });
    </script>

