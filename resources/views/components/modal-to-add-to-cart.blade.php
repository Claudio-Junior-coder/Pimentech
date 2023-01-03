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
                <div class="d-flex justify-content-between">
                    <p><b>Preço (unit.):</b> R$: <span id="priceProduct"></span></p>
                    <p><b>Peso:</b> <span id="weightProduct"></span> Kg</p>
                </div>

                <p>Indique a quantidade:</p>
                <input type="number" class="form-control" min="0" id="qntd-budget" placeholder="Quantidade">
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

                $('.msg').html('');

                let maxQntd = $(this).attr('data-qnt');
                let nameProduct = $(this).attr('data-name');
                let weightProduct = $(this).attr('data-weight');
                let priceProduct = $(this).attr('data-price');
                idProduct = $(this).attr('data-id');

                $('#qntd-budget').attr('max', maxQntd)
                $('#nameProduct').text(nameProduct);
                $('#weightProduct').text(weightProduct);
                $('#priceProduct').text(priceProduct);
                $('#add-to-cart').modal('show');

            })

            $('body').on('click', '.add-cart', function (e) {

                var items = JSON.parse(localStorage.getItem("items"));
                let itemsId = [idProduct];
                let itemsName = [$('#nameProduct').text()];
                let itemsQnt = [$('#qntd-budget').val()];
                let itemsWeight = [$('#weightProduct').text()];
                let itemsPrice = [$('#priceProduct').text().replace('.', '').replace(',', '.')];
                let itemPriceTotal = [(parseFloat(itemsPrice[0]) * itemsQnt).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })];
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
                        weight: itemsWeight[index_value],
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
