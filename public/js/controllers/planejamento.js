var app = angular.module("planejamentoModule", []);

app.factory("Planejamento", function() {
    return {
        empresas: [],
        anos: [],
        cursos: [],
        series: [],
        disciplinas: [],
        turmas: [],
        planoA: [],
        planoB: [],
        tabelaA: [],
        tabelaB: []
    };
});

app.controller("planejamentoController", function(
    Planejamento,
    $scope,
    $http,
    $timeout,
    $compile
) {
    var arr_displ = [];
    $scope.loading = false;

    $scope.empresa = "";
    $scope.ano = "";
    $scope.curso = "";
    $scope.serie = "";
    $scope.disciplina = "";
    $scope.etapa = "";
    $scope.turmaA = "";
    $scope.turmaB = "";

    $scope.nomeA = "";
    $scope.nomeB = "";

    $scope.planoA = [];
    $scope.planoB = [];

    $scope.tabelaA = [];
    $scope.tabelaB = [];

    $scope.noloading = function() {
        $timeout(function() {
            $scope.loading = false;
        }, 800);
    };

    $http.get("api/empresas").then(function(response) {
        Planejamento.empresas = response.data;
        $scope.empresas = Planejamento.empresas;
    });

    $scope.obtemAnos = function() {
        $scope.loading = true;
        $http.get("api/anos/" + $scope.empresa).then(function(response) {
            Planejamento.anos = response.data;
            $scope.anos = Planejamento.anos;
        });
        $scope.noloading();
    };

    $scope.obtemCursos = function() {
        $scope.loading = true;
        $http
            .get("api/cursos/" + $scope.empresa + "/" + $scope.ano)
            .then(function(response) {
                Planejamento.cursos = response.data;
                $scope.cursos = Planejamento.cursos;
            });
        $scope.noloading();
    };

    $scope.obtemSeries = function() {
        $scope.loading = true;
        $http
            .get(
                "api/series/" +
                    $scope.empresa +
                    "/" +
                    $scope.ano +
                    "/" +
                    $scope.curso
            )
            .then(function(response) {
                Planejamento.series = response.data;
                $scope.series = Planejamento.series;
            });
        $scope.noloading();
    };

    $scope.obtemDisciplinas = function() {
        $scope.loading = true;
        $http
            .get(
                "api/disciplinas/" +
                    $scope.empresa +
                    "/" +
                    $scope.ano +
                    "/" +
                    $scope.curso +
                    "/" +
                    $scope.serie,
                {
                    headers: {
                        SameSite: "Strict"
                    }
                }
            )
            .then(function(response) {
                Planejamento.disciplinas = response.data;
                $scope.disciplinas = Planejamento.disciplinas;
            });
        $scope.noloading();
    };

    $scope.obtemTurmas = function() {
        $scope.loading = true;
        $http
            .get(
                "api/turmas/" +
                    $scope.empresa +
                    "/" +
                    $scope.ano +
                    "/" +
                    $scope.curso +
                    "/" +
                    $scope.serie,
                {
                    headers: {
                        SameSite: "Strict"
                    }
                }
            )
            .then(function(response) {
                Planejamento.turmas = response.data;
                $scope.turmas = Planejamento.turmas;
            });
        $scope.noloading();
    };

    $scope.obtemNomesTurmas = function() {
        $scope.nomeA = Planejamento.turmas.filter(function(turma) {
            if (turma.COD_IDENT_TURMA == $scope.turmaA) {
                console.log(turma.TXT_DESCR_TURMA);
                return turma.TXT_DESCR_TURMA;
            }
        });

        $scope.nomeB = Planejamento.turmas.filter(function(turma) {
            if (turma.COD_IDENT_TURMA == $scope.turmaB) {
                console.log(turma.TXT_DESCR_TURMA);
                return turma.TXT_DESCR_TURMA;
            }
        });
    };

    $scope.obtemDisciplina = async function(codigo) {
        console.log(codigo);
        Planejamento.disciplinas.filter(function(disciplina) {
            if (disciplina.COD_IDENT_DISPL == codigo) {
                console.log(disciplina.TXT_NOMEX_DISPL);
                return disciplina.TXT_NOMEX_DISPL;
            }
        });
    };

    $scope.obtemPlanos = async function() {
        await $scope.obtemNomesTurmas();
        await $scope.obtemPlanoA();
        await $scope.obtemPlanoB();
        await $scope.analise();
    };

    $scope.analise = function() {
        var divElement = angular.element(document.querySelector("#alertas"));
        var htmlElement = angular.element("Etapa " + $scope.etapa);
        divElement.append(htmlElement);

        Planejamento.disciplinas.filter(function(disciplina, i) {
            if (
                disciplina.COD_IDENT_DISPL == Planejamento.planoA[i].codigo &&
                disciplina.COD_IDENT_DISPL == Planejamento.planoB[i].codigo
            ) {
                for (let x in Planejamento.planoA[i].planos) {
                    if (
                        Planejamento.planoA[i].planos[x].ATIVIDADE !=
                            Planejamento.planoB[i].planos[x].ATIVIDADE ||
                        Planejamento.planoA[i].planos[x].VALOR !=
                            Planejamento.planoB[i].planos[x].VALOR ||
                        Planejamento.planoA[i].planos[x].UUID !=
                            Planejamento.planoB[i].planos[x].UUID
                    ) {
                        if (Planejamento.tabelaA.length == 0) {
                            Planejamento.planoA[i].planos[x].etapa =
                                $scope.etapa;
                            Planejamento.planoB[i].planos[x].etapa =
                                $scope.etapa;
                            arr_displ.push(Planejamento.planoA[i].codigo);
                            Planejamento.tabelaA.push(
                                Planejamento.planoA[i].planos[x]
                            );
                            Planejamento.tabelaB.push(
                                Planejamento.planoB[i].planos[x]
                            );
                        } else {
                            let exist = false;
                            Planejamento.tabelaA.filter(function(plano) {
                                if (
                                    plano.COD_IDENT_DISPL ==
                                        Planejamento.planoA[i].planos[x]
                                            .COD_IDENT_DISPL &&
                                    plano.ATIVIDADE ==
                                        Planejamento.planoA[i].planos[x]
                                            .ATIVIDADE
                                ) {
                                    exist = true;
                                }
                            });
                            if (!exist) {
                                Planejamento.planoA[i].planos[x].etapa =
                                    $scope.etapa;
                                Planejamento.planoB[i].planos[x].etapa =
                                    $scope.etapa;
                                if (!arr_displ.includes(Planejamento.planoA[i].codigo)) {
                                    arr_displ.push(Planejamento.planoA[i].codigo);
                                }
                                Planejamento.tabelaA.push(
                                    Planejamento.planoA[i].planos[x]
                                );
                                Planejamento.tabelaB.push(
                                    Planejamento.planoB[i].planos[x]
                                );
                            }
                        }
                        console.table(Planejamento.tabelaA);
                    }
                }
            } else {
                console.log(false);
            }
        });

        //console.log(arr_displ);

        $scope.tabelaA = Planejamento.tabelaA;
        $scope.tabelaB = Planejamento.tabelaB;

        //Clear HTML
        angular.element(document.querySelector('#ajustes')).html('');

        var divElement = angular.element(document.querySelector('#ajustes'));
        
        var htmlElement = angular.element('<h4>#1 ATUALIZAR ATIVIDADES DA TURMA QUE NÃO ESTÃO NA LISTA DE INCONSISTÊNCIAS</h4>');
        divElement.append(htmlElement);

        htmlElement = angular.element('<div class"row">UPDATE DB_SGE_SCHOOL.tbl_SGE_AVALIACOES_ALUNO SET COD_IDENT_TURMA = ' + $scope.turmaB
            + ' WHERE COD_IDENT_EMPRE = ' + $scope.empresa
            + ' AND COD_IDENT_TURMA = ' + $scope.turmaA
            + ' AND COD_REGTO_ALUNO = $aluno'
            + ' AND COD_IDENT_DISPL NOT IN  (' + arr_displ +')'
            + ' AND NUM_ANOXX_LETIV = ' + $scope.ano
            + ';</div>');
        divElement.append(htmlElement);

        var htmlElement = angular.element('<h4>#2 CORRIGIR ATIVIDADES DE ORIGEM PARA DESTINO</h4>');
        divElement.append(htmlElement);

        for (let i in Planejamento.tabelaA){
            htmlElement = angular.element('<div class"row">UPDATE DB_SGE_SCHOOL.tbl_SGE_AVALIACOES_ALUNO SET COD_IDENT_TURMA = ' + $scope.turmaB
                + ' , COD_IDENT_ATIVD = ' + Planejamento.tabelaB[i].ATIVIDADE
                + ' WHERE COD_IDENT_EMPRE = ' + $scope.empresa
                + ' AND NUM_ANOXX_LETIV = ' + $scope.ano
                + ' AND COD_IDENT_CURSO = ' + $scope.curso
                + ' AND COD_IDENT_SERIE = ' + $scope.serie
                + ' AND COD_IDENT_TURMA = ' + $scope.turmaA
                + ' AND COD_REGTO_ALUNO = $aluno'
                + ' AND COD_IDENT_DISPL = ' + Planejamento.tabelaA[i].COD_IDENT_DISPL
                + ' AND COD_IDENT_ATIVD = ' + Planejamento.tabelaA[i].ATIVIDADE
                + ';</div>');
            divElement.append(htmlElement);
        }


        /*Planejamento.tabelaA.filter(function (plano) { 
            
        });*/

        /*
        var divElement = angular.element(document.querySelector('#alertas'));
        var htmlElement = angular.element('<p>Disciplinas A: ' + (Planejamento.planoA.length) + '</br>' + 'Disciplinas B->' + (Planejamento.planoB.length) + '</p>');
        divElement.append(htmlElement);

        $compile(divElement)($scope);*/
    };

    $scope.obtemPlanoA = function() {
        $scope.loading = true;
        $http
            .get(
                "api/plano/" +
                    $scope.empresa +
                    "/" +
                    $scope.curso +
                    "/" +
                    $scope.serie +
                    "/" +
                    $scope.turmaA +
                    "/" +
                    ($scope.etapa == "" ? "T" : $scope.etapa) +
                    "/" +
                    $scope.ano,
                {
                    headers: {
                        SameSite: "Strict"
                    }
                }
            )
            .then(function(response) {
                Planejamento.planoA = response.data.planejamento;
                $scope.planoA = Planejamento.planoA;
            });
        $scope.noloading();
    };

    $scope.obtemPlanoB = function() {
        $scope.loading = true;
        $http
            .get(
                "api/plano/" +
                    $scope.empresa +
                    "/" +
                    $scope.curso +
                    "/" +
                    $scope.serie +
                    "/" +
                    $scope.turmaB +
                    "/" +
                    ($scope.etapa == "" ? "T" : $scope.etapa) +
                    "/" +
                    $scope.ano,
                {
                    headers: {
                        SameSite: "Strict"
                    }
                }
            )
            .then(function(response) {
                Planejamento.planoB = response.data.planejamento;
                $scope.planoB = Planejamento.planoB;
            });
        $scope.noloading();
    };

    /*$scope.obtem = function() {
      console.log($scope.curso);
    }*/
});
