<?php

/**
 * @copyright Copyright &copy; Vitali Sydorenko, 2015
 * @package grid-data
 * @version 1.0.0
 */
class GridData
{
    private $extUrl = '';
    private $get = array();

    /**
     * @param $extUrl
     */
    public function __construct($extUrl = 'grid-data')
    {
        $this->extUrl = $extUrl;
        if (isset($_GET)) {
            $this->get = $_GET;
        }
    }

    /**
     * Creates a widget instance and runs it.
     * The widget rendering result is returned by this method.
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @return string the rendering result of the widget.
     */
    public function widget(array $config = array())
    {
        if (self::array_keys_exists(array('dataProvider', 'columns'), $config)) {
            return $this->render($config);
        }
        return false;
    }

    private function render($config)
    {
        $info = $this->generateData($config['columns'], $config['dataProvider']);
        $result = '';
        $result .= '<div style="overflow:scroll;max-height:700px;"><div class="table-responsive" style="overflow:hidden;display:inline-block;min-width:100%;">';
        $result .= '<table class="grid-data-table table table-striped" data-toggle="table">'; // data-height="200"
        $result .= '<thead>';
        $result .= '<tr>';
        foreach ($info['labels'] as $keyL => $label) {
            $result .= '<th>';
            //$result .= '<div style="position:fixed;">';
            $result .= $label;
            //$result .= '</div>';
            $result .= '</th>';
        }
        $result .= '</tr>';
        $result .= '</thead>';
        $result .= '<tbody>';
        foreach ($info['rows'] as $keyI => $row) {
            $regidString = 'data-pk = "' .$config['dataProvider'][$keyI]['regid'] .'"';
            $result .= '<tr>';
            foreach ($row as $key => $v) {
                $attributeName = $info['attributes'][$key];
                if ( array_key_exists($attributeName, $config['dataProvider'][$keyI]) ) {
                    if ( $config['dataProvider'][$keyI][$attributeName] !== $v ) {
                        $realData = 'data-value = "' . $config['dataProvider'][$keyI][$attributeName] .'"';
                    } else {
                        $realData = '';
                    }
                    $attributeString = 'data-attr = "' . $info['attributes'][$key] .'"';
                } else {
                    $attributeString = '';
                    $realData = '';
                }
                $result .= '<td ' . $attributeString . $realData . $regidString . '><div style="max-height:15px !important;display: block;white-space:nowrap;overflow:hidden;max-width:200px;">';
                $result .= $v;
                $result .= '</div></td>';
            }
            $result .= '</tr>';
        }
        $result .= '</tbody>';
        $result .= '</table>';
        $result .= '</div></div>';
        $result .= $this->assets();
        return $result;
    }

    private function assets()
    {
        $result = '<link rel="stylesheet" href="' . $this->extUrl . '/css/grid-data.css"/>';
        $result .= '<script src="' . $this->extUrl . '/js/grid-data.js"></script>';
        return $result;
    }

    /**
     * @param array $columns
     * @param array $rows
     * @return mixed
     */
    public function generateData(array $columns, array $rows)
    {
        $attributes = $result['attributes'] = $result['labels'] = $result['rows'] = array();
        $result['attributesExport'] = $result['labelsExport'] = $result['rowsExport'] = array();
        foreach ($columns as $attribute => $col_val) {
            $labelExport = false;
            if (!array_key_exists('type', $col_val) || !$col_val['type']) {
                $columns[$attribute]['type'] = 'attr';
            }
            if (!array_key_exists('visibleGrid', $col_val)) {
                $columns[$attribute]['visibleGrid'] = 'true';
            }
            if (!array_key_exists('visibleExport', $col_val)) {
                $columns[$attribute]['visibleExport'] = 'true';
            }
            if (!in_array($columns[$attribute]['type'], array('attr', 'new', 'template'), true)) {
                continue;
            }

            $label = $attribute;
            if ($columns[$attribute]['type'] === 'template') {
                switch ($attribute) {
                    case 'SerialColumn':
                        $label = '<span class="serial-column-label">#</span>';
                        $labelExport = '#';
                        break;
                    case 'CheckboxColumn':
                        $label = '<label><input type="checkbox" class="checkbox-column-label"></label>';
                        $columns[$attribute]['visibleExport'] = false;
                        break;
                    default:
                        continue;
                }
            } elseif (array_key_exists('label', $col_val)) {
                $label = $col_val['label'];
            }

            $attributes[] = $attribute;
            if ($columns[$attribute]['visibleGrid']) {
                $result['attributes'][] = $attribute;
                if ($columns[$attribute]['type'] === 'attr') {
                    $sortInfo = $this->getSortInfo($attribute);
                    $directionSymbol = '';
                    if ($sortInfo['direction'] === 'asc') {
                        $directionSymbol = ' <i class="fa fa-chevron-down"></a></th>';
                    } elseif ($sortInfo['direction'] === 'desc') {
                        $directionSymbol = ' </i><i class="fa fa-chevron-up"></i>';
                    }

                    $labelGrid = '<a href="' . $sortInfo['http_query'] . '"  title="' . $attribute . '"'
                        . $this->getOptions('labelOptions', $col_val) . '>'
                        . $label . $directionSymbol . '</a>';
                } else {
                    $labelGrid = '<span' . $this->getOptions('labelOptions', $col_val) . '>' . $label . '</span>';
                }
                $result['labels'][] = '<div class="grid-header"' . $this->getOptions('headerOptions', $col_val) . '>'
                    . $labelGrid . '</div>';
            }
            if ($columns[$attribute]['visibleExport']) {
                $result['attributesExport'][] = $attribute;
                $result['labelsExport'][] = $labelExport === false ? $label : $labelExport;
            }

        }
        foreach ($rows as $key => $data) {
            if (count($attributes)) {
                foreach ($attributes as $attribute) {
                    $value = '';
                    $valueExport = false;
                    if (array_key_exists('valueExport', $columns[$attribute])) {
                        $valueExport = $columns[$attribute]['valueExport']($data);
                    }
                    if (array_key_exists('value', $columns[$attribute])) {
                        $value = $columns[$attribute]['value']($data);
                    } else {
                        if ($columns[$attribute]['type'] === 'template') {
                            switch ($attribute) {
                                case 'SerialColumn':
                                    $value = $key + 1;
                                    break;
                                case 'CheckboxColumn':
                                    if (array_key_exists('attributeValue', $columns[$attribute])) {
                                        $value = '<label><input type="checkbox" class="checkbox-column" value="'
                                            . $data[$columns[$attribute]['attributeValue']] . '"></label>';
                                    }
                                    break;
                            }
                        } elseif ($columns[$attribute]['type'] === 'attr') {
                            $value = $data[$attribute];
                        }
                    }
                    if ($columns[$attribute]['visibleGrid']) {
                        $result['rows'][$key][] = $value;
                    }
                    if ($columns[$attribute]['visibleExport']) {
                        $result['rowsExport'][$key][] = $valueExport === false ? $value : $valueExport;
                    }
                }
            }

        }
        return $result;
    }


    /**
     * (PHP 4 &gt;= 4.0.7, PHP 5)<br/>
     * @param array $keys <p>
     * Value to check.
     * </p>
     * @param array $search <p>
     * An array with keys to check.
     * </p>
     * @return bool true on success or false on failure.
     */
    public static function array_keys_exists(array $keys, $search)
    {
        return count(array_intersect_key(array_flip($keys), $search)) === count($keys);
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getSortInfo($attribute)
    {
        $get = $this->get;
        $sortPrefix = '';
        $resultInfo['direction'] = '';
        if (array_key_exists('sort', $get)) {
            preg_match('/([-]?)(.*)/', (string)$get['sort'], $sortInfo);
            if ($attribute === $sortInfo[2]) {
                if ($sortInfo[1]) {
                    $resultInfo['direction'] = 'desc';
                } else {
                    $sortPrefix = '-';
                    $resultInfo['direction'] = 'asc';
                }
            }
        }
        $get['sort'] = $sortPrefix . $attribute;
        $resultInfo['http_query'] = static::getHttpQuery($get);
        return $resultInfo;
    }

    /**
     * @param $params
     * @param bool $new
     * @return string
     */
    public static function getHttpQuery($params, $new = true)
    {
        return ($new ? '?' : '') . http_build_query($params);
    }

    /**
     * @param $name
     * @param array $columnInfo
     * @return string
     */
    public function getOptions($name, array $columnInfo)
    {
        $options = '';
        if (array_key_exists($name, $columnInfo) && is_array($columnInfo['headerOptions'])
            && count($columnInfo[$name])
        ) {
            foreach ($columnInfo[$name] as $attribute => $value) {
                if ($attribute === 'style' && is_array($value)) {
                    $headerStyleValue = '';
                    if (count($value)) {
                        foreach ($value as $styleA => $styleV) {
                            $headerStyleValue .= $styleA . ': ' . $styleV . ';';
                        }
                    }
                    $options .= ' ' . $attribute . '="' . $headerStyleValue . '"';
                } else {
                    $options .= ' ' . $attribute . '="' . $value . '"';
                }
            }
        }
        return $options;
    }

}

