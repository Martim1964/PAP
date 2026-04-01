<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    // Redireciona se não estiver logado ou não for admin
    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }

    // Filtro das encomendas
    $filtro = $_GET['filtro'] ?? 'todas';
    $where_extra = '';
    if ($filtro === 'por_entregar') { //Por a variavel fitro com o nome entregar caso ...
        $where_extra = "WHERE estado NOT IN ('entregue', 'cancelada')";
    } elseif ($filtro === 'entregues') { //Por entregues caso...
        $where_extra = "WHERE estado = 'entregue'";
    } elseif ($filtro === 'canceladas') { //Por canceladas caso...
        $where_extra = "WHERE estado = 'cancelada'";
    }

    // Buscar todas as encomendas
    $result_enc = mysqli_query($con, "SELECT e.id, e.bolo_nome, e.tamanho_label, e.quantidade, e.data_evento, e.estado, u.nome AS cliente FROM encomendas e JOIN utilizadores u ON e.utilizador_id = u.id $where_extra ORDER BY e.data_encomenda DESC");

    // Pesquisa de clientes por nome
    $pesquisa = $_GET['pesquisa'] ?? '';
    $pesquisa_escaped = mysqli_real_escape_string($con, $pesquisa);
    $result_clientes = mysqli_query($con, "SELECT id, nome, email, telefone, data_nascimento FROM utilizadores WHERE admin = 0 AND nome LIKE '%$pesquisa_escaped%' ORDER BY nome ASC"); //Pesquisar somente os cliente (admin = 0), assim não aparece os utilizadores
    
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin - Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <div class="container my-5">

        <!-- ENCOMENDAS -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-box-seam"></i> Todas as encomendas</h4>
            <!-- Dropdown filtro para filtrar as encomendas -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel"></i>
                    <?php
                        $labels = ['todas'=>'Todas','por_entregar'=>'Por entregar','entregues'=>'Entregues','canceladas'=>'Canceladas'];
                        echo $labels[$filtro] ?? 'Todas';
                    ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end"> <!-- Ativar conforme a escolha do admin -->
                    <li><a class="dropdown-item <?= $filtro==='todas'        ? 'active':'' ?>" href="?filtro=todas">Todas</a></li>
                    <li><a class="dropdown-item <?= $filtro==='por_entregar' ? 'active':'' ?>" href="?filtro=por_entregar">Por entregar</a></li>
                    <li><a class="dropdown-item <?= $filtro==='entregues'    ? 'active':'' ?>" href="?filtro=entregues">Entregues</a></li>
                    <li><a class="dropdown-item <?= $filtro==='canceladas'   ? 'active':'' ?>" href="?filtro=canceladas">Canceladas</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <table class="table table-bordered table-hover"> <!-- Tabela para mostrar as encomendas -->
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Bolo</th>
                    <th>Tamanho</th>
                    <th>Qtd</th>
                    <th>Data Evento</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($result_enc) > 0): ?> <!-- Caso haja encomendas -->
                <?php while ($enc = mysqli_fetch_assoc($result_enc)): ?> <!-- Enquanto houver encomendas a variável $enc existe -->
                <tr>
                    <!-- São postos os dados da encomenda em questao -->
                    <td><?= $enc['id'] ?></td>
                    <td><?= htmlspecialchars($enc['cliente']) ?></td>
                    <td><?= htmlspecialchars($enc['bolo_nome']) ?></td>
                    <td><?= htmlspecialchars($enc['tamanho_label']) ?></td>
                    <td><?= $enc['quantidade'] ?></td>
                    <td><?= dd_formata_data($enc['data_evento']) ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                <?= ucfirst($enc['estado']) ?>
                            </button>
                            
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../actions/alterar-estado.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                <li><a class="dropdown-item" href="../../actions/alterar-estado.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                <li><a class="dropdown-item" href="../../actions/alterar-estado.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                <li><a class="dropdown-item" href="../../actions/alterar-estado.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="../../actions/alterar-estado.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center text-muted">Nenhuma encomenda encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- CLIENTES -->
        <h4 class="mt-5"><i class="bi bi-people"></i> Clientes</h4>
        <hr>
        <!-- Pesquisar por nome -->
        <form method="GET" class="d-flex gap-2 mb-3">
            <!-- Serve para garantir que durante a pesquisa os dados em relação à filtragem do estado da encomenda não sejam perdido ao sumeter o formulário de pesquisa -->
            <input type="hidden" name="filtro" value="<?= htmlspecialchars($filtro) ?>"> 
            <!-- Cria uma caixa de texto para o administrador pesquisar o nome em questão -->
            <input type="text" name="pesquisa" class="form-control form-control-sm" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($pesquisa) ?>">
            <button type="submit" class="btn btn-outline-primary btn><i class="bi bi-search"></i></button> <!-- Botão para executar o que ele escreveu -->
        </form>
        <table class="table table-bordered table-hover">
            <thead class="table-dark"> <!-- Tabela para cada cliente -->
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data Nascimento</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($result_clientes) > 0): ?> <!-- Se houver cliente com aquele nome
                Criar a variável $cli e inserir todos os dados do cliente -->
                <?php while ($cli = mysqli_fetch_assoc($result_clientes)): ?>
                <tr>
                    <td><?= $cli['id'] ?></td>
                    <td><?= htmlspecialchars($cli['nome']) ?></td>
                    <td><?= htmlspecialchars($cli['email']) ?></td>
                    <td><?= htmlspecialchars($cli['telefone'] ?? '—') ?></td>
                    <td><?= $cli['data_nascimento'] ? dd_formata_data($cli['data_nascimento']) : '—' ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-muted">Nenhum cliente encontrado.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Ver o lucro no STRIPE -->
        <h4 class="mt-5"><i class="bi bi-currency-euro"></i> Lucro</h4>
        <hr>
        <a href="https://dashboard.stripe.com" target="_blank" class="btn btn-success">
            <i class="bi bi-box-arrow-up-right"></i> Ver no Stripe
        </a>

    </div>

    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>