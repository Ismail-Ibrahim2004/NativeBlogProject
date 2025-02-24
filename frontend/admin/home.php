<?php 
  session_start();
  require_once('header.php');
  require_once('../../classes.php');
  $user = unserialize($_SESSION['user']); 
  $All_user = $user->get_all_users();  
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button"
                class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <svg class="bi">
                    <use xlink:href="#calendar3" />
                </svg>
                This week
            </button>
        </div>
    </div>

    <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->

    <h2>All users</h2>
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">role</th>
                    <th scope="col">phone</th>
                    <th scope="col">action </th>
                </tr>
            </thead>
            <tbody>
                <?php
              foreach($All_user as $user){ 

?>

                <tr>
                    <td><?= $user['id']?></td>
                    <td><?= $user['name']?></td>
                    <td><?= $user['email']?></td>
                    <td><?= $user['role']?></td>
                    <td><?= $user['phone']?></td>
                    <td>
                        <button type="button" class="btn btn-danger">
                            BAN
                        </button>
                        <form action="delete_account.php" method="post" style="display:inline-block">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-danger">
                                DELETE Account
                            </button>
                        </form>


                    </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
        </table>
    </div>
</main>


<?php 
    require_once('footer.php');
?>