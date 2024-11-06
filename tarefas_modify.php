<?php
include 'conecta.php';

$id = $_POST['id'] ?? null;
$setor = $_POST['setor'] ?? null;
$descricao = $_POST['descricao'] ?? null;
$prioridade = $_POST['prioridade'] ?? null;
$usu_codigo = $_POST['usu_codigo'] ?? null; 
$botao = $_POST['botao'] ?? null;

$response = ["sucesso" => false, "mensagem" => ""];

switch ($botao) {
    case 'inserir':
        if ($setor && $descricao && $prioridade && $usu_codigo) { 
            $sql = "INSERT INTO tarefas (tar_setor, tar_descricao, tar_prioridade, tar_status, usu_codigo) VALUES ('$setor', '$descricao', '$prioridade', 'à fazer', '$usu_codigo')";
            
            if (mysqli_query($conn, $sql)) {
                $response["sucesso"] = true;
                $response["mensagem"] = "Tarefa cadastrada com sucesso!";
            } else {
                $response["mensagem"] = "Erro ao cadastrar tarefa: " . mysqli_error($conn);
            }
        } else {
            $response["mensagem"] = "Preencha todos os campos!";
        }
        break;
}

mysqli_close($conn);
echo json_encode($response);
?>
