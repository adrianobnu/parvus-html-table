<?php
    namespace Parvus;

    define ('TABLE_ALIGN_CENTER','center');
    define ('TABLE_ALIGN_LEFT','left');
    define ('TABLE_ALIGN_RIGHT','right');

    class HTMLTable
    {

        private $htmlTbody = NULL, $htmlThead = NULL, $htmlFilter = NULL;
        private $aTh = array();

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
         * @param $prArray
         */
        public final function td ($prArray)
        {

            $this->htmlTbody .= '<tr>';

                foreach ($prArray as $ordem => $value)
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
        public final function button ($prLabel,$prURL)
        {

            return '<a href="'.$prURL.'" class="btn btn-default btn-xs">'.$prLabel.'</a>';

        }

        /**
         * Return the HTML
         * @return string
         */
        public final function html ()
        {

            $html = '<table class="grid table table-bordered table-hover table-striped">';

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

    }
