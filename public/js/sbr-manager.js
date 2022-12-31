
getProvidersInfo();

let providersInfo = [];

function getProvidersInfo() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
    });
    $.ajax({
        type: 'GET',
        url: "/providers-info/listing",
        success: function (data) {
            providersInfo = data;
        }
    });

}

$('body').on('click', '.add-sbr-fields', function (e) {
    let product_id = $(this).attr('data-productId');
    createSbr(product_id);
})

$('body').on('change', '.edit-sbr', function (e) {
    let id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    let product_id = $('.add-sbr-fields').attr('data-productId');
    let val = $(this).val();
    editSbr(id, name, val, product_id, $(this));
})


$('body').on('change', '.calculate-cost-price', function (e) {
    let id = $(this).attr('data-id');
    calculateCostPrice(id)
})


function createSbr(product_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
    });
    $.ajax({
        type: 'POST',
        url: "/sbr/create",
        data: { product_id: product_id, provider_price: 0, budget_price: 0, budget_sale_price: 0, shipping_price: 0, cost_price: 0, profit_price: 0 },
        success: function (data) {
            addNewSbr(data);
        }
    });
}

function editSbr(id, name, val, product_id, element) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
    });
    $.ajax({
        type: 'POST',
        url: "/sbr/edit",
        data: { id: id, [name]: val, product_id: product_id },
        success: function (data) {
            element.css({ 'outline': '1px solid green' });
            setTimeout(function () {
                element.css({ 'outline': 'none' });
            }, 1000)
        }
    });
}

function removeSbr(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
    });
    $.ajax({
        type: 'POST',
        url: "/sbr/delete",
        data: { id: id },
        success: function (data) {
            $('.sbr-form #v' + id).remove();
            $('.hr-' + id).remove();
        }
    });
}


function calculateCostPrice(id) {
    let productPrice = $('input[name=provider_price-' + id + ']').val().replace('.', '');
    let taxesPrice = parseFloat($('input[name=budget_price-' + id + ']').val()) + 100;
    let shippingPrice = parseFloat($('input[name=shipping_price-' + id + ']').val()) + 100;
    let profitPrice = parseFloat($('input[name=profit_price-' + id + ']').val()) + 100;
    let costPrice = 0;

    productPrice = productPrice.replace(',', '.');
    let productWithTaxes = productPrice * (taxesPrice / 100);

    costPrice = productWithTaxes * (shippingPrice / 100);
    let salePrice = costPrice * (profitPrice / 100);

    $('input[name=cost_price-' + id + ']').val(costPrice.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }))
    $('input[name=budget_sale_price-' + id + ']').val(salePrice.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }))

    let product_id = $('.add-sbr-fields').attr('data-productId');

    editSbr(id, 'cost_price', $('input[name=cost_price-' + id + ']').val(), product_id, $('input[name=cost_price-' + id + ']'));
    editSbr(id, 'budget_sale_price', $('input[name=budget_sale_price-' + id + ']').val(), product_id, $('input[name=budget_sale_price-' + id + ']'));
}


function addNewSbr(data) {
    let selectHtml = '<option value="0">N/A</option>';

    providersInfo.forEach(function (element) {

        if (element.id == data.provider_id) {
            selectHtml += `
                <option value="${element.id}" selected>${element.name}</option>
            `;
        } else {
            selectHtml += `
                <option value="${element.id}">${element.name}</option>
            `;
        }
    });
    $(".sbr-form").append(`
        <div class="sbr-big-screen row mb-3" id="v`+ data.id + `">
            <div class="form-group col">
                <label>Fornecedor</label>
                <select name="provider_id-`+ data.id + `" class="form-control edit-sbr" data-name="provider_id" data-id="` + data.id + `">
                    `+ selectHtml + `
                </select>
            </div>
            <div class="form-group col">
                <label>Preço</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input data-id="`+ data.id + `" data-name="provider_price" type="text" name="provider_price-` + data.id + `" onkeypress="$(this).mask('#.##0,00', {reverse: true});" class="calculate-cost-price  form-control edit-sbr" placeholder="Valor (unit.)" value="` + data.provider_price + `">
                </div>
            </div>
            <div class="form-group col">
                <label for="date">Data</label>
                <input data-id="`+ data.id + `" data-name="provider_date" type="date" name="provider_date-` + data.id + `" class="form-control edit-sbr" value="` + data.provider_date + `">
            </div>
            <div class="form-group col">
                <label>Impostos</label>
                <div class="input-group">
                    <input type="text" name="budget_price-`+ data.id + `" data-id="` + data.id + `" data-name="budget_price" value="` + data.budget_price + `" class="calculate-cost-price form-control edit-sbr" placeholder="Valor (unit.)">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Frete</label>
                <div class="input-group">
                    <input type="text" name="shipping_price-`+ data.id + `" data-id="` + data.id + `" data-name="shipping_price" value="` + data.shipping_price + `" class="calculate-cost-price form-control edit-sbr" placeholder="Valor (unit.)">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Custo</label>
                <input type="text" name="cost_price-`+ data.id + `" data-id="` + data.id + `" data-name="cost_price" value="` + data.cost_price + `" class="form-control edit-sbr" placeholder="Valor (unit.)" disabled>
            </div>
            <div class="form-group col">
                <label>Lucro</label>
                <div class="input-group">
                    <input type="text" name="profit_price-`+ data.id + `" data-id="` + data.id + `" data-name="profit_price" value="` + data.profit_price + `" class="calculate-cost-price form-control edit-sbr" placeholder="Valor (unit.)">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Venda</label>
                <input type="text" name="budget_sale_price-`+ data.id + `" data-id="` + data.id + `" data-name="budget_sale_price" value="` + data.budget_sale_price + `" class="form-control edit-sbr" placeholder="Valor (unit.)" disabled>
            </div>
            <div class="form-group col">
                <label for="date">Data</label>
                <input type="date" name="budget_date-`+ data.id + `" data-id="` + data.id + `" data-name="budget_date" value="` + data.budget_date + `" class="form-control edit-sbr">
            </div>

            <div class="form-group col mt-4">
                <button type="button" class="btn btn-outline-danger" onclick="removeSbr(`+ data.id + `);"><i class="fa fa-minus-circle"></i></button>
            </div>
        </div>
        <hr class="hr-`+ data.id + `" />
    `);
}
