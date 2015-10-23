# Parvus HTML Table

Create HTML tables for Datables with Bootstrap 3.

    $table = new \Parvus\HTMLTable();
    
    $table->orderby(array('Nome', 'Celular' => 'desc'))
    
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
            array (
                'label' => '(44) 9999-9999',
                'value' => '44999999'
            ),
            $item->telefone,
            $table->button('Editar','usuario/form?id='.$item->id)
        ));
    
    }
    
    $aHTML = $table->html();
    
    print ($aHTML['html']);
    
    <script>
    
        print ($aHTML['javascript']);
    
    </script>
