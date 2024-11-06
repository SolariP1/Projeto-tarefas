<?php
include 'conecta.php';

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? null;
$email = $_POST['email'] ?? null;
$botao = $_POST['botao'] ?? null;

$response = ["sucesso" => false, "mensagem" => ""];

switch ($botao) {
    case 'consulta':
        if ($id) {
            $sql = "SELECT * FROM usuarios WHERE usu_codigo = '$id'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $response = [
                    "sucesso" => true,
                    "usu_nome" => $row['usu_nome'],
                    "usu_email" => $row['usu_email'],
                    "mensagem" => "Cliente encontrado."
                ];
            } else {
                $response["mensagem"] = "Usuario não encontrado.";
            }
        } else {
            $response["mensagem"] = "Código do usuario não informado.";
        }
        break;

    case 'inserir':
        if ($nome && $email) {
            $sql = "INSERT INTO usuarios (usu_nome, usu_email) VALUES ('$nome', '$email')";
            $response["mensagem"] = mysqli_query($conn, $sql) ? "Gravado com sucesso!" : "Erro ao gravar: " . mysqli_error($conn);
            $response["sucesso"] = true;
        } else {
            $response["mensagem"] = "Preencha todos os campos!";
        }
        break;

    case 'alterar':
        if ($id && $nome && $email) {
            $sql = "UPDATE usuarios SET usu_nome = '$nome', usu_email = '$email' WHERE usu_codigo = '$id'";
            $response["mensagem"] = mysqli_query($conn, $sql) ? "Atualizado com sucesso!" : "Erro ao atualizar: " . mysqli_error($conn);
            $response["sucesso"] = true;
        } else {
            $response["mensagem"] = "Preencha todos os campos!";
        }
        break;

    case 'excluir':
        if ($id) {
            $sql = "DELETE FROM usuarios WHERE usu_codigo = '$id'";
            $response["mensagem"] = mysqli_query($conn, $sql) ? "Excluído com sucesso!" : "Erro ao excluir: " . mysqli_error($conn);
            $response["sucesso"] = true;
        } else {
            $response["mensagem"] = "Código do cliente não informado.";
        }
        break;

    default:
        $response["mensagem"] = "Ação inválida.";
}
mysqli_close($conn);
echo json_encode($response);
?>
