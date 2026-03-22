<?php
// ============================================================
// FICHEIRO: actions/adicionar_carrinho_cupcakes.php
// O QUE FAZ: Recebe o formulário de encomenda de cupcakes
// (via POST), valida os dados, calcula o preço, e adiciona
// ao carrinho guardado na sessão do utilizador.
//
// DIFERENÇA em relação aos bolos normais:
//   - Não tem massa nem recheio (só quantidade/pack e data)
//   - O catálogo dos cupcakes está definido aqui diretamente
// ============================================================

require_once __DIR__ . '/../includes/carrinho.php';

dd_start_session();

// --- CATÁLOGO DE CUPCAKES ---
// Definido aqui porque os cupcakes não estão no catálogo
// principal de bolos (carrinho.php).
$catalogoCupcakes = [
    'bolachas-natal' => [
        'nome'       => 'Bolachas Natal',
        'img'        => 'img-pap/nossos-bolos/cupcakes/bolachas-natal.jpg',
        'desc'       => 'Deliciosas bolachas natalícias.',
        'categoria'  => 'cupcakes',
    ],
    'bolachas-panda' => [
        'nome'       => 'Bolachas Panda',
        'img'        => 'img-pap/nossos-bolos/cupcakes/bolachas-panda.jpg',
        'desc'       => 'Bolachas temáticas de panda.',
        'categoria'  => 'cupcakes',
    ],
    'mini-brigadeiros' => [
        'nome'       => 'Mini Brigadeiros',
        'img'        => 'img-pap/nossos-bolos/cupcakes/mini-brigadeiros.jpg',
        'desc'       => 'Mini brigadeiros deliciosos.',
        'categoria'  => 'cupcakes',
    ],
    'brigadeiro-chocolate' => [
        'nome'       => 'Brigadeiro Chocolate',
        'img'        => 'img-pap/nossos-bolos/cupcakes/brigadeiro-chocolate.jpg',
        'desc'       => 'Clássico brigadeiro de chocolate.',
        'categoria'  => 'cupcakes',
    ],
    'torta-chocolate' => [
        'nome'       => 'Torta de Chocolate',
        'img'        => 'img-pap/nossos-bolos/cupcakes/torta-chocolate.jpg',
        'desc'       => 'Torta rica em chocolate.',
        'categoria'  => 'cupcakes',
    ],
    'torta-laranja' => [
        'nome'       => 'Torta de Laranja',
        'img'        => 'img-pap/nossos-bolos/cupcakes/torta-laranja.jpg',
        'desc'       => 'Torta refrescante de laranja.',
        'categoria'  => 'cupcakes',
    ],
    'bolo-bolacha' => [
        'nome'       => 'Bolo Bolacha',
        'img'        => 'img-pap/nossos-bolos/cupcakes/bolo-bolacha.jpg',
        'desc'       => 'Delicioso bolo de bolacha.',
        'categoria'  => 'cupcakes',
    ],
    'torre-choux' => [
        'nome'       => 'Torre de Choux',
        'img'        => 'img-pap/nossos-bolos/cupcakes/bolo-ar-gri-est-4.jpg',
        'desc'       => 'Elegante torre de choux.',
        'categoria'  => 'cupcakes',
    ],
];

// --- TABELA DE PREÇOS DOS PACKS ---
// Nos cupcakes o preço é apenas pelo tamanho do pack,
// não há massa nem recheio a somar.
$precosPacks = [
    'pequeno'      => ['label' => 'Pack 6 unidades',   'preco' => 25.00],
    'medio'        => ['label' => 'Pack 14 unidades',  'preco' => 35.00],
    'grande'       => ['label' => 'Pack 28 unidades',  'preco' => 50.00],
    'muito_grande' => ['label' => 'Pack 50 unidades',  'preco' => 70.00],
];

// --- PROTEÇÃO 1: Só aceita pedidos POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/compras.php');
    exit;
}

// --- PROTEÇÃO 2: O utilizador tem de estar autenticado ---
if (!isset($_SESSION['user'])) {
    dd_flash_set('danger', 'Precisa de iniciar sessão para adicionar produtos ao carrinho.');
    header('Location: ../pages/login.php');
    exit;
}

// --- PROTEÇÃO 3: Verificar o token CSRF ---
// Garante que o pedido veio mesmo do nosso formulário.
if (!dd_verificar_csrf($_POST['csrf_token'] ?? '')) {
    dd_flash_set('danger', 'Pedido inválido. Atualiza a página e tenta novamente.');
    header('Location: ../pages/compras.php');
    exit;
}

// --- LER E LIMPAR OS DADOS DO FORMULÁRIO ---
$boloId     = dd_limpar_texto($_POST['bolo_id']  ?? '', 100);
$tamanho    = dd_limpar_texto($_POST['tamanho']  ?? '', 30);
$dataEvento = dd_limpar_texto($_POST['birthday'] ?? '', 10);
$observacoes = dd_limpar_texto($_POST['observacoes'] ?? '', 500);

// Quantidade: número entre 1 e 20
$quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1, 'max_range' => 20]
]);

// --- VALIDAÇÕES ---
$erros = [];

// O cupcake/doce tem de existir no catálogo
if (!isset($catalogoCupcakes[$boloId])) {
    $erros[] = 'O produto selecionado não existe.';
}

// O pack tem de ser uma opção válida
if (!isset($precosPacks[$tamanho])) {
    $erros[] = 'Seleciona um pack válido.';
}

// A data tem de ser pelo menos 7 dias no futuro
if (!dd_data_evento_valida($dataEvento)) {
    $erros[] = 'A data do evento deve ter pelo menos 7 dias de antecedência.';
}

// Se houver erros, volta ao formulário com a mensagem de erro
if (!empty($erros)) {
    dd_flash_set('danger', implode(' ', $erros));
    $urlVoltar = $boloId !== ''
        ? '../pages/bolos/encomenda-cupcakes.php?bolo=' . urlencode($boloId)
        : '../pages/encomende.php';
    header('Location: ' . $urlVoltar);
    exit;
}

// --- CALCULAR PREÇO ---
// Para cupcakes é simples: só o preço do pack escolhido.
$precoUnitario = $precosPacks[$tamanho]['preco'];

// --- ADICIONAR AO CARRINHO ---
$produto = $catalogoCupcakes[$boloId];

dd_carrinho_adicionar([
    'bolo_id'       => $boloId,
    'nome'          => $produto['nome'],
    'imagem'        => '../' . ltrim($produto['img'], '/'),
    'descricao'     => $produto['desc'],
    'categoria'     => $produto['categoria'],
    'tamanho'       => $tamanho,
    'tamanho_label' => $precosPacks[$tamanho]['label'], // Ex: "Pack 14 unidades"
    'massa'         => '',        // Cupcakes não têm massa
    'massa_label'   => '',
    'recheio'       => '',        // Cupcakes não têm recheio
    'recheio_label' => '',
    'data_evento'   => $dataEvento,
    'observacoes'   => $observacoes,
    'quantidade'    => $quantidade,
    'preco_unitario'=> $precoUnitario,
]);

dd_flash_set('success', 'Produto adicionado ao carrinho com sucesso!');
header('Location: ../pages/compras.php');
exit;