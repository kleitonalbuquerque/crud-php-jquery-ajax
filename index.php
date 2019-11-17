<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Formulário de Usuário</title>
  <script src="js/jquery.js" type="text/javascript"></script>
  <style>
    label {
      display: block;
    }
    .window {
      display: none;
      width: 200px;
      height: 300px;
      position: absolute;
      left: 0;
      top: 0;
      background: #FFF;
      z-index: 9990;
      padding: 10px;
      border-radius: 10px;
    }
    #mascara {
      display: none;
      position: absolute;
      left: 0;
      top: 0;
      z-index: 9000;
      background-color: #000;
    }
    .fechar {
      display: block;
      text-align: right;
    }
  </style>
</head>
<body>
  <a href="#janela1" rel="modal">Novo Usuário</a>
  <!-- Tabela de exibição dos dados -->
  <div id="table">
    <table border="1px" cellpadding="5px" cellspacing="0">
      <tr>
        <td>ID</td>
        <td>Nome</td>
        <td>E-mail</td>
        <td>Senha</td>
      </tr>
      <?php
        // conexão com banco
        include 'conexao.php';
        // busca e lista todos os usuários do banco
        $select = "SELECT * FROM usuario";
        $result = mysql_query($select); // resultado do SELECT
        // enquanto houver usuários no banco ele insere uma nova linha e insere os dados
        while ($row = mysql_fetch_array($result)) {
          $id    = $row['ID_USUARIO'];
          $nome  = $row['NOME'];
          $email = $row['EMAIL'];
          $senha = $row['SENHA'];

          echo "<tr>
            <td>$id</td>
            <td>$nome</td>
            <td>$email</td>
            <td>$senha</td>
          </tr>";
        }
      ?>
    </table>

    <!-- modal que é aberto ao clicar em novo usuário -->
    <div class="window" id="janela1">
        <a href="#" class="fechar">X Fechar</a>
        <h4>Cadastro de usuário</h4>
        <form id="cadUsuario" action="" method="POST">
          <label for="">Nome: </label><input type="text" name="nome" id="nome" />
          <label for="">E-mail: </label><input type="text" name="email" id="email" />
          <label for="">Senha: </label><input type="text" name="senha" id="senha" />
          <br><br>
          <input type="button" value="Salvar" id="salvar">
        </form>
    </div>
    <div id="mascara"></div>
  </div>

  <script type="text/javascript" language="javascript">
  $(document).ready(function() {
    // Qd o usuário clicar em salvar será feito todos os passos abaixo
    $('#salvar').click(function() {
      var dados = $('#cadUsuario').serialize();

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'salvar.php',
        async: true,
        data: dados,,
        success: function(response) {
          location.reload();
        }
      });
      return false;
    });

    // script para abiri o modal
    $('a[rel=modal]').click(function(ev) {
      ev.preventDefault();
      
      var id          = $(this).attr('href');
      var alturaTela  = $(document).height();
      var larguraTela = $(window).width();

      // colocando o fundo preto
      $('#mascara').css({
        'height': alturaTela
        'widht': larguraTela,
        
      });
      $('#mascara').fadeIn(1000);
      $('#mascara').fadeTo('slow', 0.8);

      var left = ($(window).width() / 2) - ($(id).width() / 2);
      var top  = ($(window).height() / 2) - ($(id).height() / 2);

      $(id).css({'top': top, 'left': left});
      $(id).show();
    });

    $('#mascara').click(function() {
      $(this).hide();
      $('.window').hide();
    });

    $('.fechar').click(function(ev) {
      ev.preventDefault();
      $('#mascara').hide();
      $('.window').hide();
    });
  });
</script>
</body>
</html>

