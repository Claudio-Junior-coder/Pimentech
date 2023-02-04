<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$fileName}}</title>
</head>

<body>
    <style>
        table {
            width: 100%;
        }

        .ordernumber p {
            padding-left: 10px;
        }

        .total {
            border: 1px solid #000;
            padding: 5px;
            text-align: right;
        }

        .items {
            font-size: 10px;
        }

        .customer-info {
            margin-bottom: 25px;
        }

        .customer-info td {
            padding: 0.5em;
        }
    </style>
    <div>

        <table border="1">

            <tbody>
              <!--   {{ asset('images/jr.png') }} -->
                <tr class="items">
                    <td><img src="#" width="80px"></td>
                    <td style="padding: 0 0 10px 15px;">
                        <h3>POLIHYDRO MATERIAIS HIDRAULICOS LTDA. </h3> <br>
                        <span><b>END:</b> AV. SENADOR CESAR LACERDA DE VERGUEIRO, N° 123, <br>
                        BAIRRO: JARDIM CÂNDIDA 13.603-013 - ARARAS / SP</span><br>
                        <span><b>FONE:</b> (19) 2184 0186 / (19) 99732 6839</span><br>
                        <span><b>CNPJ:</b> 36.957.136/0001-31</span><br>
                        <span><b>INSC.</b> EST: 182.244.131.114</span><br>
                        <span><b>INSC.</b> MUNIC: 40.410</span><br>
                        <span><b>E-MAIL:</b> polihydro@hotmail.com</span>
                    </td>
                    <td>
                        <div class="ordernumber">
                            <p><b>DATA: </b>{{date('d/m/Y')}}</p>
                            <p><b>Nº ORÇAMENTO: </b>{{$budget['number']}}</p>
                            <p><b>VALIDADE PROPOSTA: </b>5 DIAS</p>
                            <p><b>VENDEDOR: </b>{{$budget['user_name']}}</p>
                        </div>
                    </td>
                </tr>

            </tbody>

        </table>

        <div style="margin-bottom: -12px; font-size: 12px;">
            <h5>INFORMAÇÕES DO CLIENTE:</h5>
        </div>
        <table border="1" class="customer-info">

            <tbody>

                <tr class="items">
                    <td><b>NOME/RAZÃO SOCIAL:</b> {{$budget['customer_name']}}</td>
                    <td><b>FONE:</b> {{$budget['customer_phone']}}</td>
                    <td><b>A/C:</b> {{$budget['customer_a_c']}}</td>
                </tr>
                <tr class="items">
                    <td><b>CNPJ:</b> {{$budget['customer_cnpj']}}</td>
                    <td><b>CIDADE:</b> {{$budget['customer_city']}}</td>
                    <td><b>ESTADO:</b> {{$budget['customer_state']}}</td>
                </tr>
                <tr class="items">
                    <td><b>E-MAIL:</b> {{$budget['customer_email']}}</td>
                    <td><b>END. ENTREGA:</b> {{$budget['customer_address_to_shipping']}}</td>
                </tr>

            </tbody>

        </table>

        <table border="1" class="customer-info" style="margin-top: -15px;">

            <tbody>

                <tr class="items">
                    <td><b>COND. PAGAMENTO:</b> {{$budget['condition_payment']}}</td>
                    <td><b>PRAZO DE ENTREGA:</b> {{$budget['time']}}</td>
                </tr>
                <tr class="items">
                    <td><b>INSPEÇÃO:</b> {{$budget['inspection']}}</td>
                    <td><b>END. DE ENTREGA:</b> {{$budget['address_to_shipping']}}</td>
                </tr>

            </tbody>

        </table>

        <div class="total" style="font-size: 12px;">
            <span>TOTAL DO PEDIDO: <b>{{$budget['total']}}</b>  @if(!empty($budget['price_in_string'])) | {{$budget['price_in_string']}} @endif</span>
        </div>


        <table border="1">

            <thead class="table-head">
                <tr class="items">
                    <th>Itens</th>
                    <th>Descritivo</th>
                    <th>Qntd</th>
                    <th>Unid</th>
                    <th>Valor (unit.)</th>
                    <th>Total</th>
                </tr>
            </thead>


            <tbody>
                @foreach($budgetItems as $k => $item)
                <tr class="items">
                    <td style="text-align: center;">{{$k + 1}}</td>
                    <td>{{$item->product_name}}</td>
                    <td style="text-align: center;">{{$item->quantity}}</td>
                    <td style="text-align: center;">{{$item->um}}</td>
                    <td style="text-align: center;">{{$item->price}}</td>
                    <td style="text-align: center;">{{$item->total_price}}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <p style="font-size: 8px; margin-top: 50px;">O MATERIAL OFERTADO ATENDE TODAS AS NORMAS TECNICAS VIGÊNTE DA ABNT E NBR.
            VERIFICAR SE AS DESCRIÇÕES NO PRODUTO ESTÃO DE ACORDO COM O ESPECIFICADO NA CONFIRMAÇÃO DO PEDIDO;
            REALIZAR UMA INSPEÇÃO EXAUSTIVA E COMPLETA DOS PRODUTOS E, EM CASO DE DETECÇÃO DE ALGUMA ANOMALIA VISÍVEL OU APARENTE, DEVERÁ INDICÁ-LA E ASSINALÁNO RELATÓRIO DE
            INSPEÇÃO, BEM COMO NA NOTA FISCAL/FATURA. QUALQUER RECLAMAÇÃO À POSTERIORI RELATIVAMENTE AO ASPETO VISUAL DO PRODUTO NÃO SERÁ ACEITO.
            PRAZO DE ENTREGA INFORMADO NA PROPOSTA DE ACORDO COM A DISPONIBILIDADE DO ESTOQUE.- LIBERAÇÃO DE FATURAMENTO A PRAZO: SUJEITO À ANÁLISE DE CRÉDITO.
            NÃO ACEITAMOS DEVOLUÇÃO E/OU CANCELAMENTO DE TUBO (S) FLANGEADO (S) FABRICADO (S) SOB MEDIDA.
            O "VENDEDOR" TEM O DIREITO DE DEFINIR E ALTERAR, A QUALQUER MOMENTO, OS PREÇOS DOS PRODUTOS PARA VENDA. PODERÁ TAMBÉM, ANTES DA ENTREGA/RETIRADA, ALTERAR OS PREÇOS EM
            VIRTUDE DE ALTERAÇÕES A TAXAS E IMPOSTOS APLICÁVEIS À VENDA DOS PRODUTOS. NESTE CASO, O "CLIENTE" SERÁ NOTIFICADO COM O NOVO PREÇO E CONDIÇÕES DE PAGAMENTO, E TEM A
            FACULDADE DE DESISTIR DO PEDIDO, SE LHE CONVIER, NUM PRAZO DE 7 DIAS SEGUINTES À NOTIFICAÇÃO. CASO O "CLIENTE" NÃO EXERÇA O SEU DIREITO NO DECURSO DESTE PRAZO, AS NOVAS
            CONDIÇÕES SÃO CONSIDERADAS COMO ACEITAS PELO MESMO E APLICAM-SE À TRANSAÇÃO COMERCIAL EM QUESTÃO
            SE O PAGAMENTO NÃO OCORRER NA DATA ACORDADA, SEM PREJUÍZO DE OUTROS DIREITOS DO #VENDEDOR”, INCIDIRÃO MULTA MORATÓRIA DE 10% (DEZ PORCENTO), ALÉM DE JUROS DE MORA DE
            1% (UM POR CENTO) EM VIGOR AO MÊS, OU MAIOR VALOR PERMITIDO PELA LEGISLAÇÃO BEM COMO CORREÇÃO MONETÁRIA CUJA ATUALIZAÇÃO SERÁ FEITA PELA VARIAÇÃO POSITIVA DO ÍNDICE IGPM/FGV (OU OUTRO QUE O VENHA A SUBSTITUIR), AMBOS CALCULADOS PRO RATA DIE, DESDE A DATA DO VENCIMENTO ATÉ A DATA DO EFETIVO PAGAMENTO DO PRINCIPAL ACRESCIDO DOS
            ENCARGOS, INDEPENDENTEMENTE DE AVISO PRÉVIO, SEM PREJUÍZO TAMBÉM DO DIREITO DO #VENDEDOR” DE SUSPENDER A EXECUÇÃO DO PEDIDO. ALÉM DISSO, EM CASO DE ATRASO NO
            PAGAMENTO DE QUALQUER PARCELA VENCIDA, TODAS AS PARCELAS VENCIDAS QUE O #CLIENTE” DEVA AO #VENDEDOR”, POR QUALQUER MOTIVO, SERÃO CONSIDERADAS VENCIDAS
            ANTECIPADAMENTE.</p>

            <p>_______________________________</p>
            <p style="font-size: 12px;">POLIHYDRO MATERIAIS HIDRAULICOS
                <br> CNPJ: 36.957.136/0001-31</p>
    </div>

</body>

</html>
