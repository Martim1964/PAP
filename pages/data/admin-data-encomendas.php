<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }

    $filtro = $_GET['filtro'] ?? 'todas';
    $where_extra = '';
    if ($filtro === 'por_entregar') {
        $where_extra = "WHERE estado NOT IN ('entregue', 'cancelada')";
    } elseif ($filtro === 'entregues') {
        $where_extra = "WHERE estado = 'entregue'";
    } elseif ($filtro === 'canceladas') {
        $where_extra = "WHERE estado = 'cancelada'";
    }

    $confirmar_id = isset($_GET['confirmar_id']) ? (int)$_GET['confirmar_id'] : 0;

    $result_enc = mysqli_query($con, "SELECT e.id, e.bolo_nome, e.tamanho_label, e.quantidade, e.data_evento,e.data_encomenda, e.observacoes, e.estado, e.preco_total, e.iva, u.nome AS cliente FROM encomendas e JOIN utilizadores u ON e.utilizador_id = u.id $where_extra ORDER BY e.data_encomenda DESC");

    $result_personalizadas = mysqli_query($con, "SELECT ep.*, u.nome AS cliente FROM encomendas_personalizadas ep JOIN utilizadores u ON ep.utilizador_id = u.id ORDER BY ep.id DESC");

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
    <title>Encomendas - Admin Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <main>

    <div class="container my-5">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="menu-admin.php"><i class="bi bi-house"></i> Painel</a></li>
                <li class="breadcrumb-item active">Encomendas</li>
            </ol>
        </nav>

        <h1 class="mb-5"><i class="bi bi-box-seam"></i> Gestão de Encomendas</h1>

        <?php if ($mensagem): ?>
            <div class="alert alert-<?= $tipo === 'sucesso' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensagem) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ENCOMENDAS NORMAIS -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-box-seam"></i> Encomendas normais</h4>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel"></i>
                    <?php
                        $labels = ['todas' => 'Todas', 'por_entregar' => 'Por entregar', 'entregues' => 'Entregues', 'canceladas' => 'Canceladas'];
                        echo $labels[$filtro] ?? 'Todas';
                    ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item <?= $filtro === 'todas'        ? 'active' : '' ?>" href="?filtro=todas">Todas</a></li>
                    <li><a class="dropdown-item <?= $filtro === 'por_entregar' ? 'active' : '' ?>" href="?filtro=por_entregar">Por entregar</a></li>
                    <li><a class="dropdown-item <?= $filtro === 'entregues'    ? 'active' : '' ?>" href="?filtro=entregues">Entregues</a></li>
                    <li><a class="dropdown-item <?= $filtro === 'canceladas'   ? 'active' : '' ?>" href="?filtro=canceladas">Canceladas</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Bolo</th>
                    <th>Tamanho</th>
                    <th>Qtd</th>
                    <th>Data Encomenda</th>
                    <th>Data Evento</th>
                    <th>Observações</th>
                    <th>Preço total c/ iva</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_enc) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_enc)): ?>
                    <tr>
                        <td><?= htmlspecialchars($enc['cliente']) ?></td>
                        <td><?= htmlspecialchars($enc['bolo_nome']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho_label']) ?></td>
                        <td><?= $enc['quantidade'] ?></td>
                        <td><?= $enc['data_encomenda'] ?></td>
                        <td><?= dd_formata_data($enc['data_evento']) ?></td>
                        <td><?= htmlspecialchars($enc['observacoes']) ?: '-' ?></td>
                        <td><?= number_format($enc['preco_total'] + $enc['iva'], 2, ',', '.') ?>€</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= ucfirst($enc['estado']) ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted">Nenhuma encomenda encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- ENCOMENDAS PERSONALIZADAS -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-stars"></i> Encomendas personalizadas</h4>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Tamanho</th>
                    <th>Massa</th>
                    <th>Recheio</th>
                    <th>Quantidade</th>
                    <th>Data Encomenda</th>
                    <th>Data Evento</th>
                    <th>Observações</th>
                    <th>Preço total c/ iva</th>
                    <th>Estado</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_personalizadas) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_personalizadas)): ?>
                    <?php if ($enc['estado'] == 'confirmada' || $enc['estado'] == 'pronta' || $enc['estado'] == 'entregue'): ?>
                    <tr>
                        <td><?= htmlspecialchars($enc['cliente']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho_final']) ?></td>
                        <td><?= htmlspecialchars($enc['massa_final'] ?: $enc['massa']) ?: '-' ?></td>
                        <td><?= htmlspecialchars($enc['recheio_final'] ?: $enc['recheio']) ?: '-' ?></td>
                        <td><?= $enc['quantidade_final'] ?></td>
                        <td><?= $enc['data_encomenda_personalizada'] ?></td>
                        <td><?= dd_formata_data($enc['data_evento_final']) ?: $enc['data_evento'] ?></td>
                        <td><?= htmlspecialchars($enc['observacoes']) ?: '-' ?></td>
                        <td><?= number_format($enc['preco_total'] + $enc['iva'], 2, ',', '.') ?>€</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= ucfirst($enc['estado']) ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>"
                                 alt="Imagem encomenda"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td><?= htmlspecialchars($enc['cliente']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho']) ?></td>
                        <td><?= htmlspecialchars($enc['massa']) ?: '-' ?></td>
                        <td><?= htmlspecialchars($enc['recheio']) ?: '-' ?></td>
                        <td><?= $enc['quantidade_final'] ?></td>
                        <td><?= $enc['data_encomenda_personalizada'] ?></td>
                        <td><?= dd_formata_data($enc['data_evento']) ?></td>~
                        <td><?= htmlspecialchars($enc['observacoes']) ?: '-' ?></td>
                        <td>Encomenda pendente</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= ucfirst($enc['estado']) ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../../actions/admin-data/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($enc['imagem'])): ?>
                                <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>"
                                    alt="Imagem encomenda"
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <span>Não foi inserida imagem</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center text-muted">Nenhuma encomenda personalizada encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal edição encomenda personalizada -->
        <div class="modal fade" id="modalEditar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil"></i> Alterar dados da encomenda após confirmação</h5>
                    </div>
                    <form action="../../actions/admin-data/editar-encomenda.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="encomenda_id" id="ModalEncId">
                            <div class="mb-3">
                                <label class="form-label" for="tamanho">Tamanho</label>
                                <input type="text" name="tamanho_edit" id="tamanho" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="massa">Massa</label>
                                <input type="text" name="massa_edit" id="massa" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="recheio">Recheio</label>
                                <input type="text" name="recheio_edit" id="recheio" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="quantidade">Quantidade</label>
                                <input type="number" name="quantidade_edit" id="quantidade" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="data_evento">Data do evento</label>
                                <input type="date" name="data_evento_edit" id="data_evento" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="preco_unit">Preço unitário (s/iva)</label>
                                <input type="number" name="preco_unit_edit" id="preco_unit" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <a href="menu-admin.php" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const confirmarId = <?= $confirmar_id ?>;
            if (confirmarId > 0) {
                const inputId = document.getElementById('ModalEncId');
                if (inputId) {
                    inputId.value = confirmarId;
                    const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
                    modal.show();
                    const novaUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    window.history.replaceState({path: novaUrl}, '', novaUrl);
                }
            }
        });
    </script>

    </main>

    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>