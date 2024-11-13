<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <input type="hidden" name="order" value="<?php echo $order; ?>"/>
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
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="salario_min">Salario:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_salar" id="min_salar" value="<?php echo $input['min_salar'] ?? ''; ?>" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salar" id="max_salar" value="<?php echo $input['max_salar'] ?? ''; ?>" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="retencion_min">Retención:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_retencion" id="min_retencion" value="<?php echo $input['min_retencion'] ?? ''; ?>" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_retencion" id="max_retencion" value="<?php echo $input['max_retencion'] ?? ''; ?>" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="id_country">Tipo:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2" data-placeholder="Países" multiple>
                                    <?php
                                    foreach ($countries as $country) {
                                        ?>
                                        <option value="<?php echo $country['id']; ?>" <?php echo (isset($input['id_country']) && in_array($country['id'], $input['id_country'])) ? 'selected' : ''; ?>>
                                            <?php echo $country['country_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
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
                        <th><a href="<?php echo $_ENV['host.folder'].'usuarios-filtro?'.$queryString.'order='.(($order == 1) ? '-' : ''); ?>1">Nombre de usuario</a> <?php if (abs($order) == 1) { ?><i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php } ?></th>
                        <th><a href="<?php echo $_ENV['host.folder'].'usuarios-filtro?'.$queryString.'order='.(($order == 2) ? '-' : ''); ?>2">Salario bruto</a> <?php if (abs($order) == 2) { ?><i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php } ?></th></th>
                        <th><a href="<?php echo $_ENV['host.folder'].'usuarios-filtro?'.$queryString.'order='.(($order == 3) ? '-' : ''); ?>3">Retención IRPF</a> <?php if (abs($order) == 3) { ?><i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php } ?></th></th>
                        <th>Salario Neto</th>
                        <th><a href="<?php echo $_ENV['host.folder'].'usuarios-filtro?'.$queryString.'order='.(($order == 4) ? '-' : ''); ?>4">Rol</a> <?php if (abs($order) == 4) { ?><i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php } ?></th></th>
                        <th><a href="<?php echo $_ENV['host.folder'].'usuarios-filtro?'.$queryString.'order='.(($order == 5) ? '-' : ''); ?>5">Nacionalidad</a> <?php if (abs($order) == 5) { ?><i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php } ?></th></th>
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