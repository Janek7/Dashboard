<?php
global $user;
?>

<div class="col-md-9">
    <div class="row">
        <!-- ID Box -->
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-bookmark-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ID</span>
                    <span class="info-box-number"><?php echo $user->getId(); ?></span>
                </div>
            </div>
        </div>
        <!-- Register Date Box -->
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-green-gradient"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Registriert seit</span>
                    <span class="info-box-number">
                        <?php echo $user->getRegisterDate(); ?>
                    </span>
                </div>
            </div>
        </div>
        <!-- Mail Box -->
        <div class="col-md-4">
            <div class="info-box">
                <span id="stateColor" class="info-box-icon bg-teal-gradient"><i
                            class="fa fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Email</span>
                    <span id="stateText" class="info-box-number"><?php echo $user->getEmail(); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Login Box -->
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-maroon-gradient"><i class="fa fa-sign-in"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Logins</span>
                    <span class="info-box-number"><?php echo $user->getLogins(); ?></span>
                </div>
            </div>
        </div>
        <!-- Viewed Pages Box -->
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Aufgerufene Seiten</span>
                    <span class="info-box-number">
                        <?php echo $user->getViewedPages(); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="row">
        <div class="box box-danger" id="actionsBox">
            <div class="box-header">
                <h3 class="box-title">Aktionen</h3>
            </div>
            <div class="box-body text-center">
                <a class="btn btn-app bg-teal" id="changeStateButton"><i class="fa fa-spinner"></i>Test</a>
                <!--
                <a class="btn btn-app" id="changeTitleButton"><i class="fa fa-edit"></i>Titel</a>
                <a class="btn btn-app bg-green" id="workstepButton"><i class="fa fa-wrench"></i>Arbeitsschritt</a>
                <a class="btn btn-app bg-aqua" id="gitButton"><i class="fa fa-code-fork"></i>Git</a>
                <a class="btn btn-app bg-orange" id="languageButton"><i class="fa fa-code"></i>Sprachen</a>
                <a class="btn btn-app bg-blue" id="addDescButton"><i class="fa fa-edit"></i>Beschreibung</a>
                <a class="btn btn-app" id="deleteButton"><i class="fa fa-ban"></i>Löschen</a>
                -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Profilbild</h3>
            </div>
            <div class="box-body text-center">
                <img src="<?php echo $user->getIcon(); ?>" width="150" height="150" class="img-circle" alt="User Image"/>
                <a class="btn btn-app bg-blue" id="uploadImgBtn"><i class="fa fa-cloud-upload"></i>Speichern</a>
            </div>
        </div>

    </div>
</div>

<!-- upload image modal-->
<div id="uploadImgModal" class="model-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button id="closeUploadImgModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Profilbild hochladen</h4>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" class="form-horizontal" action="functions/uploadUserImage.php" method="POST">
                <div class="box-body">
                    <div class="form-group">
                        <label for="userImageLink" class="col-sm-2 control-label">Bild</label>
                        <div class="col-sm-10">
                            <input id="userImageLink" name="userImageLink" type="text" required="required"
                                   value="<?php echo $user->getIcon() != "images/user.png" ? $user->getIcon() : ""; ?>"/>
                            <!--
                            <input type="hidden" name="MAX_FILE_SIZE" value=8000000" />
                            <input name="userimage" type="file" required="required"/>
                            -->
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>
