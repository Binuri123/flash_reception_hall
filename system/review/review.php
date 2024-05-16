<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reviews</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>review/received.php" style="text-decoration:none;color:white">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as received FROM customer_review WHERE approval_status = 'Pending'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $received = $row['received'];
                            ?>
                            <h4># Received<br><?= $received ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>review/approved.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as approved FROM customer_review WHERE approval_status = 'Approved'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $approved = $row['approved'];
                            ?>
                            <h4># Approved<br><?= $approved ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>review/unapproved.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as unapproved FROM customer_review WHERE approval_status = 'Unapproved'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $unapproved = $row['unapproved'];
                            ?>
                            <h4># Unapproved<br><?= $unapproved ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php
        extract($_POST);
        //var_dump($_POST);
        $where = NULL;

        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {

            if (!empty($approval_status)) {
                //Exact Search perform using = sign
                $where .= " r.approval_status ='$approval_status' AND";
            }
            if (!empty($replied_status)) {
                //Exact Search perform using = sign
                $where .= " r.reply_status ='$replied_status' AND";
            }

            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = "WHERE $where";
            }
        }
        ?>
        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Reviews List</h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                    <div class="row">
                        <div class="col-md-2">
                            <select name="approval_status" class="form-control form-select" style="font-size:13px;">
                                <option value="" style="text-align:center">-Approval Status-</option>
                                <option value="Approved" <?php if (@$approval_status == "Approved") { ?> selected <?php } ?>>Approved</option>
                                <option value="Unapproved" <?php if (@$approval_status == "Unapproved") { ?> selected <?php } ?>>Unapproved</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="replied_status" class="form-control form-select" style="font-size:13px;">
                                <option value="" style="text-align:center">-Replied Status-</option>
                                <option value="Replied" <?php if (@$replied_status == "Replied") { ?> selected <?php } ?>>Replied</option>
                                <option value="Notreplied" <?php if (@$replied_status == "Notreplied") { ?> selected <?php } ?>>Not Replied</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                            <a href="<?= SYSTEM_PATH ?>review/review.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size:13px;">
                        <thead class="bg-secondary text-white">
                            <tr style="text-align:center;vertical-align:middle;font-size:13px;">
                                <th scope="col">#</th>
                                <th scope="col" class="col-md-2">Reviewer Name</th>
                                <th scope="col" class="col-md-2">Reviewer Email</th>
                                <th scope="col" class="col-md-3">Review</th>
                                <th scope="col" class="col-md-2">Added Date</th>
                                <th scope="col" class="col-md-1">Approval Status</th>
                                <th scope="col" class="col-md-2">Replied Status</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:13px;">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM customer_review r $where";
                            $result = $db->query($sql);
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td style="text-align:justify;"><?= $row['review'] ?></td>
                                    <td style="text-align:center;"><?= $row['add_date'] ?></td>
                                    <td><?= $row['approval_status'] ?></td>
                                    <td style="text-align:center;"><?= $row['reply_status'] ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../footer.php'; ?>
