<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="username"
                                        id="username"
                                        value="<?php echo $input['username'] ?? ''; ?>"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="id_rol">Tipo:</label>
                                <select name="id_rol" id="id_rol" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $role) {
                                        ?>
                                        <option value="<?php echo $role['id_rol'] ?>" <?php echo (isset($input['id_rol']) && $role['id_rol'] == $input['id_rol']) ? 'selected' : ''; ?>><?php echo ucfirst($role['nombre_rol']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="nombre_completo">Nombre completo:</label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" value="" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="id_tipo">Tipo:</label>
                                <select name="id_tipo[]" id="id_tipo" class="form-control select2" data-placeholder="Tipo proveedor" multiple>
                                    <option value="">-</option>
                                    <option value="3" >Componentes móviles</option>
                                    <option value="4" >Componentes PC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="id_continente">Continente:</label>
                                <select name="id_continente" id="id_continente" class="form-control" data-placeholder="Continente">
                                    <option value="">-</option>
                                    <option value="1" >Europa</option>
                                    <option value="2" >Asia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="anho_fundacion">Año fundación:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_anho" id="min_anho" value="" placeholder="Mí­nimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_anho" id="max_anho" value="" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_ENV['host.folder']; ?>usuarios-filtro" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <?php
        if (!empty($usuarios)) {
            ?>
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-9"><h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6></div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped datatable">
                    <thead>
                    <tr>
                        <th>Nombre de usuario</th>
                        <th>Salario bruto</th>
                        <th>Retención IRPF</th>
                        <th>Salario Neto</th>
                        <th>Rol</th>
                        <th>Nacionalidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($usuarios as $usuario) {
                        ?>
                        <tr class="<?php echo !$usuario['activo'] ? 'table-danger' : ''; ?>">
                            <td><?php echo $usuario['username'] ?></td>
                            <td><?php echo number_format($usuario['salarioBruto'], 2, ',', '.'); ?></td>
                            <td><?php echo number_format($usuario['retencionIRPF'], 0) ?>%</td>
                            <td><?php echo str_replace([',', '.', '_'], ['_', ',', '.'], $usuario['salarioNeto']); ?></td>
                            <td><?php echo $usuario['nombre_rol'] ?></td>
                            <td><?php echo $usuario['country_name'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No hay usuarios que cumplan los requisitos seleccionados
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--Fin HTML -->