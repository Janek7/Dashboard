<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 07.04.2018
 * Time: 14:30
 */

global $conn;
global $users;
global $roles;
?>

<div class="row">
    <div class="col-xs-12">
        <div id="successAlertBox" class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i><span id="successAlertText"></span></h4>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Nutzer</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Register Datum</th>
                        <th>Status</th>
                        <th>Permissions</th>
                        <th>letzte Aktivität</th>
                    </tr>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user->getId() ?></td>
                            <td><?php echo $user->getName() ?></td>
                            <td><?php echo $user->getEmail() ?></td>
                            <td><?php echo $user->getRegisterDate() ?></td>
                            <?php
                            //Verify Label
                            echo "<td><a href='#verifyModal'><span id='" . $user->getVerifiedLabelID() . "' ";
                            echo "data-userid='" . $user->getId() . "' ";
                            echo "data-user='" . $user->getName() . "' ";
                            echo "data-verified='" . $user->getVerified() . "' ";
                            if ($user->getVerified() == 1) {
                                echo "data-verifydate='" . $user->getVerifyDate() . "' ";
                                echo "data-verifier='" . $user->getVerifier() . "' ";
                            }
                            echo "class = \"label verifiedLabel ";
                            if ($user->getVerified() == "1") {
                                echo "label-success\">Verfiziert";
                            } else {
                                echo "label-danger\">Unverfiziert";
                            }
                            echo "</span></a></td>";
                            //Perm Label
                            echo "<td><a href=\"#permModal\"><span class=\"label label-primary permLabel\" ";
                            echo "data-user='" . $user->getName() . "' ";
                            foreach ($roles as $role) {
                                $roleid = $role->getId();
                                echo " data-role$roleid=".($user->hasRole($role->getId()) ? "1" : "0");
                            }
                            echo ">Permissions</span></a></td>";
                            ?>
                            <td>Betrachtete am <b><?php echo $user->getLastActivity() ?></b>
                                die Seite <b><?php echo $user->getLastPage() ?></b></td>
                            <!-- //last activity-->
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<!-- Verify Modal -->
<div id="verifyModal" class="model-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button id="closeVerifyModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 id="verifyModalTitle" class="modal-title">Verify Infos zu Nutzer</h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label for="verifyModalCheckBox" class="col-sm-4 control-label">Verifiziert</label>
                        <div class="col-sm-8">
                            <input id="verifyModalCheckBox" name="verifyCheck" type="checkbox" checked="checked"/>
                        </div>
                    </div>
                    <div class="form-group" id="verifierDiv">
                        <label for="verifier" class="col-sm-4 control-label">Verifiziert von:</label>
                        <div class="col-sm-8">
                            <p class="form-control" id="verifier">x</p>
                        </div>
                    </div>
                    <div class="form-group" id="verifyDateDiv">
                        <label for="verifyDate" class="col-sm-4 control-label">Verifiziert seit:</label>
                        <div class="col-sm-8">
                            <p class="form-control" id="verifyDate">x</p>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button id="saveVerifyModalButton" class="form-control btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>

<!-- Permission Modal -->
<div id="permModal" class="model-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button id="closePermModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 id="permModalTitle" class="modal-title">Perm Infos zu Nutzer</h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#groupTab" data-toggle="tab" aria-expanded="true">Gruppen</a></li>
                        <li class=""><a href="#permTab" data-toggle="tab" aria-expanded="false">Permissions</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                Dropdown <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="groupTab">
                            <?php foreach ($roles as $role) : ?>
                                <div class="roleLayout"><input id="role<?php echo $role->getId();?>Checkbox"
                                                               type="checkbox"/><?php echo $role->getName();?></div>"
                            <?php endforeach; ?>
                        </div>
                        <div class="tab-pane" id="permTab">
                            <p>Einzelne Rechte</p>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>

                <button id="savePermModalButton" class="form-control btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>