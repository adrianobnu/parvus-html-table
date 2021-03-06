<?php
    namespace Parvus;

    define ('TABLE_ALIGN_CENTER','center');
    define ('TABLE_ALIGN_LEFT','left');
    define ('TABLE_ALIGN_RIGHT','right');

    class HTMLTable
    {

        private $htmlTbody = NULL, $htmlThead = NULL, $htmlFilter = NULL;
        private $aHeader = array();
        private $aBody   = array();
        private $aFooter = array();
        private $hasDataTable = true;
        private $tableClass = 'table table-bordered table-hover table-striped';
        private $buttonClass = 'btn btn-default btn-xs';
        private $inputClass = 'form-control input-sm';
        private $aOrderby = array();
				private $ajaxURL = NULL;

				/**
         * Return the body
         * @return array
         */
        public final function getBody ()
        {

            return $this->aBody;

        }

				/**
         * Return the headers
         * @return array
         */
        public final function getHeader ()
        {

            return $this->aHeader;

        }

        /**
         * Define the order of the columns
         * Ex: array ('col' => 'asc', 'col2' => 'desc')
         * @param $prArray
         */
        public final function orderby ($prArray)
        {

            foreach ($prArray as $label => $value)
            {

                if (is_numeric($label))
                {
                    $label = $value;
                    $value = 'asc';
                }

                $this->aOrderby[$label] = $value;

            }

        }
			
				/**
         * Set the ajax URL from data table
         * @param $prURL
         */
        public final function setAjaxURL ($prURL)
        {

            $this->ajaxURL = $prURL;

        }

				/**
         * Override the default input class
         * @param $prValue
         */
        public final function setInputClass ($prValue)
        {

            $this->inputClass = $prValue;

        }

        /**
         * Override the default table class
         * @param $prValue
         */
        public final function setTableClass ($prValue)
        {

            $this->tableClass = $prValue;

        }
        
        /**
         * Override the default button class
         * @param $prValue
         */
        public final function setButtonClass ($prValue)
        {

            $this->buttonClass = $prValue;

        }

        /**
         * Define to not use DataTables in the table
         */
        public final function setNoDataTable ()
        {

            $this->hasDataTable = false;

        }

        /**
         * Add a <th>
         * @param $prLabel
         * @param null $prWidth
         * @param null $prAlign
         * @param null $prMask
         * @param bool|true $prSort
         */
        public final function th ($prLabel,$prWidth = NULL, $prAlign = NULL, $prMask = NULL, $prSort = true)
        {

            $this->htmlThead .= '<th class="'.($prSort ? NULL : 'no-sort').'" width="'.$prWidth.'" align="'.$prAlign.'">';

                $this->htmlThead .= $prLabel;

            $this->htmlThead .= '</th>';

            if ($this->hasDataTable)
            {

                $this->htmlFilter .= '<td align="center">';

                    if ($prSort)
                    {

                        $this->htmlFilter .= '<input ordem="'.sizeof($this->aHeader).'" type="text" autocomplete="off" class="'.$this->inputClass.' '.$prMask.'" />';

                    }

                $this->htmlFilter .= '</td>';

            }

            array_push($this->aHeader, array (
                'label' => $prLabel,
                'align' => $prAlign
            ));

        }

        /**
         * Add a <th> in foot
         * @param $prLabel
         * @param $prValue
         */
        public final function tfoot ($prLabel,$prValue)
        {

            $this->aFooter[$prLabel] = $prValue;

        }

        /**
         * Add a <td>
         * @param $prArrayItem
         * @param $prArray
         */
        public final function td ($prArrayItem,$prArray = NULL)
        {

						$aItem = array();

            $this->htmlTbody .= '<tr '.$this->attribute($prArray).'>';

                foreach ($prArrayItem as $ordem => $item)
                {

                    unset ($orderby,$label);

                    if (is_array($item))
                    {
                        $label   = $item['label'];
                        $orderby = $item['value'];
                    }
                    else
                    {
                        $label   = $item;
                        $orderby = str_replace(' ',NULL,strip_tags(trim($item)));
                    }

                    $this->htmlTbody .= '<td align="'.$this->aHeader[$ordem]['align'].'" data-order="'.$orderby.'">'.$label.'</td>';

										array_push($aItem,$label);

                }

            $this->htmlTbody .= '</tr>';

						array_push($this->aBody,$aItem);

        }
			
				/**
				 * Return the length of rows
				 */
				public final function getRowLength()
				{
				
						return sizeof($this->aBody);
					
				}

        /**
         * Return a link button
         * @param $prLabel
         * @param $prURL
         * @return string
         */
        public final function button ($prLabel,$prURL,$prArray = NULL)
        {

            return '<a href="'.$prURL.'" class="'.$this->buttonClass.'" '.$this->attribute($prArray).'>'.$prLabel.'</a>';

        }

        /**
         * Return the HTML
         * @return string
         */
        public final function html ($prArray = NULL)
        {

            if ($prArray['id'] == NULL)
            {
                $prArray['id'] = md5(time()).rand(1,999).uniqid().md5(uniqid());
            }

            $html = '<table class="'.($this->hasDataTable ? 'grid' : NULL).' '.$this->tableClass.'" '.$this->attribute($prArray).'>';

                if ($this->htmlThead != NULL)
                {

                    $html.= '<thead>';

                        $html.= '<tr>';

                            $html .= $this->htmlThead;

                        $html.= '</tr>';

                        if ($this->hasDataTable)
                        {

                            $html.= '<tr class="filter">';

                                $html .= $this->htmlFilter;

                            $html.= '</tr>';

                        }

                    $html.= '</thead>';

                }

                if ($this->htmlTbody != NULL)
                {

                    $html.= '<tbody>';

                        $html .= $this->htmlTbody;

                    $html.= '</tbody>';

                }

                if ($this->aFooter != NULL)
                {

                    $html.= '<tfoot>';

                        foreach ($this->aHeader as $th)
                        {

                            if ($this->aFooter[$th['label']] != NULL)
                            {

                                $html.= '<th style="text-align: '.$th['align'].'">'.$this->aFooter[$th['label']].'</td>';

                            }
                            else
                            {
                                $html.= '<th></th>';
                            }

                        }

                    $html.= '</tfoot>';

                }

            $html .= '</table>';


            $javascript = '$(function() {

                var table = $("#'.$prArray['id'].'").DataTable({
										"lengthMenu"		: [ [10, 25, 50, 100, 300, 500, 700, 1000, 2000, -1], [10, 25, 50, 100, 300, 500, 700, 1000, 2000, "Tudo"] ],
										"pageLength"		: 100,
										'.($this->ajaxURL != NULL ? '"ajax" : "'.url.$this->ajaxURL.'",' : NULL).'
                    "retrieve"      : true,
                    "bRetrieve"     : true,
                    "destroy"	    	: true,
                    "responsive"    : true,
                    "bSortCellsTop" : true,
                    "columnDefs"    : [ {
                        "targets"   : "no-sort",
                        "orderable" : false
                    }],
                    language        : {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sInfo": "Mostrando de _START_ at?? _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 at?? 0 de 0 registros",
                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "Exibindo _MENU_ resultados por p??gina",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar:",
                        "oPaginate": {
                            "sNext": "Pr??ximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "??ltimo"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        }
                    }
                });

                $("#'.$prArray['id'].'").find("thead input[type=text],thead select").on("keyup change", function ()
                {

                    table.column($(this).attr("ordem")).search(this.value).draw();

                });';

                /** Se tem ordena????o **/
                if ($this->aOrderby != NULL)
                {

                    $javascript .= chr(10).'table.order(';

                        $orderFilter = 1;

                        /** Varre os campos **/
                        foreach ($this->aHeader as $order => $item)
                        {

                            if ($this->aOrderby[$item['label']] != NULL)
                            {

                                if ($orderFilter > 1)
                                {
                                    $javascript .= ',';
                                }

                                $javascript .= '['.$order.', "'.$this->aOrderby[$item['label']].'"]';

                                $orderFilter ++;

                            }

                        }

                    $javascript.= ').draw();';

                }

            $javascript .= '});';

            return array (
                'html'          => $html,
                'javascript'    => $this->hasDataTable ? $javascript : NULL,
                'id'            => $prArray['id']
            );

        }

        /**
         * @param $prArray
         * @return null|string
         */
        private final function attribute ($prArray)
        {
            $return = NULL;

            foreach (array_filter($prArray) as $label => $value)
            {

                $return .= $label.'="'.$value.'" ';

            }

            return $return;
        }

    }
