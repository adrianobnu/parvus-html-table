# Parvus HTML Table

Create HTML tables for Datables with Bootstrap 3.

            $table = new \Parvus\HTMLTable();

            $table->th('Nome');
            $table->th('E-mail');
            $table->th('Celular',115,TABLE_ALIGN_CENTER,'telefone');
            $table->th('Telefone',115,TABLE_ALIGN_CENTER,'telefone');
            $table->th('Ação',100,TABLE_ALIGN_CENTER,NULL,false);

            foreach (\Model\Usuario::orderby('nome')->get() as $item)
            {

                $table->td(array (
                    $item->nome,
                    $item->email,
                    $item->celular,
                    $item->telefone,
                    $table->button('Editar','usuario/form?id='.$item->id)
                ));

            }
            
            print ($table->html());

Javascript for Datables
            
    var grid = $('table.grid');

    if (grid.length > 0)
    {

        grid.DataTable({
            "bSortCellsTop" : true,
            "columnDefs"    : [ {
                "targets"   : 'no-sort',
                "orderable" : false
            }],
            language        : {
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
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });

        var table = grid.DataTable();

        grid.find('input,select').on('keyup change', function ()
        {

            table.column($(this).attr('ordem')).search(this.value).draw();

        });

    }
