<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php

            $users = User::findAllUsers();
            foreach ($users as $user) {
                echo $user->username . "<br>";
            }

            //                $result_set_id = User::findUserById('1');
            //                $user = User::createUser($result_set_id);
            //                echo $user->getFirstName() ."<br>";
            //                echo $user->getUsername();
            ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->

