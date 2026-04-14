<!-- =========================================================
     PAGINA DE PAGAMENTO
     Interface final do checkout com metodos de pagamento
     e resumo do pedido antes da confirmacao.
     ========================================================= -->
<!-- compras-pagamento.php -->

<?php
        session_start();
        require_once __DIR__ . '/../includes/carrinho.php'; //ir buscar os dados guardados no carrinho
        require_once __DIR__ . '/../vendor/autoload.php';

        /*Buscar os itens que estão no carrinho usando a função criada no includes/carrinho.php */
        $itensCart = dd_carrinho_get();

        /* Adicionar e implementar chave secreta facultado pelo site stripe.com */
        $stripe_secret_key = "";

        \Stripe\Stripe::setApiKey($stripe_secret_key);

        /* Criar um array para posicionar todos os itens inseridos pelo cliente */
        $lineitems = [];

        foreach($itensCart as $item){
            $descricao = ''; /* Criar variável que escreve todos os detalhes do bolo (tamanho, massa, recheio, etc) */
            $descricao .= ' | Tamanho: ' . $item['tamanho_label']; //todos estes dados vêm da page compras.php
            if (!empty($item['massa_label'])): 
            $descricao .= ' | Massa: ' . $item['massa_label'];
            endif;
            if (!empty($item['recheio_label'])): 
            $descricao .= ' | Recheio: ' . $item['recheio_label'];
            endif; 
            $descricao .= ' | Evento: ' . $item['data_evento'];
        

        //O stripe obriga a converter o preço em cêntimos
        $precoUnitario = (float)$item['preco_unitario'];
        $iva = $precoUnitario * 0.23;
        $precoComIva = $precoUnitario + $iva;
        $precoCentimos = (int) round(($precoUnitario + $iva) * 100);

        /* Meter os itens que estão a ser comprados usando o array $lineitems[] */
        $lineitems[] = [
            'quantity'   => (int)($item['quantidade']),

            'price_data' => [
            'currency'     => 'eur',
            'unit_amount'  => $precoCentimos,

            'product_data' => [
                'name'        => $item['nome'],
                'description' => $descricao,
            ],
        ],
    ];
};
//O loop do foreach só é fechado aqui caso tenha que se somar o valor de mais que um item 

        try {
        //Criar session para ser implementada no Stripe com todos os itens acumulados
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment", //Meter modo de pagamento no Stripe
            "success_url" => "http://localhost/PAP/actions/compras-sucesso.php", //Caso o pagamento seja bem sucedido redirecionar para a página de sucesso
            "cancel_url" => "http://localhost/PAP/pages/compras-finalizar.php", //Caso contrário irá voltar à pagina inicial do site
            "locale" => "pt", //Traduzir toda a página de pagamento para português 
            "line_items" => $lineitems, //Usar os itens postos dentro do array
            "customer_email" => $_SESSION['user'] ?? null, 

        ]);

        http_response_code(303); //Usar esta porta 303 serve para redirecionar o pedido para o stripe Checkout
        header("Location: " . $checkout_session->url);

        } catch (Exception $e) {
            echo "Erro ao comunicar com Stripe: " . $e->getMessage();
        }
        ?>
