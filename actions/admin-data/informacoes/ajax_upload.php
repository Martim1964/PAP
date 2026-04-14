<?php
// Ajusta o caminho para o teu db.php
require_once __DIR__ . '/../../../includes/db.php';

$post_order = isset($_POST["post_order_ids"]) ? $_POST["post_order_ids"] : [];

header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false];

if(is_array($post_order) && count($post_order) > 0){
    $updated = true;
    for($order_no = 0; $order_no < count($post_order); $order_no++)
    {
        $id = mysqli_real_escape_string($con, $post_order[$order_no]);
        $nova_posicao = $order_no + 1;
        
        $query = "UPDATE informacoes SET ordem = '$nova_posicao' WHERE id = '$id'";
        if(!mysqli_query($con, $query)){
            $updated = false;
        }
    }
    if($updated){
        mysqli_query($con, "SET @rank = 0");
        mysqli_query($con, "UPDATE informacoes SET ordem = (@rank := @rank + 1) ORDER BY ordem ASC");
    }
    $response['success'] = $updated;
}

echo json_encode($response);
?>