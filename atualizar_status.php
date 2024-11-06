<?php
include 'conecta.php';

$tar_codigo = $_POST['tar_codigo'] ?? null;
$status = $_POST['status'] ?? null;

$response = ["sucesso" => false, "mensagem" => ""];

if ($tar_codigo && $status) {
    $sql = "UPDATE tarefas SET tar_status = '$status' WHERE tar_codigo = $tar_codigo";
    if (mysqli_query($conn, $sql)) {
        $response["sucesso"] = true;
        $response["mensagem"] = "Status atualizado com sucesso!";
    } else {
        $response["mensagem"] = "Erro ao atualizar status: " . mysqli_error($conn);
    }
} else {
    $response["mensagem"] = "ID da tarefa e status são obrigatórios.";
}

mysqli_close($conn);
echo json_encode($response);
?>
