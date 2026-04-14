<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }

    // Buscar dados
    $result_bolos     = mysqli_query($con, "SELECT * FROM catalogo_bolos ORDER BY categoria_id ASC");
    $result_massas    = mysqli_query($con, "SELECT * FROM massas ORDER BY label ASC");
    $result_recheios  = mysqli_query($con, "SELECT * FROM recheios ORDER BY label ASC");
    $result_tamanhos  = mysqli_query($con, "SELECT * FROM tamanhos_produtos ORDER BY bolo_slug ASC, ordem ASC");
    $result_categorias = mysqli_query($con, "SELECT * FROM categorias ORDER BY id ASC");

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
    <title>Gestão de Bolos - Admin Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <div class="container my-5">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="menu-admin.php"><i class="bi bi-house"></i> Painel</a></li>
                <li class="breadcrumb-item active">Gestão de Bolos</li>
            </ol>
        </nav>

        <h1 class="mb-5"><i class="bi bi-cake2"></i> Gestão de Bolos</h1>

        <?php if ($mensagem): ?>
            <div class="alert alert-<?= $tipo === 'sucesso' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensagem) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>


        <!-- ==================== BOLOS ==================== -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-cake"></i> Catálogo de bolos</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoBolo">
                <i class="bi bi-plus-lg"></i> Novo bolo
            </button>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Slug</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_bolos) > 0): ?>
                    <?php while ($bolo = mysqli_fetch_assoc($result_bolos)): ?>
                    <tr>
                        <td>
                            <img src="../../<?= htmlspecialchars($bolo['imagem']) ?>"
                                 alt="<?= htmlspecialchars($bolo['nome']) ?>"
                                 style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                        </td>
                        <td><?= htmlspecialchars($bolo['nome']) ?></td>
                        <td><code><?= htmlspecialchars($bolo['slug']) ?></code></td>
                        <td><?= htmlspecialchars($bolo['descricao']) ?></td>
                        <td><?php
                        if($bolo['categoria_id'] == '1'){
                             echo "Bolos de aniversário";
                        } else if($bolo['categoria_id'] == '2'){
                            echo "Bolos de casamento"; 
                        } else if($bolo['categoria_id'] == '3'){
                            echo "Bolos de batizados";
                        } else if($bolo['categoria_id'] == '4'){
                            echo "Cupcakes/Doces Tradicionais";
                        }
                        ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-label = "Ativar/Desativar bolo">
                                    <?= $bolo['ativo'] == 1 ? 'Ativo' : 'Inativo' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-bolo.php?id=<?= $bolo['id'] ?>&ativo=1">Ativar</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-bolo.php?id=<?= $bolo['id'] ?>&ativo=0">Desativar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted">Nenhum bolo encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>


        <!-- ==================== MASSAS ==================== -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-layers"></i> Massas</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaMassa">
                <i class="bi bi-plus-lg"></i> Nova massa
            </button>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Label</th>
                    <th>Slug</th>
                    <th>Preço</th>
                    <th>Premium</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_massas) > 0): ?>
                    <?php while ($massa = mysqli_fetch_assoc($result_massas)): ?>
                    <tr>
                        <td><?= htmlspecialchars($massa['label']) ?></td>
                        <td><code><?= htmlspecialchars($massa['slug']) ?></code></td>
                        <td><?= number_format($massa['preco'], 2, ',', '.') ?>€</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-label = "Massa Normal/Premium">
                                    <?= $massa['premium'] == 1 ? 'Premium' : 'Normal' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-premium-massa.php?id=<?= $massa['id'] ?>&premium=1">Premium</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-premium-massa.php?id=<?= $massa['id'] ?>&premium=0">Normal</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-label = "Ativar/Desativar massa">
                                    <?= $massa['ativo'] == 1 ? 'Ativo' : 'Inativo' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-massa.php?id=<?= $massa['id'] ?>&ativo=1">Ativar</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-massa.php?id=<?= $massa['id'] ?>&ativo=0">Desativar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">Nenhuma massa encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>


        <!-- ==================== RECHEIOS ==================== -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-layers-half"></i> Recheios</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoRecheio">
                <i class="bi bi-plus-lg"></i> Novo recheio
            </button>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Label</th>
                    <th>Slug</th>
                    <th>Preço</th>
                    <th>Premium</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_recheios) > 0): ?>
                    <?php while ($recheio = mysqli_fetch_assoc($result_recheios)): ?>
                    <tr>
                        <td><?= htmlspecialchars($recheio['label']) ?></td>
                        <td><code><?= htmlspecialchars($recheio['slug']) ?></code></td>
                        <td><?= number_format($recheio['preco'], 2, ',', '.') ?>€</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-label = "Recheio premium/normal">
                                    <?= $recheio['premium'] == 1 ? 'Premium' : 'Normal' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-premium-recheio.php?id=<?= $recheio['id'] ?>&premium=1">Premium</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-premium-recheio.php?id=<?= $recheio['id'] ?>&premium=0">Normal</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-label = "Ativar/Desativar recheio">
                                    <?= $recheio['ativo'] == 1 ? 'Ativo' : 'Inativo' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-recheio.php?id=<?= $recheio['id'] ?>&ativo=1">Ativar</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-recheio.php?id=<?= $recheio['id'] ?>&ativo=0">Desativar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">Nenhum recheio encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>


        <!-- ==================== TAMANHOS ==================== -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4><i class="bi bi-rulers"></i> Tamanhos por produto</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoTamanho">
                <i class="bi bi-plus-lg"></i> Novo tamanho
            </button>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Bolo (slug)</th>
                    <th>Label</th>
                    <th>Slug</th>
                    <th>Preço</th>
                    <th>Ordem</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_tamanhos) > 0): ?>
                    <?php while ($tam = mysqli_fetch_assoc($result_tamanhos)): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($tam['bolo_slug']) ?></code></td>
                        <td><?= htmlspecialchars($tam['label']) ?></td>
                        <td><code><?= htmlspecialchars($tam['slug']) ?></code></td>
                        <td><?= number_format($tam['preco'], 2, ',', '.') ?>€</td>
                        <td><?= $tam['ordem'] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-label = "Ativar/Desativar tamanhos dos bolos">
                                    <?= $tam['ativo'] == 1 ? 'Ativo' : 'Inativo' ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-tamanho.php?id=<?= $tam['id'] ?>&ativo=1">Ativar</a></li>
                                    <li><a class="dropdown-item" href="../../actions/admin-data/alterar-ativo-tamanho.php?id=<?= $tam['id'] ?>&ativo=0">Desativar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted">Nenhum tamanho encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="menu-admin.php" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>

    </div>


    <!-- ==================== MODAIS ==================== -->

    <!-- Novo Bolo -->
    <div class="modal fade" id="modalNovoBolo" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-lg"></i> Novo bolo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form action="../../actions/admin-data/adicionar-bolo.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="nome_bolo">Nome</label>
                            <input type="text" name="nome" id="nome_bolo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug_bolo">Slug <small class="text-muted">(ex: bolo-chocolate)</small></label>
                            <input type="text" name="slug" id="slug_bolo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="descricao_bolo">Descrição</label>
                            <textarea name="descricao" id="descricao_bolo" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="categoria_bolo">Categoria ID</label>
                            <select name="categoria_id" id="categoria_bolo" class="form-select" required>
                                <?php
                                    $cats = mysqli_query($con, "SELECT * FROM categorias ORDER BY id ASC");
                                    while ($cat = mysqli_fetch_assoc($cats)):
                                ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome'] ?? $cat['id']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="imagem_bolo">Imagem</label>
                            <input type="file" name="imagem" id="imagem_bolo" class="form-control" accept="image/*" required>
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

    <!-- Nova Massa -->
    <div class="modal fade" id="modalNovaMassa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-lg"></i> Nova massa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form action="../../actions/admin-data/adicionar-massa.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="label_massa">Label <small class="text-muted">(nome visível)</small></label>
                            <input type="text" name="label" id="label_massa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug_massa">Slug <small class="text-muted">(ex: baunilha)</small></label>
                            <input type="text" name="slug" id="slug_massa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="preco_massa">Preço (€)</label>
                            <input type="number" step="0.01" min="0" name="preco" id="preco_massa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="premium_massa">Tipo</label>
                            <select name="premium" id="premium_massa" class="form-select">
                                <option value="0">Normal</option>
                                <option value="1">Premium</option>
                            </select>
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

    <!-- Novo Recheio -->
    <div class="modal fade" id="modalNovoRecheio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-lg"></i> Novo recheio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form action="../../actions/admin-data/adicionar-recheio.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="label_recheio">Label <small class="text-muted">(nome visível)</small></label>
                            <input type="text" name="label" id="label_recheio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug_recheio">Slug <small class="text-muted">(ex: brigadeiro)</small></label>
                            <input type="text" name="slug" id="slug_recheio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="preco_recheio">Preço (€)</label>
                            <input type="number" step="0.01" min="0" name="preco" id="preco_recheio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="premium_recheio">Tipo</label>
                            <select name="premium" id="premium_recheio" class="form-select">
                                <option value="0">Normal</option>
                                <option value="1">Premium</option>
                            </select>
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

    <!-- Novo Tamanho -->
    <div class="modal fade" id="modalNovoTamanho" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-lg"></i> Novo tamanho</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form action="../../actions/admin-data/adicionar-tamanho.php" method="POST">
                    <div class="modal-body">
                        <div class="alert alert-info py-2 small">
                            <i class="bi bi-info-circle"></i> O tamanho tem de ser associado ao slug de um bolo existente no catálogo.
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bolo_slug_tam">Slug do bolo <small class="text-muted">(ex: bolo-chocolate)</small></label>
                            <input type="text" name="bolo_slug" id="bolo_slug_tam" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="label_tam">Label <small class="text-muted">(ex: Tamanho Normal)</small></label>
                            <input type="text" name="label" id="label_tam" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug_tam">Slug <small class="text-muted">(ex: normal)</small></label>
                            <input type="text" name="slug" id="slug_tam" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="preco_tam">Preço (€)</label>
                            <input type="number" step="0.01" min="0" name="preco" id="preco_tam" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ordem_tam">Ordem</label>
                            <input type="number" min="1" name="ordem" id="ordem_tam" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>