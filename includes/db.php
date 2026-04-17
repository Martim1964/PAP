<?php
// ============================================================
// FICHEIRO: includes/db.php
// O QUE FAZ: Gestão da ligação à BD e funções de consulta.
// ============================================================

// Definição das credenciais de acesso à base de dados
$db_servidor   = "localhost";
$db_utilizador = "root";
$db_password   = "";
$db_nome       = "pap_db";

// Criação da conexão utilizando a classe mysqli (Estilo POO)
$con = new mysqli($db_servidor, $db_utilizador, $db_password, $db_nome);

// Verifica se houve algum erro na tentativa de ligação
if ($con->connect_error) {
    die("Erro ao ligar à base de dados: " . $con->connect_error);
}

// Configura a comunicação para UTF-8 (evita erros em acentos e emojis)
$con->set_charset("utf8mb4");

// ------------------------------------------------------------
// FUNÇÃO: buscar_infos
// OBJETIVO: Listar textos informativos ativos da página de INFO.
// ------------------------------------------------------------
function buscar_infos($con) {
    // Query estática (sem inputs do user), pode ser executada diretamente
    $query = "SELECT id, nome, conteudo, ordem FROM informacoes WHERE ativo = 1 ORDER BY ordem ASC";
    $resultado = $con->query($query);
    
    $infos = [];
    if ($resultado) {
        // Converte cada linha da tabela num array associativo
        while ($linha = $resultado->fetch_assoc()) {
            $infos[] = $linha;
        }
    }
    return $infos;
}

// ------------------------------------------------------------
// FUNÇÃO: buscar_bolo
// OBJETIVO: Obter detalhes de um bolo específico através do slug (URL).
// ------------------------------------------------------------
function buscar_bolo($con, $slug) {
    // Prepara a query com um marcador "?" por segurança
    $stmt = $con->prepare("
        SELECT b.slug, b.nome, b.descricao, b.imagem, c.slug AS categoria
        FROM catalogo_bolos b
        JOIN categorias c ON b.categoria_id = c.id
        WHERE b.slug = ? AND b.ativo = 1
        LIMIT 1
    ");
    // Vincula o slug recebido ao marcador "?" (s = string)
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Devolve os dados ou null se o bolo não existir
    return $resultado->fetch_assoc() ?: null;
}

// ------------------------------------------------------------
// FUNÇÃO: buscar_tamanhos
// OBJETIVO: Listar tamanhos disponíveis para um produto específico.
// ------------------------------------------------------------
function buscar_tamanhos($con, $bolo_slug) {
    $stmt = $con->prepare("SELECT slug, label, preco FROM tamanhos_produtos WHERE bolo_slug = ? AND ativo = '1' ORDER BY ordem ASC");
    $stmt->bind_param("s", $bolo_slug);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $tamanhos = [];
    while ($linha = $resultado->fetch_assoc()) {
        // Organiza o array usando o slug como chave para facilitar o cálculo posterior
        $tamanhos[$linha['slug']] = [
            'label' => $linha['label'],
            'preco' => (float)$linha['preco'],
        ];
    }
    return $tamanhos;
}

// ------------------------------------------------------------
// FUNÇÃO: buscar_massas e buscar_recheios
// OBJETIVO: Listar opções de personalização.
// ------------------------------------------------------------
function buscar_massas($con) {
    $query = "SELECT slug, label, preco, premium, ativo FROM massas WHERE ativo = '1' ORDER BY premium ASC, id ASC";
    $resultado = $con->query($query);

    $massas = [];
    if ($resultado) {
        while ($linha = $resultado->fetch_assoc()) {
            $massas[$linha['slug']] = [
                'label'   => $linha['label'],
                'preco'   => (float)$linha['preco'],
                'premium' => (bool)$linha['premium'],
            ];
        }
    }
    return $massas;
}

function buscar_recheios($con) {
    $query = "SELECT slug, label, preco, premium, ativo FROM recheios WHERE ativo = '1' ORDER BY premium ASC, id ASC";
    $resultado = $con->query($query);

    $recheios = [];
    if ($resultado) {
        while ($linha = $resultado->fetch_assoc()) {
            $recheios[$linha['slug']] = [
                'label'   => $linha['label'],
                'preco'   => (float)$linha['preco'],
                'premium' => (bool)$linha['premium'],
            ];
        }
    }
    return $recheios;
}

// ------------------------------------------------------------
// FUNÇÃO: calcular_preco
// OBJETIVO: Lógica matemática para somar os extras ao preço base.
// ------------------------------------------------------------
function calcular_preco($tamanhos, $massas, $recheios, $tamanho, $massa = '', $recheio = '') {
    if (!isset($tamanhos[$tamanho])) return null;

    $total  = $tamanhos[$tamanho]['preco'];
    // Soma o preço da massa/recheio apenas se eles existirem no array de preços
    $total += ($massa   && isset($massas[$massa]))     ? $massas[$massa]['preco']     : 0;
    $total += ($recheio && isset($recheios[$recheio])) ? $recheios[$recheio]['preco'] : 0;

    return round($total, 2);
}

// ------------------------------------------------------------
// FUNÇÃO: guardar_encomenda
// OBJETIVO: Inserir um novo pedido padrão na base de dados.
// ------------------------------------------------------------
function guardar_encomenda($con, $dados) {
    // Conversão de tipos para garantir integridade dos dados
    $utilizador_id  = (int)$dados['utilizador_id'];
    $quantidade     = (int)$dados['quantidade'];
    $preco_unitario = (float)$dados['preco_unitario'];
    $preco_total    = round($preco_unitario * $quantidade, 2);
    $iva            = round($preco_total * 0.23, 2);

    $sql = "INSERT INTO encomendas (
                utilizador_id, bolo_slug, bolo_nome, tamanho_slug, tamanho_label,
                massa_slug, massa_label, recheio_slug, recheio_label,
                data_evento, observacoes, quantidade, preco_unitario, preco_total, iva, estado
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmada')";

    $stmt = $con->prepare($sql);
    // Vincula todos os dados: i=inteiro, s=string, d=decimal (double)
    $stmt->bind_param("issssssssssiddd", 
        $utilizador_id, $dados['bolo_slug'], $dados['bolo_nome'],
        $dados['tamanho_slug'], $dados['tamanho_label'],
        $dados['massa_slug'], $dados['massa_label'],
        $dados['recheio_slug'], $dados['recheio_label'],
        $dados['data_evento'], $dados['observacoes'],
        $quantidade, $preco_unitario, $preco_total, $iva
    );

    return $stmt->execute();
}

// ------------------------------------------------------------
// FUNÇÃO: guardar_encomenda_personalizada
// OBJETIVO: Gravar pedidos onde o cliente envia tema e imagem própria.
// ------------------------------------------------------------
function guardar_encomenda_personalizada($con, $dados) {
    $utilizador_id = (int)$dados['utilizador_id'];

    $sql = "INSERT INTO encomendas_personalizadas (
                utilizador_id, tamanho, massa, recheio, 
                data_evento, observacoes, tema, estado, imagem
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pendente', ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssssss", 
        $utilizador_id, $dados['tamanho'], $dados['massa'], $dados['recheio'],
        $dados['data_evento'], $dados['observacoes'], $dados['tema'], $dados['imagem']
    );

    return $stmt->execute();
}

// ------------------------------------------------------------
// FUNÇÃO: guardar_contacto
// OBJETIVO: Gravar as mensagens enviadas pelo form de contacto.
// ------------------------------------------------------------
function guardar_contacto($con) {
    $sql = "INSERT INTO contactos (nome, email, telefone, assunto, mensagem) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($sql);
    // Usa diretamente os dados da sessão (logado) e do formulário (POST)
    $stmt->bind_param("sssss", 
        $_SESSION['nome'], 
        $_SESSION['user'], 
        $_SESSION['telemovel'], 
        $_POST['assunto'], 
        $_POST['mensagem']
    );

    return $stmt->execute();
}

// ------------------------------------------------------------
// FUNÇÃO: guardar_newsletter
// OBJETIVO: Subscrever o utilizador na lista de emails.
// ------------------------------------------------------------
function guardar_newsletter($con) {
    $email = $_SESSION['user'];

    // Primeiro, verifica se o email já existe para não duplicar
    $stmtCheck = $con->prepare("SELECT id FROM newsletter_subscritores WHERE email = ? LIMIT 1");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    if ($stmtCheck->get_result()->num_rows > 0) return false;

    // Se não existir, insere
    $stmt = $con->prepare("INSERT INTO newsletter_subscritores (email) VALUES (?)");
    $stmt->bind_param("s", $email);
    return $stmt->execute();
}

// ------------------------------------------------------------
// FUNÇÃO: guardar_newsletter_enviada
// OBJETIVO: Funções administrativas para gestão de conteúdos.
// ------------------------------------------------------------
function guardar_newsletter_enviada($con) {
    $assunto  = trim($_POST['assunto']  ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    $stmt = $con->prepare("INSERT INTO newsletters_enviadas (assunto, mensagem) VALUES (?, ?)");
    $stmt->bind_param("ss", $assunto, $mensagem);
    return $stmt->execute();
}

// ------------------------------------------------------------
// FUNÇÃO DE GUARDAR NOVAS INFORMACOES NA BD
// OBJETIVO: Funções administrativas para gestão de conteúdos.
// ------------------------------------------------------------

function guardar_info($con) {
    $assunto  = trim($_POST['assunto']  ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');

    $stmt = $con->prepare("INSERT INTO informacoes (nome, conteudo) VALUES (?, ?)");
    $stmt->bind_param("ss", $assunto, $conteudo);
    return $stmt->execute();
}

// Retorna a conexão aberta para ser usada pelos outros ficheiros
return $con;
?>