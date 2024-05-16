<?php include '../header.php';?>
<?php include '../menu.php';?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Customers</a></li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0"></div>
      </div>
      <h2>Customers</h2>
      <?php
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        //var_dump($_POST);
        $reg_no = cleanInput($reg_no);
        
        if (!empty($reg_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " reg_no LIKE '%$reg_no%' AND";
        }
        if (!empty($status)) {
            //Exact Search perform using = sign
            $where .= " c.status ='$status' AND";
        }
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "AND $where";
        }
    }
    ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
        <div class="row">
            <div class="mb-3 col-md-4">
                <input type="text" class="form-control" placeholder="Reg No" name="reg_no" value="<?= @$reg_no ?>">
            </div>
            <div class="mb-3 col-md-4">
                <select name="status" class="form-control form-select">
                    <option value="">-Status-</option>
                    <option value="1" <?php if($status == '1'){ ?> selected <?php }?>>Active</option>
                    <option value="0" <?php if($status == '0'){ ?> selected <?php }?>>Inactive</option>
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
            $sql = "SELECT DISTINCT reg_no,title_name,first_name,last_name,c.status FROM customers c "
                    . "LEFT JOIN users u ON c.user_id=u.user_id "
                    . "LEFT JOIN customer_titles cs ON cs.title_id=c.title_id WHERE role_id = 7 $where";
            print_r($sql);
            $db = dbConn();
            $result = $db->query($sql);
          ?>
        <table class="table table-striped table-sm">
          <thead class="bg-info">
            <tr>
              <th scope="col">Reg No</th>
              <th scope="col">Name</th>
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
              <td><?= $row['title_name']." ".$row['first_name']." ".$row['last_name'] ?></td>
              <td><?= $row['status']? "Active":"Inactive" ?></td>
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
