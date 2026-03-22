<?php
// ============================================================
// FICHEIRO: actions/adicionar_carrinho.php
// O QUE FAZ: Recebe o formulário de encomenda (via POST),
// valida os dados, calcula o preço, e adiciona o bolo ao
// carrinho guardado na sessão do utilizador.
//
// FLUXO:
//   1. Utilizador preenche o formulário em encomenda.php
//   2. Clica "Adicionar ao Carrinho"
//   3. O formulário envia os dados para ESTE ficheiro (POST)
//   4. Este ficheiro valida, calcula e guarda na sessão
//   5. Redireciona para o carrinho (compras.php)
// ============================================================

require_once __DIR__ . '/../includes/carrinho.php';

dd_start_session();

// --- PROTEÇÃO 1: Só aceita pedidos POST ---
// (Não deixa entrar ninguém que tente aceder diretamente pela URL)
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
// O token foi gerado quando a página de encomenda foi carregada.
// Se não coincide, o pedido pode ser malicioso.
if (!dd_verificar_csrf($_POST['csrf_token'] ?? '')) {
    dd_flash_set('danger', 'Pedido inválido. Atualiza a página e tenta novamente.');
    header('Location: ../pages/compras.php');
    exit;
}

// --- LER E LIMPAR OS DADOS DO FORMULÁRIO ---
// dd_limpar_texto() remove espaços, HTML e limita o tamanho
$boloId      = dd_limpar_texto($_POST['bolo_id']    ?? '', 100);
$tamanho     = dd_limpar_texto($_POST['tamanho']    ?? '', 30);
$massa       = dd_limpar_texto($_POST['massa']      ?? '', 30);
$recheio     = dd_limpar_texto($_POST['recheio']    ?? '', 30);
$dataEvento  = dd_limpar_texto($_POST['birthday']   ?? '', 10);
$observacoes = dd_limpar_texto($_POST['observacoes']?? '', 500);

// Quantidade: tem de ser um número entre 1 e 20
$quantidade  = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1, 'max_range' => 20]
]);

// --- VALIDAÇÕES ---
// Guardaremos os erros numa lista; se houver erros, volta ao formulário.
$erros = [];

$catalogo = dd_catalogo_bolos();
$opcoes   = dd_opcoes_encomenda();

// O bolo tem de existir no catálogo
if (!isset($catalogo[$boloId])) {
    $erros[] = 'O bolo selecionado não existe.';
}

// O tamanho tem de ser uma opção válida
if (!isset($opcoes['tamanho'][$tamanho])) {
    $erros[] = 'Seleciona um tamanho válido.';
}

// A massa tem de ser uma opção válida
if (!isset($opcoes['massa'][$massa])) {
    $erros[] = 'Seleciona uma massa válida.';
}

// O recheio tem de ser uma opção válida
if (!isset($opcoes['recheio'][$recheio])) {
    $erros[] = 'Seleciona um recheio válido.';
}

// A data tem de ser pelo menos 7 dias no futuro
if (!dd_data_evento_valida($dataEvento)) {
    $erros[] = 'A data do evento deve ter pelo menos 7 dias de antecedência.';
}

// Se houver erros, mostra mensagem e volta ao formulário
if (!empty($erros)) {
    dd_flash_set('danger', implode(' ', $erros));
    $urlVoltar = $boloId !== '' ? '../pages/bolos/encomenda.php?bolo=' . urlencode($boloId) : '../pages/encomende.php';
    header('Location: ' . $urlVoltar);
    exit;
}

// --- CALCULAR PREÇO NO SERVIDOR ---
// O preço é calculado AQUI (não no JavaScript) para evitar
// que alguém manipule o preço no browser.
$precoUnitario = dd_preco_encomenda($tamanho, $massa, $recheio);

if ($precoUnitario === null) {
    dd_flash_set('danger', 'Não foi possível calcular o preço. Tenta novamente.');
    header('Location: ../pages/bolos/encomenda.php?bolo=' . urlencode($boloId));
    exit;
}

// --- ADICIONAR AO CARRINHO ---
$bolo = $catalogo[$boloId];

dd_carrinho_adicionar([
    'bolo_id'       => $boloId,
    'nome'          => $bolo['nome'],
    'imagem'        => '../' . ltrim($bolo['img'], '/'),
    'descricao'     => $bolo['desc'],
    'categoria'     => $bolo['categoria'],
    'tamanho'       => $tamanho,
    'tamanho_label' => $opcoes['tamanho'][$tamanho]['label'], // Ex: "Médio (13-16 pessoas)"
    'massa'         => $massa,
    'massa_label'   => $opcoes['massa'][$massa]['label'],     // Ex: "Red Velvet"
    'recheio'       => $recheio,
    'recheio_label' => $opcoes['recheio'][$recheio]['label'], // Ex: "Mascarpone"
    'data_evento'   => $dataEvento,
    'observacoes'   => $observacoes,
    'quantidade'    => $quantidade,
    'preco_unitario'=> $precoUnitario,
]);

// Mensagem de sucesso (vai aparecer na página do carrinho)
dd_flash_set('success', 'Bolo adicionado ao carrinho com sucesso!');

// Redireciona para o carrinho
header('Location: ../pages/compras.php');
exit;