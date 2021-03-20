$(document).ready(function () {
  loadBrands();

  $('#selectBrand').change(function () {
    var brandId = this.value;
    loadModels(brandId);
  });

  $('#btnSearch').click(function (event) {
    event.preventDefault();
    var modelId = $('#selectModel').val();
    loadAds(modelId);
  });
});

function loadBrands() {
  var $selectBrand = $('#selectBrand');
  $.ajax({
    url: 'api/getBrands',
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function () {
      $selectBrand.html(
        $('<option>', {
          value: '-1',
          text: 'Carregando...',
        }),
      );
    },
    success: function (data) {
      $selectBrand
        .empty()
        .html(
          $('<option>', {
            value: -1,
            text: 'Selecione...',
          }),
        )
        .append(
          data.map(function (brand) {
            return $('<option>', {
              value: brand.id,
              text: brand.description,
            });
          }),
        );
    },
    error: function (error) {
      console.log(error);
    },
  });
}

function loadModels(brandId) {
  var $selectModel = $('#selectModel');

  $.ajax({
    url: 'api/getModels/' + brandId,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function () {
      $selectModel.html(
        $('<option>', {
          value: '-1',
          text: 'Carregando...',
        }),
      );
    },
    success: function (data) {
      $selectModel.empty().html(
        data.map(function (model) {
          return $('<option>', {
            value: model.id,
            text: model.description,
          });
        }),
      );
    },
    error: function (error) {
      console.log(error);
    },
  });
}

function loadAds(modelId) {
  console.log(modelId);
  $.ajax({
    url: 'api/getAds/' + modelId,
    type: 'GET',
    dataType: 'JSON',
    beforeSend: function () {
      const $table = $('.container').find('table');
      $table.remove();
    },
    success: function (data) {
      const $table = $('<table>', { class: 'table table-hover' });

      $table
        .append($('<tr><th>Description</th></tr>'))
        .append(
          data.map(function (ad) {
            return $('<tr><td>' + ad.description + '</td></tr>');
          }),
        )
        .appendTo('.container');
    },
    error: function (error) {
      console.log(error);
    },
  });
}
