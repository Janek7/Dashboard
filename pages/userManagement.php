<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 07.04.2018
 * Time: 14:30
 */

global $users;
?>

<div class="row">
    <div class="col-xs-12">
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
                            ?>
                            <td><a href=""><span class="label label-primary">Permissions</span></a></td>
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
                <button id="closeVerifyModalButton" class="form-control btn btn-primary" name="NoteAddButton">Speichern</button>
            </div>
        </div>
    </div>
</div>