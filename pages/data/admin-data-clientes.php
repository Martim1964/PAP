<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }

    // Pesquisa de clientes por nome
    $pesquisa = $_GET['pesquisa'] ?? '';
    $stmt = $con->prepare("SELECT id, nome, email, telefone, data_nascimento, ativo, admin FROM utilizadores WHERE nome LIKE ? ORDER BY nome ASC");
    $like_pesquisa = '%' . $pesquisa . '%';
    $stmt->bind_param("s", $like_pesquisa);
    $stmt->execute();
    $result_clientes = $stmt->get_result();
    $stmt->close();

    // Filtro dos contactos
    $filtro_contactos = $_GET['filtro_contactos'] ?? 'todos';
    $sql_contactos = "SELECT * FROM contactos";
    if ($filtro_contactos === 'pendente') {
        $sql_contactos .= " WHERE estado = 'pendente'";
    } elseif ($filtro_contactos === 'respondido') {
        $sql_contactos .= " WHERE estado = 'respondido'";
    }
    $sql_contactos .= " ORDER BY data_envio DESC";
    $result_contactos = mysqli_query($con, $sql_contactos);

    // Totais para estatísticas
    $total_clientes   = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM utilizadores WHERE admin = 0"))['total'] ?? 0;
    $total_pendentes  = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM contactos WHERE estado = 'pendente'"))['total'] ?? 0;
    $total_respondidos = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM contactos WHERE estado = 'respondido'"))['total'] ?? 0;

    $mensagem = $_GET['mensagem'] ?? '';
    $tipo     = $_GET['tipo'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Clientes e Contactos - Admin Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <div class="container my-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="menu-admin.php"><i class="bi bi-house"></i> Painel</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Clientes e Contactos</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-3 mb-4">
            <h1 class="mb-0"><i class="bi bi-people"></i> Gestão de Clientes e Contactos</h1>
        </div>

        <!-- CLIENTES -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-person-lines-fill"></i> Clientes</h4>
        </div>
        <hr>
        <form method="GET" class="d-flex gap-2 mb-3">
            <input type="hidden" name="filtro_contactos" value="<?= htmlspecialchars($filtro_contactos) ?>">
            <input type="text" name="pesquisa" class="form-control form-control-sm"
                placeholder="Pesquisar por nome..."
                value="<?= htmlspecialchars($pesquisa) ?>"
                aria-label="Pesquisar cliente por nome">
            <button type="submit" class="btn btn-outline-primary btn-sm" aria-label="Pesquisar">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data Nascimento</th>
                    <th>Admin</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_clientes) > 0): ?>
                    <?php while ($cli = mysqli_fetch_assoc($result_clientes)): ?>
                    <tr>
                        <td><?= $cli['id'] ?></td>
                        <td><?= htmlspecialchars($cli['nome']) ?></td>
                        <td><?= htmlspecialchars($cli['email']) ?></td>
                        <td><?= htmlspecialchars($cli['telefone'] ?? '—') ?></td>
                        <td><?= $cli['data_nascimento'] ? dd_formata_data($cli['data_nascimento']) : '—' ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= $cli['admin'] == 1 ? 'Admin' : 'Cliente' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-admin.php?id=<?= $cli['id'] ?>&estado=1">Pôr como admin</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-admin.php?id=<?= $cli['id'] ?>&estado=0">Retirar de admin</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= $cli['ativo'] == 1 ? 'Conta ativa' : 'Conta desativada' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-cliente.php?id=<?= $cli['id'] ?>&estado=1">Ativar conta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-cliente.php?id=<?= $cli['id'] ?>&estado=0">Desativar conta</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">Nenhum cliente encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- CONTACTOS -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4 class="mb-0"><i class="bi bi-chat-left-text"></i> Contactos recebidos</h4>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel"></i>
                    <?php
                        $labels_contactos = ['todos' => 'Todos', 'pendente' => 'Pendentes', 'respondido' => 'Respondidos'];
                        echo $labels_contactos[$filtro_contactos] ?? 'Todos';
                    ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item <?= $filtro_contactos === 'todos'      ? 'active' : '' ?>" href="?filtro_contactos=todos&pesquisa=<?= urlencode($pesquisa) ?>">Todos</a></li>
                    <li><a class="dropdown-item <?= $filtro_contactos === 'pendente'   ? 'active' : '' ?>" href="?filtro_contactos=pendente&pesquisa=<?= urlencode($pesquisa) ?>">Pendentes</a></li>
                    <li><a class="dropdown-item <?= $filtro_contactos === 'respondido' ? 'active' : '' ?>" href="?filtro_contactos=respondido&pesquisa=<?= urlencode($pesquisa) ?>">Respondidos</a></li>
                </ul>
            </div>
        </div>
        <hr>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Assunto</th>
                    <th>Mensagem</th>
                    <th>Data</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_contactos) > 0): ?>
                    <?php while ($cont = mysqli_fetch_assoc($result_contactos)): ?>
                        <td><?= $cont['id'] ?></td>
                        <td><?= htmlspecialchars($cont['nome']) ?></td>
                        <td>
                                <?= htmlspecialchars($cont['email']) ?>
                        </td>
                        <td><?= htmlspecialchars($cont['telefone'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($cont['assunto']) ?></td>
                        <td>
                            <?= htmlspecialchars($cont['mensagem']); ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($cont['data_envio'])) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= $cont['estado'] === 'pendente' ? 'Pendente' : 'Respondido' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-contacto.php?id=<?= $cont['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-contacto.php?id=<?= $cont['id'] ?>&estado=respondido">Respondido</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">Nenhum contacto encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botão de regresso -->
        <a href="menu-admin.php" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>

    </div>

    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>