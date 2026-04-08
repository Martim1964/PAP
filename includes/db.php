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
// BUSCAR TODAS AS INFORMAÇÕES DA BD E INSERIR NA PÁGINA DE INFO
// ------------------------------------------------------------
function buscar_infos($con) {
    $query = "SELECT id, nome, conteudo, ordem FROM informacoes WHERE ativo = 1 ORDER BY ordem ASC";
    
    $resultado = mysqli_query($con, $query);
    
    $infos = [];

    // Se houver informacoes
    if ($resultado) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            // Guardamos todos os campos necessários num array
            $infos[] = [
                'id'       => $linha['id'],
                'nome'     => $linha['nome'],
                'conteudo' => $linha['conteudo'],
                'ordem'    => $linha['ordem']
            ];
        }
    }
    
    return $infos;
}


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
// BUSCAR TODOS OS TAMANHOS DOS DOCES/CUPCAKES COM PREÇOS
// ------------------------------------------------------------
function buscar_tamanhos($con, $bolo_slug) {
    $slug      = mysqli_real_escape_string($con, $bolo_slug);
    $query     = "SELECT slug, label, preco FROM tamanhos_produtos WHERE bolo_slug = '$slug' ORDER BY ordem ASC";
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
    $iva            = round($preco_total * 0.23, 2); 
   

    $query = "
        INSERT INTO encomendas (
            utilizador_id, bolo_slug, bolo_nome,
            tamanho_slug, tamanho_label,
            massa_slug, massa_label,
            recheio_slug, recheio_label,
            data_evento, observacoes,
            quantidade, preco_unitario, preco_total, iva, estado
        ) VALUES (
            $utilizador_id, '$bolo_slug', '$bolo_nome',
            '$tamanho_slug', '$tamanho_label',
            '$massa_slug', '$massa_label',
            '$recheio_slug', '$recheio_label',
            '$data_evento', '$observacoes',
            $quantidade, $preco_unitario, $preco_total, $iva, 'Confirmada'
        )
    ";

    return mysqli_query($con, $query);
}
// ------------------------------------------------------------
// GUARDAR ENCOMENDA PERSONALIZADA NA BASE DE DADOS
// Chamada quando o utilizador finaliza a sua encomenda personalizada.
// ------------------------------------------------------------
function guardar_encomenda_personalizada($con, $dados) {
    $utilizador_id  = (int)$dados['utilizador_id'];
    $tamanho_label  = mysqli_real_escape_string($con, $dados['tamanho']);
    $massa_label    = mysqli_real_escape_string($con, $dados['massa']   ?? '');
    $recheio_label  = mysqli_real_escape_string($con, $dados['recheio'] ?? '');
    $data_evento    = mysqli_real_escape_string($con, $dados['data_evento']);
    $observacoes    = mysqli_real_escape_string($con, $dados['observacoes']   ?? '');
    $tema           = mysqli_real_escape_string($con, $dados['tema']   ?? '');
    $imagem         = mysqli_real_escape_string($con, $dados['imagem']);

    $query = "
        INSERT INTO `encomendas_personalizadas` (
            utilizador_id, tamanho, massa, recheio, 
            data_evento, observacoes, tema, estado, imagem
        ) VALUES (
            $utilizador_id, '$tamanho_label', '$massa_label',
            '$recheio_label', '$data_evento', 
            '$observacoes', '$tema', 'Pendente', '$imagem'
        )
    ";

    return mysqli_query($con, $query);
}

// ------------------------------------------------------------
// GUARDAR CONTACTO NA BASE DE DADOS
// Chamada quando o utilizador envia uma mensagem no formulário de contactos
// ------------------------------------------------------------
function guardar_contacto($con) {
    $nome  = $_SESSION['nome'];
    $email = $_SESSION['user'];
    $telefone = $_SESSION['telemovel'];
    $assunto  = trim($_POST['assunto']  ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    $query = "
        INSERT INTO `contactos` (
            nome, email, telefone, assunto, mensagem
        ) VALUES (
            '$nome', '$email', '$telefone', '$assunto', '$mensagem'
        )
    ";

    return mysqli_query($con, $query);
}

// ------------------------------------------------------------
// GUARDAR EMAIL SUBSCITORES NEWSLETTER NA BASE DE DADOS
// Chamada quando o utilizador subscreve a newsletter
// ------------------------------------------------------------
function guardar_newsletter($con) {
    $email = $_SESSION['user'];

    $check = mysqli_query($con, "SELECT id FROM newsletter_subscritores WHERE email = '$email' LIMIT 1");
    if (mysqli_num_rows($check) > 0) {
        return false;
    }

    $query = "
        INSERT INTO `newsletter_subscritores` (
            email
        ) VALUES (
            '$email'
        )
    ";

    return mysqli_query($con, $query);
}


// ------------------------------------------------------------
// GUARDAR NOVA INFO NA BASE DE DADOS
// Chamada quando o admin escreve nova informação
// ------------------------------------------------------------
function guardar_info($con) {
    $assunto  = trim($_POST['assunto']  ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');

    $query = "
        INSERT INTO `informacoes` (
            nome, conteudo
        ) VALUES (
            '$assunto', '$conteudo'
        )
    ";

    return mysqli_query($con, $query);
}




return $con;
