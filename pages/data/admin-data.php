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
    $result_clientes = mysqli_query($con, "SELECT id, nome, email, telefone, data_nascimento, ativo, admin FROM utilizadores WHERE nome LIKE '%$pesquisa_escaped%' ORDER BY nome ASC");

    // Buscar encomendas personalizadas
    $sql_personalizadas = "SELECT ep.*, u.nome AS cliente 
    FROM encomendas_personalizadas ep 
    JOIN utilizadores u ON ep.utilizador_id = u.id 
    ORDER BY ep.id DESC";
    $result_personalizadas = mysqli_query($con, $sql_personalizadas);


    // Buscar informacoes
    $infos = mysqli_query($con, "SELECT nome, ordem, ativo FROM informacoes ORDER by ordem ASC");
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
    <title>Admin - Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <div class="container my-5">

    <h1>PAINEL DE ADMINISTRADOR</h1>
    
    <br><br><br>

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
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=pendente">Pendente</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=confirmada">Confirmada</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=pronta">Pronta</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-estado.php?id=<?= $enc['id'] ?>&estado=entregue">Entregue</a></li>
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
                    <th>Quantidade</th>
                    <th>Data Evento</th>
                    <th>Estado</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_personalizadas) > 0): ?>
                    <?php while ($enc = mysqli_fetch_assoc($result_personalizadas)): ?>
                    
                    <!-- Caso o estado da encomenda for confirmado, pronto, entregue os dados são os dados postos 
                     pelo administrador a partir do modal -->
                    <?php if ($enc['estado'] == 'confirmada' || $enc['estado'] == 'pronta' || $enc['estado'] == 'entregue'): ?> 
                    <tr>
                        <td><?= htmlspecialchars($enc['cliente']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho_final'])?></td>
                        <td><?= htmlspecialchars($enc['massa_final'] ?: ($enc['massa'])) ?></td>
                        <td><?= htmlspecialchars($enc['recheio_final'] ?: ($enc['recheio'])) ?></td>
                        <td><?= $enc['quantidade_final'] ?></td>
                        <td><?= dd_formata_data($enc['data_evento_final']) ?: ($enc['data_evento'])?></td>
                        <td>
                            <!-- Dropdown para alteração do estado da encomenda -->
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
                                     alt="Imagem de referencia das encomendas personalizadas para o dia <?= htmlspecialchars ($enc['data_evento_final']) ?: ($enc['data_evento']) ?>"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>

                        <!-- Caso a encomenda ainda esteja pendente, os dados são os que foram postos pelo cliente -->
                    <?php else: ?>
                    <tr>
                        <td><?= htmlspecialchars($enc['cliente']) ?></td>
                        <td><?= htmlspecialchars($enc['tamanho']) ?></td>
                        <td><?= htmlspecialchars($enc['massa']) ?: '-' ?></td>
                        <td><?= htmlspecialchars($enc['recheio'])?: '-' ?></td>
                        <td><?= $enc['quantidade_final'] ?></td>
                        <td><?= dd_formata_data($enc['data_evento']) ?></td>
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
                                    <li><a class="dropdown-item text-danger" href="../../actions/alterar-estado-personalizada.php?id=<?= $enc['id'] ?>&estado=cancelada">Cancelada</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                             <img src="../../img-pap/upload-bolos-personalizados/<?= htmlspecialchars($enc['imagem']) ?>" 
                                  alt="Imagem de referencia das encomendas personalizadas pendentes para o dia <?= htmlspecialchars ($enc['data_evento']) ?>"
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
                            <label class="form-label" for = "tamanho">Tamanho</label>
                            <input type="text" name="tamanho_edit" id="tamanho" class="form-control" aria-label="tamanho">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="massa">Massa</label>
                            <input type="text" name="massa_edit" id="massa" class="form-control" aria-label="massa">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="recheio">Recheio</label>
                            <input type="text" name="recheio_edit" id="recheio" class="form-control" aria-label ="recheio">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="quantidade">Quantidade</label>
                            <input type="number" name="quantidade_edit" id="quantidade" class="form-control" aria-label="quantidade">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="data_evento">Data do evento</label>
                            <input type="date" name="data_evento_edit" id="data_evento" class="form-control" aria-label="data_evento">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="preco_unit">Preço unitário(s/iva)</label>
                            <input type="number" name="preco_unit_edit" id="preco_unit" class="form-control" aria-label="preço_unit_s/iva">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Cancelar">Cancelar</button>
                        <button type="submit" class="btn btn-primary" aria-label="Guardar">Guardar</button>
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
            <input type="text" name="pesquisa" class="form-control form-control-sm" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($pesquisa) ?>" aria-label="pesquisar por nome do cliente">
            <button type="submit" class="btn btn-outline-primary btn-sm" aria-label = "Clicar para pesquisar"><i class="bi bi-search"></i></button>
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
                        <!--<td>// htmlspecialchars($cli['admin']</td> -->
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
                    <tr><td colspan="5" class="text-center text-muted">Nenhum cliente encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h4 class="mt-5"><i class="bi bi-envelope-at"></i> Verificar informações e alterar a sua ordem</h4>
       <div class="mb-3">
        <a href="admin-data-info.php" class="btn btn-primary">
            <i class="bi bi-sort-numeric-down"></i> Alterar ordem das informações
        </a>
    </div>
        
        <h4 class="mt-5"><i class="bi bi-envelope-at"></i> Nova informação para a página de informações</h4>
        <hr>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="../../actions/processa_nova_info.php" method="POST">
                    <div class="mb-3">
                        <label for="assunto-info" class="form-label font-weight-bold">Assunto da Informação</label>
                        <input type="text" id="assunto-info" name="assunto" class="form-control" placeholder="Nova Informação" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="conteudo-info" class="form-label font-weight-bold">Conteúdo</label>
                        <textarea id="conteudo-info" name="conteudo" class="form-control" rows="5" placeholder="Escreva aqui o conteúdo da informação" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Inserir na página de informações
                    </button>
                </form>
            </div>
        </div>

        <h4 class="mt-5"><i class="bi bi-envelope-at"></i> Enviar Newsletter</h4>
        <hr>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="../../actions/processa_envio_newsletter.php" method="POST">
                    <div class="mb-3">
                        <label for="assunto-email" class="form-label font-weight-bold">Assunto do Email</label>
                        <input type="text" id="assunto-email" name="assunto" class="form-control" placeholder="Ex: Novidades de Páscoa na Doces Dias!" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mensagem-email" class="form-label font-weight-bold">Mensagem</label>
                        <textarea id="mensagem-email" name="mensagem" class="form-control" rows="5" placeholder="Escreva aqui a mensagem para todos os seus clientes..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Enviar para todos os subscritores
                    </button>
                </form>
            </div>
        </div>

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