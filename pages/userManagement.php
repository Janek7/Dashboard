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
                            echo "<td><a href><span class = ";
                            if ($user->getVerified() == "1") {
                                echo "\"label label-success verifiedLabel\">Verfiziert";
                            } else {
                                echo "\"label label-danger verifiedLabel\">Unverfiziert";
                            }
                            echo "</span></a></td>";
                            ?>
                            <td>Betrachtete am <?php echo $user->getLastActivity()?> die Seite <?php echo $user->getLastPage()?></td>
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