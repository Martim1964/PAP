<?php
// ============================================================
// FICHEIRO: includes/db.php
// O QUE FAZ: Liga à base de dados e tem todas as funções
// para ir buscar dados do MySQL (bolos, tamanhos, massas,
// recheios e calcular preços).
//
// Este ficheiro é incluído em todos os ficheiros que
// precisam de aceder à base de dados.
// ============================================================

$db_servidor   = "localhost";
$db_utilizador = "root";
$db_password   = "";
$db_nome       = "pap_db";

// Tenta ligar ao MySQL — se falhar, para e mostra o erro
$con = mysqli_connect($db_servidor, $db_utilizador, $db_password, $db_nome);

if (!$con) {
    die("Erro ao ligar à base de dados: " . mysqli_connect_error());
}

// Garante que o MySQL usa UTF-8 (para acentos e caracteres especiais)
mysqli_set_charset($con, "utf8mb4");

// ------------------------------------------------------------
// BUSCAR UM BOLO PELO SLUG
// Vai à tabela catalogo_bolos e devolve os dados do bolo.
// Devolve null se o bolo não existir ou estiver inativo.
// ------------------------------------------------------------
function buscar_bolo($con, $slug) {
    $slug = mysqli_real_escape_string($con, $slug);

    $query = "
        SELECT b.slug, b.nome, b.descricao, b.imagem, c.slug AS categoria
        FROM catalogo_bolos b
        JOIN categorias c ON b.categoria_id = c.id
        WHERE b.slug = '$slug' AND b.ativo = 1
        LIMIT 1
    ";

    $resultado = mysqli_query($con, $query);

    if (!$resultado || mysqli_num_rows($resultado) === 0) {
        return null;
    }

    return mysqli_fetch_assoc($resultado);
}

// ------------------------------------------------------------
// BUSCAR TODOS OS TAMANHOS COM PREÇOS
// Devolve array: ['pequeno' => ['label' => '...', 'preco' => 25.00], ...]
// ------------------------------------------------------------
function buscar_tamanhos($con) {
    $query    = "SELECT slug, label, preco FROM tamanhos ORDER BY ordem ASC";
    $resultado = mysqli_query($con, $query);

    $tamanhos = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $tamanhos[$linha['slug']] = [
            'label' => $linha['label'],
            'preco' => (float)$linha['preco'],
        ];
    }

    return $tamanhos;
}

// ------------------------------------------------------------
// BUSCAR TODAS AS MASSAS COM PREÇOS
// ------------------------------------------------------------
function buscar_massas($con) {
    $query     = "SELECT slug, label, preco, premium FROM massas ORDER BY premium ASC, id ASC";
    $resultado = mysqli_query($con, $query);

    $massas = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $massas[$linha['slug']] = [
            'label'   => $linha['label'],
            'preco'   => (float)$linha['preco'],
            'premium' => (bool)$linha['premium'],
        ];
    }

    return $massas;
}

// ------------------------------------------------------------
// BUSCAR TODOS OS RECHEIOS COM PREÇOS
// ------------------------------------------------------------
function buscar_recheios($con) {
    $query     = "SELECT slug, label, preco, premium FROM recheios ORDER BY premium ASC, id ASC";
    $resultado = mysqli_query($con, $query);

    $recheios = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $recheios[$linha['slug']] = [
            'label'   => $linha['label'],
            'preco'   => (float)$linha['preco'],
            'premium' => (bool)$linha['premium'],
        ];
    }

    return $recheios;
}

// ------------------------------------------------------------
// CALCULAR PREÇO TOTAL
// Soma tamanho + massa + recheio a partir dos dados da BD.
// Exemplo: Médio (35€) + Chocolate (10€) + Brigadeiro (8€) = 53€
// Para cupcakes: massa e recheio são '' então só soma o tamanho.
// ------------------------------------------------------------
function calcular_preco($tamanhos, $massas, $recheios, $tamanho, $massa = '', $recheio = '') {
    if (!isset($tamanhos[$tamanho])) return null;

    $total  = $tamanhos[$tamanho]['preco'];
    $total += ($massa   && isset($massas[$massa]))     ? $massas[$massa]['preco']     : 0;
    $total += ($recheio && isset($recheios[$recheio])) ? $recheios[$recheio]['preco'] : 0;

    return round($total, 2);
}

// ------------------------------------------------------------
// GUARDAR ENCOMENDA NA BASE DE DADOS
// Chamada quando o utilizador finaliza a encomenda.
// ------------------------------------------------------------
function guardar_encomenda($con, $dados) {
    $utilizador_id  = (int)$dados['utilizador_id'];
    $bolo_slug      = mysqli_real_escape_string($con, $dados['bolo_slug']);
    $bolo_nome      = mysqli_real_escape_string($con, $dados['bolo_nome']);
    $tamanho_slug   = mysqli_real_escape_string($con, $dados['tamanho_slug']);
    $tamanho_label  = mysqli_real_escape_string($con, $dados['tamanho_label']);
    $massa_slug     = mysqli_real_escape_string($con, $dados['massa_slug']    ?? '');
    $massa_label    = mysqli_real_escape_string($con, $dados['massa_label']   ?? '');
    $recheio_slug   = mysqli_real_escape_string($con, $dados['recheio_slug']  ?? '');
    $recheio_label  = mysqli_real_escape_string($con, $dados['recheio_label'] ?? '');
    $data_evento    = mysqli_real_escape_string($con, $dados['data_evento']);
    $observacoes    = mysqli_real_escape_string($con, $dados['observacoes']   ?? '');
    $quantidade     = (int)$dados['quantidade'];
    $preco_unitario = (float)$dados['preco_unitario'];
    $preco_total    = round($preco_unitario * $quantidade, 2);
    $iva            = round($preco_total * 0.23, 2); // 23% de IVA

    $query = "
        INSERT INTO encomendas (
            utilizador_id, bolo_slug, bolo_nome,
            tamanho_slug, tamanho_label,
            massa_slug, massa_label,
            recheio_slug, recheio_label,
            data_evento, observacoes,
            quantidade, preco_unitario, preco_total, iva
        ) VALUES (
            $utilizador_id, '$bolo_slug', '$bolo_nome',
            '$tamanho_slug', '$tamanho_label',
            '$massa_slug', '$massa_label',
            '$recheio_slug', '$recheio_label',
            '$data_evento', '$observacoes',
            $quantidade, $preco_unitario, $preco_total, $iva
        )
    ";

    return mysqli_query($con, $query);
}
return $con;