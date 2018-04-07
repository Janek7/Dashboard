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
                        <th>letzte Aktivität</th>
                    </tr>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user->getId() ?></td>
                            <td><?php echo $user->getName() ?></td>
                            <td><?php echo $user->getEmail() ?></td>
                            <td><?php echo $user->getRegisterDate() ?></td>
                            <?php
                            echo "<td>";
                            if ($user->getVerified() == "1") {
                                echo "<span class = \"label label-success\">Verfiziert</span>";
                            } else {
                                echo "<span class=\"label label-danger\">Unverfiziert</span>";
                            }
                            echo "</td>";
                            ?>
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