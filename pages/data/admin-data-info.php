<?php require_once __DIR__ . '/../../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
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
    </style>
</head>
<body>
    <div class="all-content-wrapper">
        <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>
        <section class="container">
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
                                    </div>

                                    <div class="alert icon-alert with-arrow alert-danger form-alter" role="alert" style="display:none;">
                                        <i class="fa fa-fw fa-times-circle"></i>
                                        <span class="warning-message"> A lista está vazia ou ocorreu um erro. </span>
                                    </div>

                                    <ul class="list-unstyled" id="post_list">
                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM informacoes ORDER BY ordem ASC");
                                    $rowCount = mysqli_num_rows($query);

                                    if($rowCount > 0){
                                        while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <li data-post-id="<?php echo $row["id"]; ?>">
                                            <div class="li-post-group">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="li-post-title" style="flex-grow: 1;">
                                                        <?php echo htmlspecialchars($row["nome"]); ?>
                                                    </h5>
                                                    
                                                    <div class="dropdown" style="margin-left: 15px;">
                                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="statusDropdown<?php echo $row["id"]; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <?php echo ($row['ativo'] == 1) ? 'Ativo' : 'Inativo'; ?>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statusDropdown<?php echo $row["id"]; ?>">
                                                            <li><a class="dropdown-item" href="../../actions/admin-data/informacoes/alterar-estado.php?id=<?= $row['id'] ?>&estado=1">Ativar conta</a></li>
                                                            <li><a class="dropdown-item" href="../../actions/admin-data/informacoes/alterar-estado.php?id=<?= $row['id'] ?>&estado=0">Desativar conta</a></li>
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
                                                <h5 class="li-post-title">Sem informações para ordenar.</h5>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function(){
            $( "#post_list" ).sortable({
                placeholder : "ui-state-highlight",
                update : function(event, ui)
                {
                    var post_order_ids = new Array();
                    $('#post_list li').each(function(){
                        post_order_ids.push($(this).data("post-id"));
                    });
                    
                    $.ajax({
                        url: "../../actions/admin-data/informacoes/ajax_upload.php",
                        method: "POST",
                        dataType: "json",
                        data: {post_order_ids: post_order_ids},
                        cache: false,
                        success: function(response)
                        {
                            if(response && response.success){
                                $(".alert-danger").hide();
                                $(".alert-success").show();
                                setTimeout(function(){
                                    window.location.reload();
                                }, 700);
                            } else {
                                $(".alert-success").hide();
                                $(".alert-danger").show();
                            }
                        },
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


