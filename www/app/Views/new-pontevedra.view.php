<div class="row">        
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Alta Población Pontevedra</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="municipio">Municipio:</label>
                                <input class="form-control" id="municipio" type="text" name="municipio" placeholder="Municipio" value="<?php echo $input['municipio'] ?? ''; ?>">
                                <p class="text-danger"><?php echo $errors['municipio'] ?? ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="sexo">Sexo:</label>
                                <select name="sexo" id="sexo" class="form-control">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($sexos as $sexo) {
                                        ?>
                                        <option value="<?php echo $sexo ?>" <?php echo isset($_POST['sexo']) && $_POST['sexo'] == $sexo ? 'selected' : ''; ?>><?php echo $sexo ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-danger"><?php echo $errors['sexo'] ?? ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="anho">Año:</label>
                                <select name="anho" id="anho" class="form-control select2">
                                    <?php
                                    for ($i = date('Y'); $i > date('Y') - 100; $i--) {
                                        ?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-danger"><?php echo $errors['anho'] ?? ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="poblacion">Población:</label>
                                <input class="form-control" id="poblacion" type="text" name="poblacion" placeholder="Población" value="<?php echo $input['poblacion'] ?? ''; ?>">
                                <p class="text-danger"><?php echo $errors['poblacion'] ?? ''; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/poblacion-pontevedra" value="" sclass="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Insertar registro" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

