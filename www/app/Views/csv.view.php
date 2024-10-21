<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
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
                </table>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->