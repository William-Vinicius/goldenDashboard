<!DOCTYPE html>
<html>
<head>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .selected {
      background-color: yellow;
      font-weight: bold;
    }
  </style>
  <script>
    window.addEventListener('DOMContentLoaded', function() {
      var colunas = document.querySelectorAll('.coluna');

      colunas.forEach(function(coluna, indice) {
        coluna.addEventListener('click', function() {
          selecionarColuna(indice + 1);
        });
      });

      function selecionarColuna(coluna) {
        var todasCelulas = document.querySelectorAll('th, td');
        todasCelulas.forEach(function(celula) {
          celula.classList.remove('selected');
        });

        var celulasColuna = document.querySelectorAll('th:nth-child(' + coluna + '), td:nth-child(' + coluna + ')');
        celulasColuna.forEach(function(celula) {
          celula.classList.add('selected');
        });
      }
    });
  </script>
</head>
<body>

<table>
  <tr>
    <th class="coluna">Coluna 1</th>
    <th class="coluna">Coluna 2</th>
    <th class="coluna">Coluna 3</th>
  </tr>
  <tr>
    <td>Dado 1</td>
    <td>Dado 2</td>
    <td>Dado 3</td>
  </tr>
  <tr>
    <td>Dado 4</td>
    <td>Dado 5</td>
    <td>Dado 6</td>
  </tr>
</table>

</body>
</html>
