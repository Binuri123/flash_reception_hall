<?php include '../header.php';?>
<?php include '../menu.php';?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Employees</a></li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
              <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New User</a>
          </div>
        </div>
      </div>
      <h2>Employees</h2>
      <?php
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        //var_dump($_POST);
        $reg_no = cleanInput($reg_no);
        $emp_name = cleanInput();

        if (!empty($reg_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " reg_no LIKE '%$reg_no%' AND";
        }

        if (!empty($designation)) {
            //Exact Search perform using = sign
            $where .= " e.designation_id ='$designation' AND";
        }
        
        if (!empty($role)) {
            //Exact Search perform using = sign
            $where .= " u.role_id ='$role' AND";
        }
        
        if (!empty($status)) {
            //Exact Search perform using = sign
            $where .= " u.status ='$status' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
        <div class="row">
            <div class="mb-3 col-md-2">
                <input type="text" class="form-control" placeholder="Reg No" name="reg_no" value="<?= @$reg_no ?>">
            </div>
            <div class="mb-3 col-md-2">
                <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM designation";
                    $result = $db->query($sql);
                ?>
                <select name="designation" class="form-control form-select">
                    <option value="" style="text-align:center">-Designation-</option>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>
                                <option value="<?= $row['designation_id'] ?>" <?php if($row['designation_id']== @$designation){ ?> selected <?php }?>><?= $row['designation_name'] ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM user_role";
                    $result = $db->query($sql);
                ?>
                <select name="role" class="form-control form-select">
                    <option value="" style="text-align:center">-Role-</option>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>
                                <option value="<?= $row['role_id'] ?>" <?php if($row['role_id']== @$role){ ?> selected <?php }?>><?= $row['role_name'] ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <select name="status" class="form-control form-select">
                    <option value="" style="text-align:center">-Status-</option>
                    <option value="1" <?php if($status == 1){ ?> selected <?php }?>>Active</option>
                    <option value="0" <?php if($status == 0){ ?> selected <?php }?>>Inactive</option>
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-warning" style="width:150px">Search</button>
            </div>
            <div class="mb-3 col-md-2">
                <button type="reset" class="btn btn-info" style="width:150px">Clear</button>
            </div>
        </div>
    </form>
      <div class="table-responsive">
          <?php
            $sql = "SELECT DISTINCT u.user_id,reg_no,title,first_name,last_name,"
                    . "r.role_name,u.role_id,e.designation_id,d.designation_name,u.status FROM employee e"
                    . " LEFT JOIN users u ON e.user_id=u.user_id"
                    . " LEFT JOIN user_role r ON r.role_id = u.role_id"
                    . " LEFT JOIN designation d ON d.designation_id = e.designation_id $where";
            print_r($sql);
            $db = dbConn();
            $result = $db->query($sql);
          ?>
        <table class="table table-striped table-sm">
          <thead class="bg-info">
            <tr>
              <th scope="col">Reg No</th>
              <th scope="col">Name</th>
              <th scope="col">Designation</th>
              <th scope="col">Role</th>
              <th scope="col">Status</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
              <?php 
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                ?>
            <tr>
              <td><?= $row['reg_no'] ?></td>
              <td><?= $row['title']." ".$row['first_name']." ".$row['last_name'] ?></td>
              <td><?= $row['designation_name'] ?></td>
              <td><?= $row['role_name']?></td>
              <td><?= $row['status']? "Active":"Inactive" ?></td>
              <td><a href="edit.php?user_id=<?= $row['user_id'] ?>" class="btn btn-warning btn-sm <?= ($row['role_id']==7)?'disabled':''?>"><span data-feather="edit" class="align-text-bottom"></span></a></td>
              <td><a href="#" class="btn btn-info btn-sm"><span data-feather="eye" class="align-text-bottom"></span></a></td>
            </tr>
            <?php
                   }
                }
            ?>
          </tbody>
        </table>
      </div>
    </main>

 <?php include '../footer.php';?>
