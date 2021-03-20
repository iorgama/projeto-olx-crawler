<html>

<head>
  <meta charset="utf-8">
  <title>Projeto Crawler Olx</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="shortcut icon" href="img/favicon.ico">
</head>

<body>

  <div class="container">
    <form id="formAd">
      <div class="modal-header">
        <h5 class="modal-title">Buscar anúncio</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label for="txtTitle">Marca</label>
            <select class="form-control" id="selectBrand">
              <option value="-1">Selecione...</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="txtTitle">Modelo</label>
            <select class="form-control" id="selectModel">
              <option value="-1">Selecione...</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="btnSearch">Pesquisar</button>
        </div>
    </form>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
</body>

</html>