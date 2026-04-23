<?php
    // Importa a ligação à base de dados
    require_once __DIR__ . '/../../../includes/db.php';

    // Vai buscar o array enviado por AJAX com os IDs na nova ordem
    // Se não existir, usa um array vazio
    $post_order = isset($_POST["post_order_ids"]) ? $_POST["post_order_ids"] : [];

    // Define que a resposta deste ficheiro será em formato JSON
    header('Content-Type: application/json; charset=utf-8');

    // Cria uma resposta inicial com sucesso = false
    $response = ['success' => false];

    // Verifica se foi recebido um array e se tem pelo menos um elemento
    if(is_array($post_order) && count($post_order) > 0){

        // Variável de controlo para saber se tudo correu bem
        $updated = true;

        // Prepara a query para atualizar a ordem de cada registo
        $stmt = $con->prepare("UPDATE informacoes SET ordem = ? WHERE id = ?");

        // Percorre todos os IDs recebidos no array
        for($order_no = 0; $order_no < count($post_order); $order_no++)
        {
            // Guarda o ID atual
            $id = $post_order[$order_no];

            // Define a nova posição
            // +1 porque o array começa em 0 e a ordem normalmente começa em 1
            $nova_posicao = $order_no + 1;
            
            // Liga os valores à query preparada
            // "ii" significa integer, integer
            $stmt->bind_param("ii", $nova_posicao, $id);

            // Executa a atualização
            // Se falhar, marca $updated como false
            if(!$stmt->execute()){
                $updated = false;
            }
        }

        // Fecha o statement depois de terminar o ciclo
        $stmt->close();

        // Se todas as atualizações correram bem
        if($updated){
            // Cria uma variável temporária no MySQL
            mysqli_query($con, "SET @rank = 0");

            // Reorganiza todos os valores da coluna ordem de forma sequencial
            // Exemplo: 1, 2, 3, 4, 5...
            mysqli_query($con, "UPDATE informacoes SET ordem = (@rank := @rank + 1) ORDER BY ordem ASC");
        }

        // Guarda o resultado final na resposta JSON
        $response['success'] = $updated;
    }

    // Devolve a resposta ao JavaScript em formato JSON
    echo json_encode($response);
?>