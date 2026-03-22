<?php
// ============================================================
// FICHEIRO: includes/carrinho.php
// O QUE FAZ: Contém todas as funções partilhadas do carrinho.
// É incluído nas páginas que precisam do carrinho.
// ============================================================

// ------------------------------------------------------------
// INICIAR SESSÃO
// A sessão é como uma "memória temporária" do servidor para
// cada utilizador. Usamos para guardar o carrinho.
// Esta função garante que a sessão está sempre ativa.
// ------------------------------------------------------------
function dd_start_session() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

// ------------------------------------------------------------
// CATÁLOGO DE BOLOS
// Lista de todos os bolos disponíveis para encomendar.
// Cada bolo tem: nome, imagem, descrição, categoria e preço base.
// ------------------------------------------------------------
function dd_catalogo_bolos() {
    return [
        // --- BOLOS DE ANIVERSÁRIO ---
        'bolo-avos' => [
            'nome'       => 'Bolo de Avós',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-avós-aniv.jpg',
            'desc'       => 'Um bolo especial dedicado aos avós.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-camisa' => [
            'nome'       => 'Bolo Camisa',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-camisa-aniv.jpg',
            'desc'       => 'Perfeito para os apaixonados por futebol.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-cars' => [
            'nome'       => 'Bolo Cars',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-cars-aniv.jpg',
            'desc'       => 'Bolo inspirado no filme Cars.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-conchas' => [
            'nome'       => 'Bolo Conchas',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-conchas-aniv.jpg',
            'desc'       => 'Bolo decorado com conchas.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-panda' => [
            'nome'       => 'Bolo Panda',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-panda-aniv.jpg',
            'desc'       => 'Fofíssimo bolo panda.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-pasteleiro' => [
            'nome'       => 'Bolo Pasteleiro',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-pasteleiro-aniv.jpg',
            'desc'       => 'Clássico bolo pasteleiro.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-praia' => [
            'nome'       => 'Bolo Praia',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-praia-aniv.jpg',
            'desc'       => 'Bolo com tema de praia.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-rosa' => [
            'nome'       => 'Bolo Rosa',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-rosa-aniv.jpg',
            'desc'       => 'Bolo rosa delicado.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-sofa' => [
            'nome'       => 'Bolo Sofá',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-sofa-aniv.jpg',
            'desc'       => 'Confortável bolo sofá.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        'bolo-sonic' => [
            'nome'       => 'Bolo Sonic',
            'img'        => 'img-pap/nossos-bolos/aniversario/bolo-sonic-aniv.jpg',
            'desc'       => 'Bolo do velocíssimo Sonic.',
            'categoria'  => 'aniversario',
            'preco_base' => 25.00,
        ],
        // --- BOLOS DE BATIZADO ---
        'bolo-batismo' => [
            'nome'       => 'Bolo Batismo',
            'img'        => 'img-pap/nossos-bolos/batizado/bolo-batismo-bat.jfif',
            'desc'       => 'Um bolo especial dedicado aos batismos.',
            'categoria'  => 'batizado',
            'preco_base' => 25.00,
        ],
        'bolo-1ºcomunhão' => [
            'nome'       => 'Bolo 1ª Comunhão',
            'img'        => 'img-pap/nossos-bolos/batizado/bolo-1ºcomunhão-bat.jfif',
            'desc'       => 'Um bolo especial para a primeira comunhão.',
            'categoria'  => 'batizado',
            'preco_base' => 25.00,
        ],
        'bolo-baloiço' => [
            'nome'       => 'Bolo Baloiço',
            'img'        => 'img-pap/nossos-bolos/batizado/bolo-baloiço-bat.jfif',
            'desc'       => 'Um bolo temático de baloiço.',
            'categoria'  => 'batizado',
            'preco_base' => 25.00,
        ],
        // --- BOLOS DE CASAMENTO ---
        'bolo-aliancas' => [
            'nome'       => 'Bolo Alianças',
            'img'        => 'img-pap/nossos-bolos/casamento/bolo-aliancas-cas.jpg',
            'desc'       => 'Um bolo elegante com tema de alianças.',
            'categoria'  => 'casamento',
            'preco_base' => 25.00,
        ],
        'bolo-bodas-diamante' => [
            'nome'       => 'Bolo Bodas de Diamante',
            'img'        => 'img-pap/nossos-bolos/casamento/bolo-bodas-diamante-cas.jpg',
            'desc'       => 'Bolo especial para bodas de diamante.',
            'categoria'  => 'casamento',
            'preco_base' => 25.00,
        ],
        'bolo-flores' => [
            'nome'       => 'Bolo Flores',
            'img'        => 'img-pap/nossos-bolos/casamento/bolo-flores-cas.jpg',
            'desc'       => 'Bolo decorado com flores delicadas.',
            'categoria'  => 'casamento',
            'preco_base' => 25.00,
        ],
        'bolo-flores-comestiveis' => [
            'nome'       => 'Bolo Flores Comestíveis',
            'img'        => 'img-pap/nossos-bolos/casamento/bolo-flores-comestiveis-cas.jpg',
            'desc'       => 'Bolo com flores comestíveis.',
            'categoria'  => 'casamento',
            'preco_base' => 25.00,
        ],
    ];
}

// ------------------------------------------------------------
// OPÇÕES DE PERSONALIZAÇÃO + PREÇOS EXTRA
// Define os tamanhos, massas e recheios disponíveis,
// e quanto custam adicionalmente.
// ------------------------------------------------------------
function dd_opcoes_encomenda() {
    return [
        // Tamanho determina o preço base do bolo
        'tamanho' => [
            'pequeno'     => ['label' => 'Pequeno (10-12 pessoas)',   'preco' => 25.00],
            'medio'       => ['label' => 'Médio (13-16 pessoas)',     'preco' => 35.00],
            'grande'      => ['label' => 'Grande (17-20 pessoas)',    'preco' => 50.00],
            'muito_grande'=> ['label' => 'Muito Grande (20+ pessoas)','preco' => 70.00],
        ],
        // Massa: algumas são standard (sem custo extra), outras premium (com custo extra)
        'massa' => [
            'baunilha'      => ['label' => 'Baunilha',         'preco' =>  0.00],
            'laranja_canela'=> ['label' => 'Laranja e Canela', 'preco' =>  0.00],
            'papoila_limao' => ['label' => 'Papoila e Limão',  'preco' =>  0.00],
            'chocolate'     => ['label' => 'Chocolate Negro',  'preco' => 10.00],
            'red_velvet'    => ['label' => 'Red Velvet',       'preco' => 12.00],
            'cenoura'       => ['label' => 'Laranja e Amêndoa','preco' =>  8.00],
        ],
        // Recheio: alguns são standard (sem custo extra), outros premium (com custo extra)
        'recheio' => [
            'caramelo'   => ['label' => 'Caramelo Salgado',   'preco' =>  0.00],
            'morango'    => ['label' => 'Curd de Morango',    'preco' =>  0.00],
            'limao'      => ['label' => 'Curd de Limão',      'preco' =>  0.00],
            'creamcheese'=> ['label' => 'Cream Cheese Laranja','preco'=>  0.00],
            'brigadeiro' => ['label' => 'Brigadeiro Negro',   'preco' =>  8.00],
            'mascarpone' => ['label' => 'Mascarpone',         'preco' => 10.00],
            'framboesa'  => ['label' => 'Ganache Framboesa',  'preco' => 12.00],
            'maracuja'   => ['label' => 'Ganache Maracujá',   'preco' => 12.00],
        ],
    ];
}

// ------------------------------------------------------------
// CALCULAR PREÇO TOTAL DA ENCOMENDA
// Soma o preço do tamanho + o extra da massa + o extra do recheio.
// Exemplo: Médio (35€) + Chocolate (10€) + Brigadeiro (8€) = 53€
// ------------------------------------------------------------
function dd_preco_encomenda($tamanho, $massa, $recheio) {
    $opcoes = dd_opcoes_encomenda();

    // Verifica se as opções escolhidas existem
    if (!isset($opcoes['tamanho'][$tamanho]) ||
        !isset($opcoes['massa'][$massa]) ||
        !isset($opcoes['recheio'][$recheio])) {
        return null; // Opção inválida
    }

    $total = $opcoes['tamanho'][$tamanho]['preco']
           + $opcoes['massa'][$massa]['preco']
           + $opcoes['recheio'][$recheio]['preco'];

    return round($total, 2); // Arredonda a 2 casas decimais
}

// ------------------------------------------------------------
// FORMATAR PREÇO PARA MOSTRAR
// Converte 53.5 → "53,50" (formato português)
// ------------------------------------------------------------
function dd_formata_preco($valor) {
    return number_format((float)$valor, 2, ',', '.');
}

// ------------------------------------------------------------
// FORMATAR DATA PARA MOSTRAR
// Converte "2025-12-25" → "25/12/2025"
// ------------------------------------------------------------
function dd_formata_data($data) {
    $dataObj = DateTime::createFromFormat('Y-m-d', (string)$data);
    if (!$dataObj) return '';
    return $dataObj->format('d/m/Y');
}

// ------------------------------------------------------------
// VALIDAR DATA DO EVENTO
// A data tem de ser pelo menos 7 dias no futuro
// (tempo mínimo para preparar o bolo artesanalmente).
// ------------------------------------------------------------
function dd_data_evento_valida($data) {
    $data = is_string($data) ? trim($data) : '';

    // Tenta criar uma data a partir do texto recebido
    $dataEvento = DateTime::createFromFormat('Y-m-d', $data);

    // Se não for uma data válida, rejeita
    if (!$dataEvento || $dataEvento->format('Y-m-d') !== $data) {
        return false;
    }

    // Calcula a data mínima (hoje + 7 dias)
    $dataMinima = new DateTime('+7 days');

    return $dataEvento >= $dataMinima;
}

// ------------------------------------------------------------
// LIMPAR TEXTO RECEBIDO DO UTILIZADOR
// Remove espaços, tags HTML e limita o tamanho.
// Protege o site contra código malicioso.
// ------------------------------------------------------------
function dd_limpar_texto($texto, $tamanhoMax) {
    $texto = is_string($texto) ? trim($texto) : '';
    $texto = strip_tags($texto);           // Remove qualquer HTML
    $texto = preg_replace('/\s+/u', ' ', $texto); // Remove espaços duplos
    return mb_substr($texto, 0, $tamanhoMax);      // Limita o tamanho
}

// ------------------------------------------------------------
// MENSAGENS FLASH (mensagem que aparece uma única vez)
// Usamos isto para mostrar "Produto adicionado!" depois de
// redirecionar o utilizador para outra página.
// ------------------------------------------------------------
function dd_flash_set($tipo, $mensagem) {
    dd_start_session();
    $_SESSION['flash_mensagem'] = ['tipo' => $tipo, 'mensagem' => $mensagem];
}

function dd_flash_get() {
    dd_start_session();
    if (empty($_SESSION['flash_mensagem'])) return null;
    $msg = $_SESSION['flash_mensagem'];
    unset($_SESSION['flash_mensagem']); // Apaga depois de ler (só aparece uma vez)
    return $msg;
}

// ------------------------------------------------------------
// TOKEN CSRF (proteção contra ataques de formulário)
// Quando o formulário é enviado, verificamos que vem mesmo
// do nosso site e não de outro sítio malicioso.
// O token é uma chave secreta gerada aleatoriamente.
// ------------------------------------------------------------
function dd_csrf_token() {
    dd_start_session();
    if (empty($_SESSION['csrf_token'])) {
        // Gera uma chave aleatória segura
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function dd_verificar_csrf($token) {
    dd_start_session();
    // hash_equals evita ataques de "timing" na comparação
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

// ============================================================
// FUNÇÕES DO CARRINHO
// O carrinho é guardado em $_SESSION['carrinho'] como uma
// lista de arrays. Cada item é um bolo com as suas opções.
// ============================================================

// ------------------------------------------------------------
// OBTER O CARRINHO ATUAL
// Lê a sessão e devolve a lista de itens.
// ------------------------------------------------------------
function dd_carrinho_get() {
    dd_start_session();
    if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = []; // Se não existir, começa vazio
    }
    return $_SESSION['carrinho'];
}

// ------------------------------------------------------------
// GUARDAR O CARRINHO NA SESSÃO
// ------------------------------------------------------------
function dd_carrinho_set($itens) {
    dd_start_session();
    $_SESSION['carrinho'] = array_values($itens); // Re-indexa o array
}

// ------------------------------------------------------------
// CRIAR UMA "ASSINATURA" ÚNICA PARA CADA ITEM
// Dois bolos iguais (mesmo bolo, tamanho, massa, recheio e data)
// devem ser o mesmo item no carrinho — só aumenta a quantidade.
// A assinatura é um código gerado a partir dessas características.
// ------------------------------------------------------------
function dd_carrinho_assinatura($item) {
    return hash('sha256', json_encode([
        'bolo_id'    => (string)($item['bolo_id']    ?? ''),
        'tamanho'    => (string)($item['tamanho']    ?? ''),
        'massa'      => (string)($item['massa']      ?? ''),
        'recheio'    => (string)($item['recheio']    ?? ''),
        'data_evento'=> (string)($item['data_evento']?? ''),
        'observacoes'=> (string)($item['observacoes']?? ''),
    ]));
}

// ------------------------------------------------------------
// ADICIONAR ITEM AO CARRINHO
// Se já existe um item igual (mesma assinatura), aumenta a
// quantidade em vez de duplicar.
// ------------------------------------------------------------
function dd_carrinho_adicionar($novoItem) {
    $carrinho    = dd_carrinho_get();
    $assinatura  = dd_carrinho_assinatura($novoItem);
    $novoItem['assinatura'] = $assinatura;

    // Percorre o carrinho para ver se já existe este item
    foreach ($carrinho as &$item) {
        if (isset($item['assinatura']) && $item['assinatura'] === $assinatura) {
            // Já existe! Só aumenta a quantidade
            $item['quantidade']++;
            $item['subtotal'] = round($item['quantidade'] * $item['preco_unitario'], 2);
            dd_carrinho_set($carrinho);
            return;
        }
    }

    // Não existe — adiciona como item novo
    $novoItem['subtotal'] = round($novoItem['quantidade'] * $novoItem['preco_unitario'], 2);
    $carrinho[] = $novoItem;
    dd_carrinho_set($carrinho);
}

// ------------------------------------------------------------
// REMOVER ITEM DO CARRINHO
// Usa a assinatura para identificar qual item apagar.
// ------------------------------------------------------------
function dd_carrinho_remover($assinatura) {
    $carrinho = dd_carrinho_get();

    // Filtra: mantém todos os itens EXCEPTO o que tem esta assinatura
    $carrinho = array_filter($carrinho, function($item) use ($assinatura) {
        return !isset($item['assinatura']) || $item['assinatura'] !== $assinatura;
    });

    dd_carrinho_set($carrinho);
}

// ------------------------------------------------------------
// ATUALIZAR QUANTIDADE DE UM ITEM
// Se a nova quantidade for 0 ou menos, remove o item.
// ------------------------------------------------------------
function dd_carrinho_atualizar_quantidade($assinatura, $quantidade) {
    $carrinho = dd_carrinho_get();

    foreach ($carrinho as $indice => $item) {
        if (!isset($item['assinatura']) || $item['assinatura'] !== $assinatura) {
            continue; // Não é este item, passa ao seguinte
        }

        if ($quantidade <= 0) {
            // Quantidade 0 = remover o item
            unset($carrinho[$indice]);
        } else {
            // Atualiza quantidade e recalcula subtotal
            $carrinho[$indice]['quantidade'] = $quantidade;
            $carrinho[$indice]['subtotal']   = round($quantidade * $item['preco_unitario'], 2);
        }

        dd_carrinho_set($carrinho);
        return true;
    }

    return false; // Item não encontrado
}

// ------------------------------------------------------------
// CALCULAR TOTAIS DO CARRINHO
// Soma todos os subtotais e conta o total de produtos.
// ------------------------------------------------------------
function dd_carrinho_totais($itens) {
    $subtotal        = 0.00;
    $quantidadeTotal = 0;

    foreach ($itens as $item) {
        $subtotal        += (float)($item['subtotal']  ?? 0);
        $quantidadeTotal += (int)($item['quantidade'] ?? 0);
    }

    return [
        'subtotal'         => round($subtotal, 2),
        'total'            => round($subtotal, 2),
        'quantidade_total' => $quantidadeTotal,
        'linhas'           => count($itens), // Número de linhas diferentes no carrinho
    ];
}