<?php
    namespace Parvus;

    define ('TABLE_ALIGN_CENTER','center');
    define ('TABLE_ALIGN_LEFT','left');
    define ('TABLE_ALIGN_RIGHT','right');

    class HTMLTable
    {

        private $htmlTbody = NULL, $htmlThead = NULL, $htmlFilter = NULL;
        private $aTh = array();
        private $hasDataTable = true;
        private $tableClass = 'table table-bordered table-hover table-striped';

        /**
         * Override the default table class
         * @param $prValue
         */
        public final function setTableClass ($prValue)
        {

            $this->tableClass = $prValue;

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


            $this->htmlFilter .= '<td align="center">';

                if ($prSort)
                {

                    $this->htmlFilter .= '<input ordem="'.sizeOf($this->aTh).'" type="text" autocomplete="off" class="form-control input-sm '.$prMask.'" />';

                }

            $this->htmlFilter .= '</td>';

            array_push($this->aTh, array (
                'align' => $prAlign
            ));

        }

        /**
         * Add a <td>
         * @param $prArrayItem
         * @param $prArray
         */
        public final function td ($prArrayItem,$prArray = NULL)
        {

            $this->htmlTbody .= '<tr '.$this->attribute($prArray).'>';

                foreach ($prArrayItem as $ordem => $value)
                {

                    $this->htmlTbody .= '<td align="'.$this->aTh[$ordem]['align'].'">'.$value.'</td>';

                }

            $this->htmlTbody .= '</tr>';

        }

        /**
         * Return a link button
         * @param $prLabel
         * @param $prURL
         * @return string
         */
        public final function button ($prLabel,$prURL,$prArray = NULL)
        {

            return '<a href="'.$prURL.'" class="btn btn-default btn-xs" '.$this->attribute($prArray).'>'.$prLabel.'</a>';

        }

        /**
         * Return the HTML
         * @return string
         */
        public final function html ($prArray = NULL)
        {

            $html = '<table class="'.($this->hasDataTable ? 'grid' : NULL).' '.$this->tableClass.'" '.$this->attribute($prArray).'>';

                if ($this->htmlThead != NULL)
                {

                    $html.= '<thead>';

                        $html.= '<tr>';

                            $html .= $this->htmlThead;

                        $html.= '</tr>';

                        $html.= '<tr class="filter">';

                            $html .= $this->htmlFilter;

                        $html.= '</tr>';

                    $html.= '</thead>';

                }

                if ($this->htmlTbody != NULL)
                {

                    $html.= '<tbody>';

                        $html .= $this->htmlTbody;

                    $html.= '</tbody>';

                }

            $html .= '</table>';

            return $html;

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
