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
// VALIDAR IDADE MÍNIMA (DATA DE NASCIMENTO)
// Verifica se a pessoa tem pelo menos 13 anos com base na data de nascimento.
// ------------------------------------------------------------
function dd_validar_idade_minima($data_nascimento, $idade_minima = 13) {
    if (empty($data_nascimento)) return false;
    
    try {
        $hoje = new DateTime();
        $nasc = new DateTime($data_nascimento);
        $idade = $hoje->diff($nasc)->y;
        return $idade >= $idade_minima;
    } catch (Exception $e) {
        return false; // Data inválida
    }
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

    $novoItem['iva']      = round($novoItem['preco_unitario'] * 0.23, 2);
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
// --------------------------------------------------------------
//LIMPAR DADOS APOS PAGAMENTO
//----------------------------------------------------------------
function dd_carrinho_limpar() {
    dd_start_session();
    $_SESSION['carrinho'] = []; 
}