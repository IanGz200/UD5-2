<?php

declare(strict_types=1);

?>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="username">Username<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="username" id="username"
                               value="<?php
                               echo $input['username'] ?? ''; ?>"
                               maxlength="50"
                               placeholder="my_username"
                               required/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['username'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="salarioBruto">Salario Bruto:</label>
                        <input type="text" class="form-control"
                               name="salarioBruto" id="salarioBruto"
                               value="<?php echo $input['salarioBruto'] ?? ''; ?>"
                               maxlength=""
                               placeholder="" />
                        <p class="text-danger small">
                            <?php
                            echo $errors['salarioBruto'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="retencionIRPF">Retención IRPF<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="retencionIRPF" id="retencionIRPF"
                               value="<?php
                               echo $input['retencionIRPF'] ?? ''; ?>"
                               maxlength=""
                               placeholder="30"
                               />
                        <p class="text-danger small">
                            <?php
                            echo $errors['retencionIRPF'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="id_rol">Rol:</label>
                        <select name="id_rol" id="id_rol" class="form-control">
                            <option value="">-</option>
                            <?php foreach ($roles as $role) {
                                ?>
                                <option value="<?php echo $role['id_rol'] ?>" <?php echo (isset($input['id_rol']) && $role['id_rol'] == $input['id_rol']) ? 'selected' : ''; ?>><?php echo ucfirst($role['nombre_rol']); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <p class="text-danger small"><?php echo $errors['id_rol'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="id_country">País:</label>
                        <select name="id_country" id="id_country" class="form-control select2">
                            <option value="">-</option>
                            <?php foreach ($countries as $country) {
                                ?>
                                <option value="<?php echo $country['id'] ?>" <?php echo (isset($input['id_country']) && $country['id'] == $input['id_country']) ? 'selected' : ''; ?>><?php echo ucfirst($country['country_name']); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <p class="text-danger small"><?php echo $errors['id_country'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-check">
                        <input
                                type="checkbox"
                                class="form-check-input"
                                id="activo"
                                name="activo"
                            <?php echo !empty($input['activo']) ? 'checked' : ''; ?>
                        />
                        <label class="form-check-label" for="activo">Usuario activo</label>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-filtro'; ?>" class="btn btn-danger">Cancelar</a>
                <input type="submit" value="Guardar cambios" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>
