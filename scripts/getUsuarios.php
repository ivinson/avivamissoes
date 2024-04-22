<?php  

ini_set('display_errors',0);
ini_set('display_startup_erros',0);
error_reporting(0);

include('../config.php');

    /*
     * Script:    DataTables server-side script for PHP and MySQL
     * Copyright: 2010 - Allan Jardine, 2012 - Chris Wright
     * License:   GPL v2 or BSD (3-point)
     */
     
   

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */
     
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'id', 'Nome', 'NomePastor','Email', 'Cidade', 'UF' );
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "id";
     
    /* DB table to use */
    $sTable = "usuarios";


    $gaSql['user']       = Cons_UserBD;
    $gaSql['password']   = Cons_SenhaBD;
    $gaSql['db']         = Cons_NomeBanco;
    $gaSql['server']     = Cons_Servidor;



    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */

    // Executar consultas para definir a codificação para UTF-8
    $db->query("SET NAMES 'utf8'");
    $db->query("SET character_set_connection=utf8");
    $db->query("SET character_set_client=utf8");
    $db->query("SET character_set_results=utf8");
     
    /*
     * Local functions
     */
    function fatal_error ( $sErrorMessage = '' )
    {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
 
     
    /*
     * MySQL connection
     */
 // Tente conectar ao banco de dados
    if (!$db) {
        fatal_error('Could not open connection to server');
    }

 
    if (!$db->query("USE " . $gaSql['db'])) {
        fatal_error('Could not select database');
    }
     
     
    /*
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }else
    {

        $sOrder = " ORDER BY id DESC ";
    }
     
     
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".stripslashes( $_GET['sSearch'] )."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    /* Listar Inicialmente apenas CAMPOS ECLESIASTICOS */
    //$_GET['bSearchable_5']  = true; 
    //$_GET['sSearch_5']      = '6';

    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".stripslashes($_GET['sSearch_'.$i])."%' ";
        }
    }
     
     

        $db->query("SET NAMES 'utf8'");
        $db->query("SET character_set_connection=utf8");
        $db->query("SET character_set_client=utf8");
        $db->query("SET character_set_results=utf8");
     
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";

    // echo $sQuery;
    // die();

    $rResult = $db->query($sQuery)->results(true) or fatal_error('MySQL Error: ' . $db->errorInfo()[2]);

    // var_dump($rResult);
    // die();
     
    /* Data set length after filtering */
    $sQuery = "SELECT FOUND_ROWS()";
    $rResultFilterTotal = $db->query($sQuery) or fatal_error('MySQL Error: ' . $db->errorInfo()[2]);
    $aResultFilterTotal = $db->results(true); // Passando true para obter resultados como matriz associativa
    $iFilteredTotal = $aResultFilterTotal[0];

    /* Total data set length */
    $sQuery = "SELECT COUNT(".$sIndexColumn.") FROM $sTable";
    $rResultTotal = $db->query($sQuery) or fatal_error('MySQL Error: ' . $db->errorInfo()[2]);
    $aResultTotal = $db->results(true); // Passando true para obter resultados como matriz associativa
    $iTotal = $aResultTotal[0];

    /*
     * Output
     */
    $output = array(
        "draw" => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
        "recordsTotal" => $iTotal["COUNT(id)"],
        "recordsFiltered" =>$iFilteredTotal["FOUND_ROWS()"],
        "aaData" => array()
    );



     
    foreach ($rResult as $aRow) {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }
            else if ( $aColumns[$i] != ' ' )
            {
                /* General output */
                $row[] = $aRow[ $aColumns[$i] ];
            }
        }
        $output['aaData'][] = $row;
    }
     


    echo json_encode( $output );

?>