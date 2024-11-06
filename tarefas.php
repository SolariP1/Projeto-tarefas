<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle empresarial</title>
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

        section {
            padding: 40px;
            text-align: center;
        }

        section h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        section p {
            font-size: 1.1rem;
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            header img {
                margin-bottom: 10px;
            }

            nav {
                flex-wrap: wrap;
            }

            nav a {
                margin: 5px;
            }
        }
    </style>
    <script>
        function enviarFormulario(botao) {
            const formData = new FormData();
            formData.append('id', document.getElementById("id") ? document.getElementById("id").value : "");
            formData.append('setor', document.getElementById("setor").value);
            formData.append('descricao', document.getElementById("descricao").value);
            formData.append('prioridade', document.getElementById("prioridade").value);
            formData.append('usu_codigo', document.getElementById("usu_codigo").value);
            formData.append('botao', botao);

            fetch('tarefas_modify.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mensagem").innerHTML = data.mensagem;
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById("mensagem").innerHTML = "Erro ao realizar a operação.";
                });
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
    <div>
        <h1>Cadastrar uma tarefa:</h1>
        <label>Setor:</label>  
        <input type="text" id="setor"><br><br>
        
        <label>Descrição:</label>
        <input type="text" id="descricao"><br><br>
        
        <label>Prioridade:</label>
        <select name="prioridade" id="prioridade">
            <option value="alta">Alta</option>
            <option value="media">Média</option>
            <option value="baixa">Baixa</option>
        </select><br><br>

        <label>Usuário:</label>
        <select id="usu_codigo">
            <option value="">Selecione um usuário</option>
            <?php
            include 'conecta.php';
            $sql = "SELECT usu_codigo, usu_nome FROM usuarios";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['usu_codigo']}'>{$row['usu_nome']}</option>";
            }
            mysqli_close($conn);
            ?>
        </select><br><br>
    </div>

    <button onclick="enviarFormulario('inserir')">Inserir</button>
    
    <p id="mensagem"></p>
    </section>
</body>
</html>
