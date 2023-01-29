
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
        data: { product_id: product_id, provider_price: 0, budget_price: 0, budget_sale_price: 0, other_taxes: 0, shipping_price: 0, cost_price: 0, profit_price: 0 },
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

    //get field values
    let productPrice = $('input[name=provider_price-' + id + ']').val().replace('.', '');
    let otherTaxes = parseFloat($('input[name=other_taxes-' + id + ']').val().replace(',', '.')) + 100;
    let taxesPrice = parseFloat($('input[name=budget_price-' + id + ']').val().replace(',', '.')) + 100;
    let shippingPrice = parseFloat($('input[name=shipping_price-' + id + ']').val().replace(',', '.')) + 100;
    let costPrice = 0;

    if(productPrice != 0) {
        productPrice = productPrice.replace(',', '.');
    }

    //check if field is empty
    if (Number(productPrice) !== Number(productPrice)){
        productPrice = 0;
    }

    if (Number(otherTaxes) !== Number(otherTaxes)){
        otherTaxes = 100;
    }

    if (Number(taxesPrice) !== Number(taxesPrice)){
        taxesPrice = 100;
    }

    if (Number(shippingPrice) !== Number(shippingPrice)){
        shippingPrice = 100;
    }

    //calculate
    let productWithOtherTaxes = productPrice * (otherTaxes / 100);
    let productWithTaxes = productWithOtherTaxes * (taxesPrice / 100);
    costPrice = productWithTaxes * (shippingPrice / 100);

    if(costPrice == 0) {
        costPrice = productPrice;
    }

    $('input[name=cost_price-' + id + ']').val(costPrice.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }))

    let product_id = $('.add-sbr-fields').attr('data-productId');

    editSbr(id, 'cost_price', $('input[name=cost_price-' + id + ']').val(), product_id, $('input[name=cost_price-' + id + ']'));
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

    let checkObs = data.obs == undefined ? "" : data.obs;
    $(".sbr-form").append(`
        <div class="sbr-big-screen row mb-3" id="v`+ data.id + `">
            <div class="form-group col">
                <label>Fornecedor</label>
                <select name="provider_id-`+ data.id + `" class="form-control edit-sbr" data-name="provider_id" data-id="` + data.id + `">
                    `+ selectHtml + `
                </select>
            </div>
            <div class="form-group col">
                <label>Custo</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input autocomplete="off" data-id="`+ data.id + `" data-name="provider_price" type="tel" name="provider_price-` + data.id + `" onkeypress="$(this).mask('#.##0,00', {reverse: true});" class="calculate-cost-price  form-control edit-sbr" placeholder="Valor (unit.)" value="` + data.provider_price + `">
                </div>
            </div>
            <div class="form-group col">
                <label for="date">Data</label>
                <input autocomplete="off" data-id="`+ data.id + `" data-name="provider_date" type="date" name="provider_date-` + data.id + `" class="form-control edit-sbr" value="` + data.provider_date + `">
            </div>
            <div class="form-group col">
                <label>Outros</label>
                <div class="input-group">
                    <input autocomplete="off" type="number" name="other_taxes-`+ data.id + `" data-id="` + data.id + `" data-name="other_taxes" value="` + data.other_taxes + `" class="calculate-cost-price form-control edit-sbr" placeholder="Valor (unit.)">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>ST</label>
                <div class="input-group">
                    <input autocomplete="off" type="number" name="budget_price-`+ data.id + `" data-id="` + data.id + `" data-name="budget_price" value="` + data.budget_price + `" class="calculate-cost-price form-control edit-sbr" placeholder="Valor (unit.)">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Frete</label>
                <div class="input-group">
                    <input autocomplete="off" type="number" name="shipping_price-`+ data.id + `" data-id="` + data.id + `" data-name="shipping_price" value="` + data.shipping_price + `" class="calculate-cost-price form-control edit-sbr" placeholder="Valor (unit.)">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Custo Final</label>
                <input autocomplete="off" type="text" name="cost_price-`+ data.id + `" data-id="` + data.id + `" data-name="cost_price" value="` + data.cost_price + `" class="form-control edit-sbr" placeholder="Valor (unit.)" disabled>
            </div>
            <div class="form-group col">
                <label for="date">Data</label>
                <input autocomplete="off" type="date" name="budget_date-`+ data.id + `" data-id="` + data.id + `" data-name="budget_date" value="` + data.budget_date + `" class="form-control edit-sbr">
            </div>
            <div class="form-group col">
                <label>Obs</label>
                <input autocomplete="off" type="text" name="obs-`+ data.id + `" class="form-control edit-sbr" data-name="obs" data-id="` + data.id + `" value="` + checkObs + `">
            </div>

            <div class="form-group col mt-4">
                <button type="button" class="btn btn-outline-danger" onclick="removeSbr(`+ data.id + `);"><i class="fa fa-minus-circle"></i></button>
            </div>
        </div>
        <hr class="hr-`+ data.id + `" />
    `);
}
