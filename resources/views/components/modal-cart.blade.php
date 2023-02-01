<div class="modal" tabindex="-1" role="dialog" id="open-cart">

        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-cart-plus"></i> Carrinho</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input id="add-cart-product-id" type="hidden" name="id">
            <input id="add-cart-customer-id" type="hidden" name="customer_id">
            <input id="add-cart-budget-id" type="hidden" name="budget_id">
            </div>
            <div class="modal-body">
                <p>Adicionar itens a um:</p>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="thereOrNotBudget" id="newBudget" checked>
                        <label class="form-check-label" for="newBudget">
                          Novo orçamento
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="thereOrNotBudget" id="thereBudget">
                        <label class="form-check-label" for="thereBudget">
                          Orçamento existente
                        </label>
                      </div>
                </div>
                <p>Abaixo está a listagem de todos os itens selecionados para orçamento:</p>
                <div>
                    <table class="table cart-table" style="width:100%">


                        <thead class="table-head">
                            <tr>
                                <th scope="col">Descritivo</th>
                                <th scope="col">Valor (unit.)</th>
                                <th scope="col">Unid</th>
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
                    <input class="form-control border border-danger" autocomplete="off" type="text" placeholder="Nome do cliente" id="customer-name">
                    <div id="resultsSearch">

                    </div>
                </div>
                <div id="budget-info">
                    <input class="form-control border border-danger" autocomplete="off" type="text" placeholder="Número do orçamento" id="budget-code">
                    <div id="resultsBudgetSearch">

                    </div>
                </div>
                <div id="msg-cart" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <div id="resume">

                </div>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success init-budget">Criar Orçamento</button>
                <button type="button" class="btn btn-success add-new-budget" id="create-budget">Finalizar</button>
            </div>
        </div>
        </div>

</div>

    <script>
        $(document).ready(function () {

            $('#open-cart').modal('hide');
            $('#customer-info').hide();
            $('#create-budget').hide();
            $('#budget-info').hide();

            function initCart() {
                let total = 0;
                let items = JSON.parse(localStorage.getItem("items"));

                $('#open-cart').modal('show');
                $('#items-cart').html('');
                $('#msg-cart').html('');
                $('#resume').html('');

                if(items == null || items.length == 0) {
                    $('#msg-cart').html(`
                        <div class="alert alert-light" role="alert">
                            O carrinho está vazio.
                        </div>
                    `);
                    return false;
                }

                items.forEach(element => {
                    //if(element.name.length > 35) element.name = element.name.substring(0,35) + '...';
                    $('#items-cart').append(`
                        <tr id="item-`+ element.id +`">
                            <td>`+ element.name +`</td>
                            <td>`+ element.price +`</td>
                            <td>`+ element.um +`</td>
                            <td>`+ element.qnt +`</td>
                            <td>`+ element.priceTotal +`</td>
                            <td><a class="ml-2 remove-from-cart" data-id="`+ element.id +`" role="button" style="color: #C82333;"><i class="fas fa-minus-circle"></i></a></td>
                        </tr>
                    `);

                    total += parseFloat(element.priceTotal.replace('R$', '').replace('.', '').replace(',', '.'));
                });

                $('#resume').html(`<h4 class="mr-3">Total: <span id="totalValue">`+ total.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }) +`</span></h4>`);
            }

            $('body').on('click', '.open-cart', function (e) {

                initCart();

            })

            $('body').on('click', '[name="thereOrNotBudget"]', function (e) {
                $('.init-budget').show();
                $('#customer-info').hide();
                $('#create-budget').hide();
                $('#budget-info').hide();
            });

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
                $('#create-budget').show();

                if($('[name="thereOrNotBudget"]:checked').val() == 1) { //orçamento existente
                    $('#budget-info').show();
                    $('#create-budget').removeClass('add-new-budget');
                    $('#create-budget').addClass('add-budget');
                } else { //novo orçamento
                    $('#customer-info').show();
                    $('#create-budget').removeClass('add-budget');
                    $('#create-budget').addClass('add-new-budget');
                }
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

            var typingTimer;
            var doneTypingInterval = 1000;
            $('#customer-name').keyup(function(e) {
                clearTimeout(typingTimer);
                if ($('#customer-name').val) {
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                }
            })

            $('#budget-code').keyup(function(e) {
                clearTimeout(typingTimer);
                if ($('#budget-code').val) {
                    typingTimer = setTimeout(doneTypingBudget, doneTypingInterval);
                }
            })

            function doneTyping() {
                $.ajax({
                    url: "/customers/search?search=" + $('#customer-name').val(),
                    type: "GET",
                    success: function (response) {

                        $('#resultsSearch').html(``);
                        if(response == undefined ) {

                            let template =`
                                <div>
                                    <a style="color: black;" href="#">
                                        Nenhum resultado encontrado.
                                    </a>
                                </div>`;
                            $("#resultsSearch").append(template);
                            return false;
                        }
                        $.each(response, function (key, item) {
                            let template =`
                                <div class="mb-3">
                                    <a class="item-search bg-info p-2" href="#" data-id="`+ item.id +`">` + item.name + `</a>
                                </div>`;
                            $("#resultsSearch").append(template);
                        });

                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);
                    }
                });
            }

            function doneTypingBudget() {
                $.ajax({
                    url: "/budgets/search?search=" + $('#budget-code').val(),
                    type: "GET",
                    success: function (response) {

                        $('#resultsBudgetSearch').html(``);
                        if(response == undefined ) {

                            let template =`
                                <div>
                                    <a style="color: black;" href="#">
                                        Nenhum resultado encontrado.
                                    </a>
                                </div>`;
                            $("#resultsBudgetSearch").append(template);
                            return false;
                        }
                        $.each(response, function (key, item) {
                            let template =`
                                <div class="mb-3">
                                    <a class="item-budget-search bg-info p-2" href="#" data-id="`+ item.id +`">` + item.number + `</a>
                                </div>`;
                            $("#resultsBudgetSearch").append(template);
                        });

                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);
                    }
                });
            }

            $('body').on('click', '.item-search', function (e) {
                $('#resultsSearch').html(``);
                $('#customer-name').val($(this).text())
                $('#add-cart-customer-id').val($(this).data('id'));
            });

            $('body').on('click', '.item-budget-search', function (e) {
                $('#resultsBudgetSearch').html(``);
                $('#budget-code').val($(this).text())
                $('#add-cart-budget-id').val($(this).data('id'));
            });


            $('body').on('click', '.add-new-budget', function (e) {

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
                        data: { data: items, customer_id: $("#add-cart-customer-id").val(), total: $("#totalValue").text() },
                        dataType: 'json',
                        success: function (data) {
                            localStorage.removeItem('items');
                            window.location="/budgets/view/" + data.id;
                        }
                    });
                }

            });

            $('body').on('click', '.add-budget', function (e) {

                $('#msg-cart').html('');

                if($("#budget-code").val() == "") {
                    $('#msg-cart').html(`
                        <div class="alert alert-warning" role="alert">
                            O número do orçamento precisa ser informado.
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
                        url: "/budgets/items/add",
                        data: { data: items, budget_id: $("#add-cart-budget-id").val(), total: $("#totalValue").text() },
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

