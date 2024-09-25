<?php
session_start();
if (!isset($_SESSION['adminemail'], $_SESSION['role'])) {
    header('location:login.php');
    die();
}

include('../connect.php');
?>


<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <style type="text/css">
        #error-mssg {
            width: auto;
            height: 4vh;
            position: absolute;
            padding: 1.5% 1% 1% 1%;
            right: 1.5%;
            bottom: 2%;
            color: white;
            background-color: #ab8e17;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
            border-radius: 7px;
            transition: 0.4s;
        }

        .action {
            text-decoration: none;
            color: white;
            background-color: black;
            padding: 4%;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .action:hover {
            background-color: grey;
        }

        .orderl {
            overflow-x: auto;
            min-height: 89vh;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            background-image: none;
        }

        tr {
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        }
    </style>
</head>

<body>
    <div class="sidebar text-center">
        <img src="../images/logo.png">
        <br>
        <h4 style="font-size: 17px;font-weight: 600;color: rgb(206, 240, 253);">ADMIN</h4>
        <br>
        <div class="innerside">
            <a href="dashboard.php">Dashboard</a>
            <a href="user.php">User</a>
            <a href="add-category.php">Add Category</a>
            <a href="manage-category.php">Manage Category</a>
            <a href="add-food.php">Add Food</a>
            <a href="manage-food.php">Manage Food</a>
            <a href="order-list.php">Order List</a>
            <a href="searchorder.php">Search Order</a>
            <a href="salesreport.php">Sales Report</a>
        </div>
        <div style="bottom: 10px;left: 14px; position: fixed; color: #B4B4B4;">
            <h6>Copyright@2022 Food Inc.</h6>
        </div>

    </div>
    <div class="restlist">
        <div class="restheader">
            <img src="../images/logo.png" height="50px" width="60px">
            <div class="logoutbtn"><a href="logout.php">Logout</a></div>
        </div>
        <br>
        <h3 class="text-center">User Information</h3>
        <br>
        <div class="orderl">
            <table cellspacing="0">
                <tr>
                    <th>UID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>CONTACT</th>
                    <th>ACTION</th>
                </tr>

                <?php

                $todaydate = date("Y-m-d");
                $q = "SELECT * FROM `userinfo` where `role` ='user' order by uid Desc";

                $res = mysqli_query($con, $q);

                $sn = 1;
                if (mysqli_num_rows($res) > 0) {

                    while ($row = mysqli_fetch_assoc($res)) {

                        $uid = $row['uid'];
                        $name = $row['firstname'] . " " . $row['lastname'];
                        $email = $row['email'];
                        $contact = $row['contact'];
                        $status = $row['status'];
                        $sn++;
                        ?>

                        <tr style='<?php if ($sn % 2 != 0)
                            echo "background-color: #f5f5f5" ?>'>

                                <td class="oidd"><?php echo $uid; ?>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $contact; ?></td>
                            <td>
                                <?php if ($status == 'approved') { ?>
                                    <button class="b2">Block</button>
                                <?php } else { ?>
                                    <button class="b1">Approve</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "
                            <tr>
                            <td colspan=8 class='text-center'>No User Data Available.</td>
                            </tr>
                        ";
                }


                ?>
            </table>
        </div>

    </div>

</body>

<script src="../js/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Approve user
        $('.b1').click(function () {
            var row = $(this).closest('tr');
            var uid = row.find('.oidd').html();

            $.ajax({
                type: 'POST',
                url: 'update-user.php',
                data: {
                    uid: uid,
                    status: 'approved'
                },
                cache: false,
                success: function (data) {
                    location.reload();  
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        });

        // Block user
        $('.b2').click(function () {
            var row = $(this).closest('tr');
            var uid = row.find('.oidd').html();

            $.ajax({
                type: 'POST',
                url: 'update-user.php',
                data: {
                    uid: uid,
                    status: 'blocked'
                },
                cache: false,
                success: function (data) {
                    location.reload();  
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        });
    });

</script>

</html>