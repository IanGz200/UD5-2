<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <?php
        if (count($registros) > 1) {
        ?>
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <?php
                    $primerRegistro = true;
                    foreach ($registros as $row){
                        if ($primerRegistro){
                        ?>
                        <thead>
                        <tr>
                            <?php
                            foreach ($row as $dato) {
                                ?>
                                <th><?php echo $dato; ?></th>
                                <?php
                            }
                            $primerRegistro = false;
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        }
                        else {
                            ?>
                            <tr>
                                <?php
                                foreach ($row as $dato) {
                                    ?>
                                    <td><?php echo $dato; ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                    <?php
                    if(isset($min) && isset($max)){
                    ?>
                    <tfoot>
                        <tr>
                            <td>
                                <?php echo $max[0]; ?>
                            </td>
                            <td>
                                <?php echo $max[1]; ?>
                            </td>
                            <td>
                                <?php echo $showMinMax ? 'MAX' : ''; ?>
                            </td>
                            <td>
                                <?php echo number_format(num: $max[3], thousands_separator: '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $min[0]; ?>
                            </td>
                            <td>
                                <?php echo $min[1]; ?>
                            </td>
                            <td>
                                <?php echo $showMinMax ? 'MIN' : ''; ?>
                            </td>
                            <td>
                                <?php echo number_format(num: $min[3], thousands_separator: '.'); ?>
                            </td>
                        </tr>
                    </tfoot>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
        }
        else{
            ?>
            <div class="alert alert-warning" role="alert">
                No hay registros en el fichero seleccionado
            </div>
        <?php
        }
        ?>
    </div>
</div>
<!--Fin HTML -->