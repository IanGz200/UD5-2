<?php

declare(strict_types=1);
?>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Cambiar Nombre usuario</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control"
                                   name="username" id="username"
                                   value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario'; ?>"
                                   maxlength="50"
                                   placeholder="My Username" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <input type="submit" value="Guardar cambios" name="username_button" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Cambiar tema</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dark_mode" name="dark_mode" <?php echo isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="dark_mode" name="darkmode_button">Usar tema oscuro</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <input type="submit" value="Guardar cambios" name="darkmode_button" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>
