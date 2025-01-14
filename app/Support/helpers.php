<?php

if (!function_exists('checkOrderColumn')) {

    /**
     * Verifica se a coluna informada esta dentro das colunas disponiveis para ordenação.
     *
     * @param [type] $column
     * @param [type] $avaiableColumns
     * @param [type] $columnDefault
     * @return $column
     */
    function checkOrderColumn($column, $avaiableColumns, $columnDefault) {
        $column = in_array($column, $avaiableColumns) ? $column : $columnDefault;
        return $column;
    }

}

if (!function_exists('getWheresQuery')) {

    /**
     * Obtém as condições where por base na pesquisa e colunas informadas.
     *
     * @param [type] $query
     * @param [type] $search
     * @param [type] $columns
     * @return $query
     */
    function getWheresQuery($query, $search, $columns) {

        $query->where(function($query) use ($search, $columns) {

            foreach ($columns as $column) {
                $query->OrWhereRaw($column." like '%".$search."%'");
            }

        });

        return $query;

    }

}

if (!function_exists('getSerialCode')) {

    /**
     * Obtém o número de cadastro / número registro.
     *
     * @return $number
     */
    function getSerialCode($id) {
        $code = "00000".$id;
        return $code;
    }

}

if (!function_exists('getLimitValues')) {

    /**
     * Obtém o limite de valores por página.
     *
     * @param array $addValues
     * @return $limitValues
     */
    function getLimitValues($addValues = []) {

        $limitValues = [10, 25, 50, 100];

        if ($addValues && count($addValues) > 0) {
            
            foreach($addValues as $value) {
                array_push($limitValues, $value);
            }

        }

        return $limitValues;

    }

}
