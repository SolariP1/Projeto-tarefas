<?php
include 'conecta.php';

$sql = "SELECT tar_codigo, tar_setor, tar_descricao, tar_prioridade, tar_status FROM tarefas";
$queryTarefas = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        header {
            background-color: #3880fc;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            border-radius: 50%;
            width: 80px;
        }

        header h1 {
            margin-left: 10px;
            font-size: 2rem;
        }

        nav {
            background-color: #3880fc;
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 25px;
            background-color: #444;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #3880fc;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #3880fc;
            color: white;
        }

        .statusSelect {
            width: 100%;
        }

        .btn-update, .btn-delete {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-update {
            background-color: #3880fc;
        }

        .btn-delete {
            background-color: #e74c3c;
        }
    </style>
    <script>
        function atualizarStatus(tarefaId) {
            const status = document.getElementById('status-' + tarefaId).value;
            const formData = new FormData();
            formData.append('tar_codigo', tarefaId);
            formData.append('status', status);

            fetch('atualizar_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("mensagem").innerHTML = data.mensagem;
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById("mensagem").innerHTML = "Erro ao atualizar o status.";
            });
        }

        function excluirTarefa(tarefaId) {
            if (confirm("Tem certeza de que deseja excluir esta tarefa?")) {
                const formData = new FormData();
                formData.append('tar_codigo', tarefaId);

                fetch('excluir_tarefa.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mensagem").innerHTML = data.mensagem;
                    if (data.sucesso) {
                        document.getElementById('tarefa-' + tarefaId).remove();
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById("mensagem").innerHTML = "Erro ao excluir a tarefa.";
                });
            }
        }
    </script>
</head>
<body>
    <header>
        <div style="display: flex; align-items: center;">
            <img src="images.png" alt="Logo da Agenda">
            <h1>Controle das Tarefas</h1>
        </div>
        <nav>
            <a href="principal.php">Menus</a>
            <a href="tarefas.php">Home</a>
            <a href="gerenciar.php">Gerenciar tarefas</a>
        </nav>
    </header>

    <section>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Setor</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($queryTarefas) > 0) {
                    while ($linhaTarefa = mysqli_fetch_assoc($queryTarefas)) {
                        echo "<tr id='tarefa-{$linhaTarefa['tar_codigo']}'>";
                        echo "<td>{$linhaTarefa['tar_codigo']}</td>";
                        echo "<td>{$linhaTarefa['tar_setor']}</td>";
                        echo "<td>{$linhaTarefa['tar_descricao']}</td>";
                        echo "<td>{$linhaTarefa['tar_prioridade']}</td>";
                        echo "<td>
                                <select id='status-{$linhaTarefa['tar_codigo']}' class='statusSelect'>
                                    <option value='à fazer' " . ($linhaTarefa['tar_status'] == 'à fazer' ? 'selected' : '') . ">À fazer</option>
                                    <option value='em andamento' " . ($linhaTarefa['tar_status'] == 'em andamento' ? 'selected' : '') . ">Em andamento</option>
                                    <option value='concluído' " . ($linhaTarefa['tar_status'] == 'concluído' ? 'selected' : '') . ">Concluído</option>
                                </select>
                              </td>";
                        echo "<td>
                                <button onclick='atualizarStatus({$linhaTarefa['tar_codigo']})' class='btn-update'>Atualizar</button>
                                <button onclick='excluirTarefa({$linhaTarefa['tar_codigo']})' class='btn-delete'>Excluir</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhuma tarefa encontrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <p id="mensagem"></p>
    </section>
</body>
</html>

<?php mysqli_close($conn); ?>
