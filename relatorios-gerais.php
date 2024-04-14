<?php include("header.php")    ; ?>

            <!-- TITULO e cabeçalho das paginas  -->
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3><img src="relatorios.jpg" width="100" height="100">
                        Relatorios<br></h3>
                        <!-- <p class="text-subtitle text-muted">Examples for opt-in styling of tables (given their prevalent use in JavaScript plugins) with Bootstrap.</p> -->
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class='breadcrumb-header'>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Relatórios</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6">

                    <div class="panel panel-default">
                    <div class="panel-heading">Financeiro</div>
                    <div class="panel-body">

                                <ul  >
                                    
                                    <li>
                                        <a href="rel-ranking-geral.php">Ranking de contribuição geral</a>
                                    </li>           
                                    <li>
                                        <a href="rel-ranking-capacidade.php">Ranking de contribuição por Capacidade</a>
                                    </li>     
                                                            
                                    <li>
                                        <a href="inadimplentes.php">Inadimplentes</a>
                                    </li>     

                                    <li>
                                        <a href="rel-financeiro.php">Relatório Financeiro</a>
                                    </li>                                                                                                                                     
                                
                                </ul>              

                    
                    </div>
                    </div>
                
                </div>
            



            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Campos</div>
                            <div class="panel-body">

                                    
                                <ul>
                                    <li>
                                        <a href="rel-cadastros-por-regiao.php">Cadastros por Região</a>
                                    </li>     
                                                                <li>
                                        <a href="rel-cadastros-inativos.php">Campos  Inativos</a>
                                    </li> 
                                                                <li>
                                        <a href="rel-cadastros-ce.php">Campos Evangelisticos</a>
                                    </li> 
                                                                <li>
                                        <a href="rel-cadastros-campo-missionario.php">Campos NACIONAIS</a>
                                    </li> 
                                                                <li>
                                        <a href="rel-cadastros-campo-missionario-trans.php">Campos TRANSCULTURAIS</a>
                                    </li>                    

                                </ul>

                            
                            </div>
                        </div>
                
                </div>
            </div>    
            

            <div class="row">
                <div class="col-lg-6">

                    <div class="panel panel-default">
                        <div class="panel-heading">Administrativo</div>
                            <div class="panel-body">
                            <ul>
                                <li>
                                    <a href="etiquetas.php">Etiquetas</a>
                                </li>     
                                <li>
                                    <a href="rel-followup.php">Relatório de Follow-up</a>
                                </li>     
                                <li>
                                    <a href="rel-emails.php">Listagem de Emails</a>
                                </li>   
                            </ul>            

                            
                            </div>
                        </div>
                    
                    </div>
                </div>


                <!-- /.row -->


                
                <div class="row">
                    <div class="col-lg-2">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        
                        </div>
                </div>
            </div>
                
               

<?php include("footer.php")    ; ?>