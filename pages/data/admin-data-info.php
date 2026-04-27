<?php require_once __DIR__ . '/../../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../../css/app_style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ordenar Informacoes - Doces Dias</title>

    <style>
        .li-post-group {
            background: #f5f5f5;
            padding: 5px 10px;
            border-bottom: solid 1px #CFCFCF;
            margin-top: 5px;
        }

        .li-post-title {
            border-left: solid 4px #304d49;
            background: #a7d4d2;
            padding: 5px;
            color: #304d49;
            margin: 0px;
        }

        .show-more {
            background: #10c1b9;
            width: 100%;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 20px;
            display: none;
            margin: 0px;
            margin-top: 25px;
        }

        .li-post-desc {
            line-height: 15px !important;
            font-size: 12px;
            box-shadow: inset 0px 0px 5px #7d9c9b;
            padding: 10px;
            margin: 0px;
        }

        .panel-default{
            margin-bottom: 100px;
        }

        .post-data-list {
            max-height: 374px;
            overflow-y: auto;
        }

        .radio-inline {
            font-size: 20px;
            color: #c36928;
        }

        .progress, .progress-bar { height: 40px; line-height: 40px; display: none; }

        #post_list li
        {
            border: 1px solid #a7d4d2;
            cursor: move;
            margin-top: 10px;
        }

        #post_list li.ui-state-highlight {
            padding: 20px;
            background-color: #eaecec;
            border: 1px dotted #ccc;
            cursor: move;
            margin-top: 12px;
        }

        body.dark-mode .li-post-group {
            background: #1a1a1a;
            border-bottom: solid 1px #333;
        }

        body.dark-mode .li-post-title {
            background: #222;
            color: #ffffff;
            border-left: solid 4px #ff7aa2;
        }

        body.dark-mode #post_list li {
            border: 1px solid #333;
        }

        body.dark-mode #post_list li.ui-state-highlight {
            background-color: #2a2a2a;
            border: 1px dotted #555;
        }
    </style>
</head>
<body>
    <div class="all-content-wrapper">
        <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

        <main>
        <section class="container">
            <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="menu-admin.php"><i class="bi bi-house"></i> Painel</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Informações</li>
            </ol>
        </nav>
            <div class="form-group custom-input-space has-feedback">
                <div class="page-heading">
                    <h3 class="post-title">Ordenar Informações</h3>
                </div>
                <div class="page-body clearfix">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="alert icon-alert with-arrow alert-success form-alter" role="alert" style="display:none;">
                                        <i class="fa fa-fw fa-check-circle"></i>
                                        <span class="success-message">Página de informações atualizada com sucesso</span> 
                                        <!-- Mensagem criada após alteração da ordem via JavaScript -->
                                    </div>

                                    <div class="alert icon-alert with-arrow alert-danger form-alter" role="alert" style="display:none;">
                                        <i class="fa fa-fw fa-times-circle"></i>
                                        <span class="warning-message"> A lista está vazia ou ocorreu um erro. </span> 
                                        <!-- Caso a lista esteja vazia -->
                                    </div>

                                    <ul class="list-unstyled" id="post_list">
                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM informacoes ORDER BY ordem ASC"); //Ir buscar os dados da página de informações
                                    $rowCount = mysqli_num_rows($query); //Criar uma variável para a contagem dos dados

                                    if($rowCount > 0){
                                        while($row = mysqli_fetch_assoc($query)){ //Caso existam dados o numero seja adicionado a variavel $row
                                    ?>
                                        <li data-post-id="<?php echo $row["id"]; ?>">
                                            <div class="li-post-group">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4 class="li-post-title" style="flex-grow: 1;">
                                                        <?php echo htmlspecialchars($row["nome"]); // Titulo da informação em questão?> 
                                                    </h4>
                                                    
                                                    <div class="dropdown" style="margin-left: 15px;">
                                                        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="statusDropdown<?php echo $row["id"]; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <?php echo ($row['ativo'] == 1) ? 'Ativo' : 'Inativo'; //Para a alteração do estado da informação inserida?> 
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statusDropdown<?php echo $row["id"]; //Ativar/Desativar informação?>">
                                                            <li><a class="dropdown-item" href="../../actions/admin-data/informacoes/alterar-estado.php?id=<?= $row['id'] ?>&estado=1">Ativar informação</a></li> 
                                                            <li><a class="dropdown-item" href="../../actions/admin-data/informacoes/alterar-estado.php?id=<?= $row['id'] ?>&estado=0">Desativar informação</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }
                                    } else {
                                    ?>
                                        <li>
                                            <div class="li-post-group">
                                                <h5 class="li-post-title">Sem informações para ordenar.</h5> <?php //Caso não haja informações ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>

                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Formulário de envio -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-send"></i> Enviar nova informação</h5>
        </div>

        <div class="card-body p-4">
            <form action="../../actions/processa_nova_info.php" method="POST">

                <div class="mb-3">
                    <label for="assunto-email" class="form-label fw-semibold">
                        Assunto <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="assunto-email"
                        name="assunto"
                        class="form-control"
                        placeholder="Escreva aqui o assunto da informação..."
                        maxlength="150"
                        required
                    >
                    <div class="form-text">Máximo de 150 caracteres.</div>
                </div>

                <div class="mb-4">
                    <label for="mensagem-email" class="form-label fw-semibold">
                        Conteúdo da informação <span class="text-danger">*</span>
                    </label>
                    <textarea
                        id="mensagem-email"
                        name="mensagem"
                        class="form-control"
                        rows="8"
                        placeholder="Escreva aqui a informação que deseja enviar..."
                        required
                    ></textarea>
                </div>

                <!-- Pré-visualização -->
                <div class="mb-4">
                    <div id="preview-box" class="border rounded p-3 mt-3 bg-light d-none">
                        <p class="text-muted small mb-1 fw-semibold">ASSUNTO:</p>
                        <p id="preview-assunto" class="mb-3 fw-semibold"></p>

                        
                        <p class="text-muted small mb-1 fw-semibold">INFORMAÇÃO:</p>
                        <p id="preview-mensagem" class="mb-0" style="white-space: pre-wrap;"></p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-primary" id="btn-enviar">
                        <i class="bi bi-send-fill"></i> Enviar informação
                    </button>
                </div>

            </form>
        </div>
    </div>


        <!-- Botão de regresso -->
        <a href="menu-admin.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>

    </div>

    </main>



    <!--
    jQuery para manipular DOM, eventos e AJAX
-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <?php
    // jQuery UI para usar o Drag and Drop
    ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <?php
    // Bootstrap JS
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>

    <?php
    // Bootstrap Select parar melhora os campos <select> com estilo e pesquisa
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function(){ // Espera que toda a página esteja carregada
            // Ativa o sistema de arrastar e ordenar na lista
            $("#post_list").sortable({
            
                // Classe visual mostrada enquanto arrastas um item
                placeholder: "ui-state-highlight",

                // Função executada quando a ordem muda
                update: function(event, ui)
                {
                    // Array para guardar a nova ordem dos posts
                    var post_order_ids = new Array();

                    // Percorre todos os itens da lista
                    $('#post_list li').each(function(){
                        // Guarda o ID de cada item (data-post-id)
                        post_order_ids.push($(this).data("post-id"));
                    });

                    // Envia os dados para o servidor via AJAX
                    $.ajax({
                        // Ficheiro PHP que vai tratar da atualização
                        url: "../../actions/admin-data/informacoes/ajax_upload.php",
                        // Método de envio
                        method: "POST",
                        // Espera resposta em JSON
                        dataType: "json",

                        // Dados enviados (array com nova ordem)
                        data: {post_order_ids: post_order_ids},

                        // Desativa cache
                        cache: false,

                        // Se correr bem
                        success: function(response)
                        {
                            // Verifica se o servidor respondeu com sucesso
                            if(response && response.success){
                                $(".alert-danger").hide();   // esconde erro
                                $(".alert-success").show();  // mostra sucesso

                                // Atualiza a página após 0.7 segundos
                                setTimeout(function(){
                                    window.location.reload();
                                }, 700);
                            } else {
                                // Caso haja erro lógico
                                $(".alert-success").hide();
                                $(".alert-danger").show();
                            }
                        },

                        // Se houver erro técnico (ex: servidor não responde)
                        error: function(xhr, status, error) {
                            console.error('Ordenação falhou:', status, error, xhr.responseText);

                            $(".alert-success").hide();
                            $(".alert-danger").show();
                        }
                    });
                }
            });
        });
    </script>
    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>


