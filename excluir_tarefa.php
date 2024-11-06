<?php
include 'conecta.php';

$tar_codigo = $_POST['tar_codigo'] ?? null;

$response = ["sucesso" => false, "mensagem" => ""];

if ($tar_codigo) {
    $sql = "DELETE FROM tarefas WHERE tar_codigo = $tar_codigo";
    if (mysqli_query($conn, $sql)) {
        $response["sucesso"] = true;
        $response["mensagem"] = "Tarefa excluída com sucesso!";
    } else {
        $response["mensagem"] = "Erro ao excluir tarefa: " . mysqli_error($conn);
    }
} else {
    $response["mensagem"] = "ID da tarefa é obrigatório para exclusão.";
}

mysqli_close($conn);
echo json_encode($response);
?>
