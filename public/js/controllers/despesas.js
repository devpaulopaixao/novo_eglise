var app = angular.module("despesasModule", ['datatables']);

app.factory("Despesas", function() {
    return {
        arr_despesas: [],
    };
});

app.controller("despesasController", function(
    Despesas,
    $scope,
    $http,
    $timeout,
    $compile,
    DTOptionsBuilder,
    DTColumnBuilder,
    DTColumnDefBuilder
) {
    var language = {
        "sEmptyTable": "Nenhum registro encontrado",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "_MENU_ resultados por página",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sZeroRecords": "Nenhum registro encontrado",
        "sSearch": "Pesquisar ",
        "oPaginate": {
            "sNext": "Próximo",
            "sPrevious": "Anterior",
            "sFirst": "Primeiro",
            "sLast": "Último"
        },
        "oAria": {
            "sSortAscending": ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
        },
        "select": {
            "rows": {
                "_": "Selecionado %d linhas",
                "0": "Nenhuma linha selecionada",
                "1": "Selecionado 1 linha"
            }
        }
    }

    $scope.vm = {};

    $scope.vm.dtOptions = DTOptionsBuilder.newOptions()
      .withOption('order', [0, 'asc'])
      .withOption('responsive', true)
      .withLanguage(language);

    $scope.vm.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3),
        DTColumnDefBuilder.newColumnDef(4).notSortable()
    ];

        $http
            .get(
                "api/getdespesasemaberto/",
                {
                    headers: {
                        SameSite: "Strict"
                    }
                }
            )
            .then(function(response) {
                Despesas.arr_despesas = response.data;
                $scope.despesas = Despesas.arr_despesas;
            });

            $scope.create = function() {
                console.log('create');
                /*$http
                    .get("api/cursos/" + $scope.empresa + "/" + $scope.ano)
                    .then(function(response) {
                        Planejamento.cursos = response.data;
                        $scope.cursos = Planejamento.cursos;
                    });*/
            };

            $scope.edit = function() {
                console.log('Edit');
                /*$http
                    .get("api/cursos/" + $scope.empresa + "/" + $scope.ano)
                    .then(function(response) {
                        Planejamento.cursos = response.data;
                        $scope.cursos = Planejamento.cursos;
                    });*/
            };

            $scope.delete = function() {
                console.log('Delete');
                /*$http
                    .get("api/cursos/" + $scope.empresa + "/" + $scope.ano)
                    .then(function(response) {
                        Planejamento.cursos = response.data;
                        $scope.cursos = Planejamento.cursos;
                    });*/
            };
});
