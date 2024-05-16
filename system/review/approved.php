<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>review/review.php">Review</a></li>
                <li class="breadcrumb-item active" aria-current="page">Approved Reviews</li>
            </ol>
        </nav>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {

        if (!empty($replied_status)) {
            //Exact Search perform using = sign
            $where .= " r.reply_status ='$replied_status' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "AND $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Approved Reviews List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="col-md-2">
                        <select name="replied_status" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Replied Status-</option>
                            <option value="Replied" <?php if (@$replied_status == "Replied") { ?> selected <?php } ?>>Replied</option>
                            <option value="Notreplied" <?php if (@$replied_status == "Notreplied") { ?> selected <?php } ?>>Not Replied</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>review/approved.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary text-white">
                        <tr style="text-align:center;vertical-align:middle">
                            <th>#</th>
                            <th scope="col" class="col-md-2">Reviewer Name</th>
                            <th scope="col" class="col-md-2">Reviewer Email</th>
                            <th scope="col" class="col-md-4">Review</th>
                            <th scope="col" class="col-md-2">Added Date</th>
                            <th scope="col" class="col-md-3">Replied Status</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '2') {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM customer_review r WHERE approval_status='Approved' $where ORDER BY r.add_date ASC";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['first_name']." ".$row['last_name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td style="text-align: justify"><?= $row['review'] ?></td>
                                    <td style="text-align: center"><?= $row['add_date'] ?></td>
                                    <td style="text-align: center"><?= $row['reply_status'] ?></td>
                                    <?php
                                    if (($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6') && $row['reply_status'] == 'Not Replied') {
                                        ?>
                                        <td><a href="<?=SYSTEM_PATH?>review/reply.php?review_id=<?= $row['review_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-chat-left-dots-fill"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                        <td><a href="<?=SYSTEM_PATH?>review/view.php?review_id=<?= $row['review_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php include '../footer.php'; ?>