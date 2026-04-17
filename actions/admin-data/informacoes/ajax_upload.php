<?php
// Ajusta o caminho para o teu db.php
require_once __DIR__ . '/../../../includes/db.php';

$post_order = isset($_POST["post_order_ids"]) ? $_POST["post_order_ids"] : [];

header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false];

if(is_array($post_order) && count($post_order) > 0){
    $updated = true;
    $stmt = $con->prepare("UPDATE informacoes SET ordem = ? WHERE id = ?");
    for($order_no = 0; $order_no < count($post_order); $order_no++)
    {
        $id = $post_order[$order_no];
        $nova_posicao = $order_no + 1;
        
        $stmt->bind_param("ii", $nova_posicao, $id);
        if(!$stmt->execute()){
            $updated = false;
        }
    }
    $stmt->close();
    if($updated){
        mysqli_query($con, "SET @rank = 0");
        mysqli_query($con, "UPDATE informacoes SET ordem = (@rank := @rank + 1) ORDER BY ordem ASC");
    }
    $response['success'] = $updated;
}

echo json_encode($response);
?>