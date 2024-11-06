<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuarios</title>
    <style>
        section { text-align: center; }
    </style>
    <script>
        function enviarFormulario(botao) {
            const formData = new FormData();
            formData.append('id', document.getElementById("id").value);
            formData.append('nome', document.getElementById("nome").value);
            formData.append('email', document.getElementById("email").value);
            formData.append('botao', botao);

            fetch('usuarios_modify.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mensagem").innerHTML = data.mensagem;

                    if (botao === 'consulta' && data.sucesso) {
                        document.getElementById("nome").value = data.usu_nome;
                        document.getElementById("email").value = data.usu_email;
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById("mensagem").innerHTML = "Erro ao realizar a operação.";
                });
        }
    </script>
</head>
<body>
<section>
    <h1>Cadastro de Usuarios</h1>
    <div>
        <label>Código:</label>
        <input type="text" id="id"><button onclick="enviarFormulario('consulta')">Buscar</button><br><br>
        <label>Nome:</label>  
        <input type="text" id="nome"><br><br>
        <label>Email:</label>
        <input type="text" id="email"><br><br>
        </select>
    </div>
    <button onclick="enviarFormulario('inserir')">Inserir</button>
    <button onclick="enviarFormulario('alterar')">Alterar</button>
    <button onclick="enviarFormulario('excluir')">Excluir</button><br><br>
    <p id="mensagem"></p>
    <a href="principal.php"><button>Sair</button></a>
</section>
</body>
</html>
