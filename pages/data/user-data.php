<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    
    dd_start_session();
    require_once __DIR__ . '/../../includes/verificar_ativo.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    $user_id = (int)$_SESSION['user_id'];

    // Buscar dados do utilizador
    $stmt = $con->prepare("SELECT nome, email, telefone, data_nascimento FROM utilizadores WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result_user = $stmt->get_result();
    $user = $result_user->fetch_assoc();
    $stmt->close();

    // Filtro
    $filtro = $_GET['filtro'] ?? 'todas';
    $where_extra = '';
    if ($filtro === 'por_entregar') {
        $where_extra = "AND estado NOT IN ('entregue', 'cancelada')";
    } elseif ($filtro === 'entregues') {
        $where_extra = "AND estado = 'entregue'";
    } elseif ($filtro === 'canceladas') {
        $where_extra = "AND estado = 'cancelada'";
    }

    // Buscar encomendas do utilizador
    $sql_enc = "SELECT bolo_nome, tamanho_label, massa_label, recheio_label, quantidade, data_evento, estado FROM encomendas WHERE utilizador_id = ?";
    if ($filtro === 'por_entregar') {
        $sql_enc .= " AND estado NOT IN ('entregue', 'cancelada')";
    } elseif ($filtro === 'entregues') {
        $sql_enc .= " AND estado = 'entregue'";
    } elseif ($filtro === 'canceladas') {
        $sql_enc .= " AND estado = 'cancelada'";
    }
    $sql_enc .= " ORDER BY data_encomenda DESC";

    $stmt_enc = $con->prepare($sql_enc);
    $stmt_enc->bind_param("i", $user_id);
    $stmt_enc->execute();
    $result_enc = $stmt_enc->get_result();
    $stmt_enc->close();

    // Buscar encomendas personalizadas PENDENTES (por verificação)
    $sql_pendentes = "SELECT tamanho, massa, recheio, data_evento, estado, imagem 
                      FROM encomendas_personalizadas 
                      WHERE utilizador_id = ? 
                        AND estado NOT IN ('confirmada', 'pronta', 'entregue')
                      ORDER BY id DESC";
    $stmt_pendentes = $con->prepare($sql_pendentes);
    $stmt_pendentes->bind_param("i", $user_id);
    $stmt_pendentes->execute();
    $result_pendentes = $stmt_pendentes->get_result();
    $stmt_pendentes->close();

    // Buscar encomendas personalizadas CONFIRMADAS
    $sql_confirmadas = "SELECT *
                        FROM encomendas_personalizadas 
                        WHERE utilizador_id = ? 
                          AND estado IN ('confirmada', 'pronta', 'entregue')
                        ORDER BY id DESC";
    $stmt_confirmadas = $con->prepare($sql_confirmadas);
    $stmt_confirmadas->bind_param("i", $user_id);
    $stmt_confirmadas->execute();
    $result_confirmadas = $stmt_confirmadas->get_result();
    $stmt_confirmadas->close();
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
    <title>A minha conta - Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <main>

    <!-- DADOS DO UTILIZADOR -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><i class="bi bi-person-circle"></i> Os meus dados</h1>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar">
                <i class="bi bi-pencil"></i> Editar
            </button>
        </div>
        <hr>
        <?php if ($user): ?>
        <table class="table table-bordered">
            <tr>
                <th>Nome</th>
                <td><?= htmlspecialchars($user['nome']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td><?= htmlspecialchars($user['telefone'] ?? '—') ?></td>
            </tr>
            <tr>
                <th>Data de Nascimento</th>
                <td><?= $user['data_nascimento'] ? dd_formata_data($user['data_nascimento']) : '—' ?></td>
            </tr>
        </table>
        <?php endif; ?>

        <!-- ENCOMENDAS NORMAIS -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-box-seam"></i> As minhas encomendas</h4>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel"></i>
                    <?php
                        $labels = ['todas'=>'Todas','por_entregar'=>'Por entregar','entregues'=>'Entregues','canceladas'=>'Canceladas'];
                        echo $labels[$filtro] ?? 'Todas';
                    ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item <?= $filtro==='todas'        ? 'active':'' ?>" href="?filtro=todas">Todas</a></li>
                    <li><a class="dropdown-item <?= $filtro==='por_entregar' ? 'active':'' ?>" href="?filtro=por_entregar">Por entregar</a></li>
                    <li><a class="dropdown-item <?= $filtro==='entregues'    ? 'active':'' ?>" href="?filtro=entregues">Entregues</a></li>
                    <li><a class="dropdown-item <?= $filtro==='canceladas'   ? 'active':'' ?>" href="?filtro=canceladas">Canceladas</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <caption class="visually-hidden">As minhas encomendas</caption>
            <thead class="table-dark">
                
                <tr>
                    <th>Bolo</th>
                    <th>Tamanho</th>
                    <th>Massa</th>
                    <th>Recheio</th>
                    <th>Quantidade</th>
                    <th>Data Evento</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_enc) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_enc)): ?>
                    
                    <tr>
                        <td><?= htmlspecialchars($enc['bolo_nome']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho_label']) ?></td>
                        <td><?= htmlspecialchars($enc['massa_label'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($enc['recheio_label'] ?: '—') ?></td>
                        <td><?= $enc['quantidade'] ?></td>
                        <td><?= dd_formata_data($enc['data_evento']) ?></td>
                        <td><?= htmlspecialchars($enc['estado']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhuma encomenda encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- ENCOMENDAS PERSONALIZADAS - POR VERIFICAÇÃO -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-box-seam"></i> As minhas encomendas personalizadas - por verificação</h4>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <caption class="visually-hidden">As minhas encomendas personalizadas - pendentes</caption>
            <thead class="table-dark">
                
                <tr>
                    <th>Tamanho</th>
                    <th>Massa</th>
                    <th>Recheio</th>
                    <th>Data Evento</th>
                    <th>Estado</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_pendentes) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_pendentes)): ?>
                    
                    <tr>
                        <td><?= htmlspecialchars($enc['tamanho']) ?></td>
                        <td><?= htmlspecialchars($enc['massa'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($enc['recheio'] ?: '—') ?></td>
                        <td><?= dd_formata_data($enc['data_evento']) ?></td>
                        <td><?= ucfirst($enc['estado']) ?></td>
                        <td>
                            <?php if (!empty($enc['imagem'])): ?>
                                <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>"
                                     alt="Imagem de referencia da sua encomenda personalizada confirmada para o dia <?= htmlspecialchars ($enc['data_evento']) ?>"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhuma encomenda personalizada pendente.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- ENCOMENDAS PERSONALIZADAS - CONFIRMADAS -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-box-seam"></i> As minhas encomendas personalizadas</h4>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <caption class="visually-hidden">As minhas encomendas personalizadas</caption>
            <thead class="table-dark">
                
                <tr>
                    <th>Tamanho</th>
                    <th>Massa</th>
                    <th>Recheio</th>
                    <th>Data Evento</th>
                    <th>Qtd</th>
                    <th>Estado</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_confirmadas) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_confirmadas)): ?>
                    <tr>
                        <td><?= htmlspecialchars($enc['tamanho_final'] ?: $enc['tamanho']) ?></td>
                        <td><?= htmlspecialchars($enc['massa_final'] ?: ($enc['massa'])?: '-') ?></td>
                        <td><?= htmlspecialchars($enc['recheio_final'] ?: ($enc['recheio'])?: '-') ?></td>
                        <td><?= dd_formata_data($enc['data_evento_final'] ?: ($enc['data_evento'])) ?></td>
                        <td><?= $enc['quantidade_final'] ?: '1' ?></td>
                        <td><?= ucfirst($enc['estado']) ?></td>
                        <td>
                            <?php if (!empty($enc['imagem'])): ?>
                                <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>"
                                     alt="Imagem de referencia da sua encomenda personalizada confirmada para o dia <?= htmlspecialchars($enc['data_evento_final'] ?: ($enc['data_evento'])) ?>"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhuma encomenda personalizada confirmada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label = "Fechar"></button>
                </div>
                <form action="../../actions/editar-conta.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($user['email']) ?>" aria-label = "Alterar Email" required>
                        </div>
                        <div class="mb-3">
                            <label for= "telefone" class="form-label">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" class="form-control"
                                value="<?= htmlspecialchars($user['telefone'] ?? '') ?>" aria-label="Alterar numero telefone">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label ="Cancelar">Cancelar</button>
                        <button type="submit" class="btn btn-primary" aria-label="Guardar" >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </main>

    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>