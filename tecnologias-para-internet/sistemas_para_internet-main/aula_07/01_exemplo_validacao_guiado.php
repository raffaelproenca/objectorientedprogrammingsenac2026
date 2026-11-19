<?php
/*
===============================================================================
AULA PRÁTICA — CONSTRUINDO UM FORMULÁRIO COM VALIDAÇÃO EM PHP
===============================================================================
OBJETIVO: construir um cadastro de nome, e-mail e idade, validando os dados.

ORDEM PARA CONSTRUIR COM A TURMA (não é a ordem em que o arquivo é executado):
  ETAPA 1 -> Desça até o HTML e monte o formulário (marcada abaixo).
  ETAPA 2 -> Volte ao início do arquivo e crie as variáveis.
  ETAPA 3 -> Detecte o envio do formulário via POST.
  ETAPA 4 -> Receba e limpe os dados.
  ETAPA 5 -> Valide nome, e-mail e idade.
  ETAPA 6 -> Prepare a mensagem de sucesso com saída segura.
  ETAPA 7 -> Volte ao HTML para preservar os campos e exibir a mensagem.

DICA AO PROFESSOR: escreva uma etapa por vez, execute e pergunte aos alunos
"O que acontece se...?" antes de mostrar a resposta.
===============================================================================
*/

// ============================================================================
// ETAPA 2 — CRIAR AS VARIÁVEIS (FAZER DEPOIS DO HTML DA ETAPA 1)
// ============================================================================
// PERGUNTE: quando a página abre pela primeira vez, já existe algum cadastro?
// Não. Por isso os campos começam vazios.
$nome = "";
$email = "";
$idade = "";

// Onde guardaremos o erro de validação OU a confirmação de cadastro?
$mensagem = "";

// PRÓXIMO PASSO -> ETAPA 3: descobrir se o usuário clicou em "Cadastrar".

// ============================================================================
// ETAPA 3 — VERIFICAR SE O FORMULÁRIO FOI ENVIADO
// ============================================================================
// TESTE EM SALA: antes do clique no botão, esta condição deve ser falsa.
// Depois do clique, o formulário envia os dados usando o método POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ========================================================================
    // ETAPA 4 — RECEBER E LIMPAR OS DADOS
    // ========================================================================
    // PERGUNTE: o atributo "name" de cada <input> serve para quê?
    // É a chave usada por $_POST para localizar o valor enviado.
    // ?? "" define um texto vazio se o campo não tiver sido enviado.
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $idade = $_POST["idade"] ?? "";

    // trim() remove espaços no começo e no fim da string.
    // EXPERIÊNCIA: envie "   Ana   " e veja por que faz sentido limpar.
    $nome = trim($nome);
    $email = trim($email);

    // PRÓXIMO PASSO -> ETAPA 5: não basta receber; é preciso verificar.

    // ========================================================================
    // ETAPA 5 — VALIDAR AS ENTRADAS UMA CONDIÇÃO DE CADA VEZ
    // ========================================================================
    // Comece só pelo nome. Depois acrescente os dois elseif.

    // 5A — Campo obrigatório: string vazia não pode ser aceita.
    if ($nome === "") {
        $mensagem = "O nome é obrigatório.";

    // 5B — E-mail: filter_var() testa o formato esperado.
    // O ! significa "não". Logo, entra aqui se o e-mail NÃO for válido.
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Informe um e-mail válido.";

    // 5C — Idade: aqui usamos conversão simples para inteiro.
    // EXEMPLOS: 0 e -3 são inválidos.
    // ATENÇÃO: esta verificação é introdutória, não valida todos os formatos.
    } elseif ((int) $idade <= 0) {
        $mensagem = "Informe uma idade válida.";

    // Somente se NENHUMA condição anterior acusou erro, chegamos aqui.
    } else {
        // ====================================================================
        // ETAPA 6 — GERAR MENSAGEM DE SUCESSO COM SAÍDA SEGURA
        // ====================================================================
        // PERGUNTE: e se alguém digitar <h1>Ana</h1> como nome?
        // htmlspecialchars() faz o navegador exibir essas marcas como TEXTO,
        // em vez de interpretá-las como elementos HTML.
        // ENT_QUOTES também converte aspas simples e duplas.
        // "UTF-8" define a codificação usada nessa conversão.
        $nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, "UTF-8");
        $emailSeguro = htmlspecialchars($email, ENT_QUOTES, "UTF-8");

        // O ponto (.) concatena, ou seja, une partes de texto.
        $mensagem = "Cadastro realizado: " . $nomeSeguro . " - " . $emailSeguro;
    }

    // TESTE APÓS A ETAPA 5:
    // 1. Nome vazio -> "O nome é obrigatório."
    // 2. E-mail "teste" -> "Informe um e-mail válido."
    // 3. Idade 0 -> "Informe uma idade válida."
    // 4. Dados válidos -> mensagem de sucesso.
}
?>

<!-- ========================================================================
     ETAPA 1 — COMECE A AULA AQUI: CONSTRUIR A INTERFACE HTML
     ========================================================================
     1A. Escreva <!DOCTYPE html>, html, head e body.
     1B. Crie um título <h1>Cadastro</h1>.
     1C. Crie <form method="POST"> e os três campos.
     1D. Adicione o botão "Cadastrar".

     NESTE PRIMEIRO MOMENTO, NÃO PRECISA ESCREVER O PHP DOS ATRIBUTOS value.
     Teste o formulário; depois volte ao topo do arquivo (ETAPA 2).
     ======================================================================== -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Validação de formulário</title>
</head>
<body>
    <h1>Cadastro</h1>

    <!-- O método POST envia os dados do formulário para este mesmo arquivo. -->
    <form method="POST">
        <label for="nome">Nome:</label>
        <!-- "name" identifica o campo no $_POST; "id" o conecta ao label. -->
        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>"
        >
        <br><br>

        <label for="email">E-mail:</label>
        <input
            type="text"
            id="email"
            name="email"
            value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
        >
        <br><br>

        <label for="idade">Idade:</label>
        <input
            type="number"
            id="idade"
            name="idade"
            value="<?= htmlspecialchars($idade, ENT_QUOTES, 'UTF-8') ?>"
        >
        <br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <!-- ====================================================================
         ETAPA 7 — VOLTE AQUI DEPOIS QUE O PHP ESTIVER VALIDANDO
         ====================================================================
         7A. Coloque PHP no atributo value dos inputs (acima).
             Isso mantém o que foi digitado após o envio.
         7B. Use htmlspecialchars() também no value de cada input.
         7C. Mostre a mensagem abaixo apenas quando não estiver vazia.

         PERGUNTE: por que não precisamos escrever um echo para cada erro?
         Porque o PHP escolhe e guarda a mensagem na variável $mensagem.
         ==================================================================== -->
    <?php
    if ($mensagem !== "") {
        // Mensagem já contém texto definido no servidor; no caso de sucesso,
        // os dados do usuário foram escapados na ETAPA 6.
        echo "<p>{$mensagem}</p>";
    }
    ?>

    <!-- DESAFIO FINAL: tentem cadastrar com um campo vazio e depois corrigir. -->
</body>
</html>
