<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    // Redireciona se não estiver logado ou não for admin
    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }
    $user_id = (int)$_SESSION['user_id'];
    $cliente = $_SESSION['user'];

    // Filtro das encomendas
    $filtro = $_GET['filtro'] ?? 'todas';
    $where_extra = '';
    if ($filtro === 'por_entregar') {
        $where_extra = "WHERE estado NOT IN ('entregue', 'cancelada')";
    } elseif ($filtro === 'entregues') {
        $where_extra = "WHERE estado = 'entregue'";
    } elseif ($filtro === 'canceladas') {
        $where_extra = "WHERE estado = 'cancelada'";
    }

    //Filtro de confirmação do id estado de modo que possa obter os dados provenientes da action editar-estado-personalizacaoa e relacione com o modal
    $confirmar_id = isset($_GET['confirmar_id']) ? (int)$_GET['confirmar_id'] : 0;

    // Buscar todas as encomendas
    $result_enc = mysqli_query($con, "SELECT e.id, e.bolo_nome, e.tamanho_label, e.quantidade, e.data_evento, e.estado, u.nome AS cliente FROM encomendas e JOIN utilizadores u ON e.utilizador_id = u.id $where_extra ORDER BY e.data_encomenda DESC");

    // Pesquisa de clientes por nome
    $pesquisa = $_GET['pesquisa'] ?? '';
    $pesquisa_escaped = mysqli_real_escape_string($con, $pesquisa);
    $result_clientes = mysqli_query($con, "SELECT id, nome, email, telefone, data_nascimento FROM utilizadores WHERE admin = 0 AND nome LIKE '%$pesquisa_escaped%' ORDER BY nome ASC");

    // Buscar encomendas personalizadas
    $sql_personalizadas = "SELECT ep.*, u.nome AS cliente 
    FROM encomendas_personalizadas ep 
    JOIN utilizadores u ON ep.utilizador_id = u.id 
    ORDER BY ep.id DESC";
    $result_personalizadas = mysqli_query($con, $sql_personalizadas);
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

        <!-- ENCOMENDAS NORMAIS -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-box-seam"></i> Todas as encomendas</h4>
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
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Bolo</th>
                    <th>Tamanho</th>
                    <th>Qtd</th>
                    <th>Data Evento</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_enc) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_enc)): ?>
                    <tr>
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
                    <tr><td colspan="7" class="text-center text-muted">Nenhuma encomenda encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- ENCOMENDAS PERSONALIZADAS -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-box-seam"></i> Todas as encomendas personalizadas</h4>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Tamanho</th>
                    <th>Massa</th>
                    <th>Recheio</th>
                    <th>Data Evento</th>
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
                        <td><?= htmlspecialchars($enc['massa_final'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($enc['recheio_final'] ?: '—') ?></td>
                        <td><?= dd_formata_data($enc['data_evento_final']) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= ucfirst($enc['estado']) ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                                <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>"
                                     alt="Imagem do bolo"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                    <?php else: ?>
                    <tr>
                        <td><?= htmlspecialchars($enc['cliente']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho']) ?></td>
                        <td><?= htmlspecialchars($enc['massa'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($enc['recheio'] ?: '—') ?></td>
                        <td><?= dd_formata_data($enc['data_evento']) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    <?= ucfirst($enc['estado']) ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                             <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>" 
                                  style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                    </tr>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center text-muted">Nenhuma encomenda personalizada encontrada.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

        <!-- Modal para edição dos dados da encomenda personalizada após o estado ser trocado para "confirmada" -->
        <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Alterar dados da encomenda após confirmação</h5>
                </div>
                <form action="../../actions/editar-encomenda.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name = "encomenda_id" id="ModalEncId">
                        <div class="mb-3">
                            <label class="form-label">Tamanho</label>
                            <input type="text" name="tamanho_edit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Massa</label>
                            <input type="text" name="massa_edit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Recheio</label>
                            <input type="text" name="recheio_edit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="quantidade_edit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data do evento</label>
                            <input type="date" name="data_evento_edit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preço unitário(s/iva)</label>
                            <input type="number" name="preco_unit_edit" class="form-control" required>
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

        <!-- CLIENTES -->
        <h4 class="mt-5"><i class="bi bi-people"></i> Clientes</h4>
        <hr>
        <form method="GET" class="d-flex gap-2 mb-3">
            <input type="hidden" name="filtro" value="<?= htmlspecialchars($filtro) ?>">
            <input type="text" name="pesquisa" class="form-control form-control-sm" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($pesquisa) ?>">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
        </form>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data Nascimento</th>
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
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">Nenhum cliente encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- LUCRO -->
        <h4 class="mt-5"><i class="bi bi-currency-euro"></i> Lucro</h4>
        <hr>
        <a href="https://dashboard.stripe.com" target="_blank" class="btn btn-success">
            <i class="bi bi-box-arrow-up-right"></i> Ver no Stripe
        </a>

    </div>


    <!-- JavaScript para abrir automaticamente o modal após alteração do estado para confirmado -->
     <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Crio uma variável que vai buscar o id do PHP
        const confirmarId = <?= $confirmar_id ?>;
        
        if (confirmarId > 0) {//Caso o ID existir
            // Preencho o ID no campo hidden do modal
            const inputId = document.getElementById('ModalEncId'); //Crio a variável para ir buscar os dados do modal
            if (inputId) { //Caso consiga ir buscar o modal com sucesso
                inputId.value = confirmarId; //Abribuo o valor à variável 
                
                // Abro o Modal
                const modalElement = document.getElementById('modalEditar'); //Crio a variavel que permite ir buscar os dados para serem editados
                const modal = new bootstrap.Modal(modalElement); //Criar objeto na memória do navegador de modo que permite abrir ou fechar o modal
                modal.show(); //Abre o modal

                // LIMPAR A URL 
                // Isto remove o "?confirmar_id=XX" da barra de endereço
                //Apos atualizacao da pagina elimina os chamados GET parametros (tudo o que tenha confirmar_id=x)
                //Criar uma Url nova
                const novaUrl = window.location.protocol + "//" + window.location.host + window.location.pathname; 
                //O endereço é substituido pelo criado acima de forma automática
                window.history.replaceState({path: novaUrl}, '', novaUrl);
            }
        }
    });
    </script>
        

    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>