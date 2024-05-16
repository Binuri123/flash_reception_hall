<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= SYSTEM_PATH ?>index.php">
                    <?= $_SESSION['user_role'] ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= SYSTEM_PATH ?>index.php">
                    <i class="bi bi-house"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>customer/customer.php">
                    <i class="bi bi-person-circle"></i>
                    Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>supplier/supplier.php">
                    <i class="bi bi-people-fill"></i>
                    Suppliers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>reservation/reservation.php">
                    <i class="bi bi-pencil-square"></i>
                    Reservations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>arrangement_plan/arrangement_plan.php">
                    <i class="bi bi-journal-richtext"></i>
                    Arrangement Plan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>hall/hall.php">
                    <i class="bi bi-shop"></i>
                    Halls
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>package/package.php">
                    <i class="bi bi-journal-album"></i>
                    Packages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>menu_package/menu.php">
                    <i class="bi bi-journal-text"></i>
                    Menus
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>service/service.php">
                    <i class="bi bi-list-check"></i>
                    Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>arrangement_plan/arrangement_plan.php">
                    <i class="bi bi-journal-richtext"></i>
                    Arrangement Plan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>refund/refund.php">
                    <i class="bi bi-cash-coin"></i>
                    Refunds
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>reports/reportmenu.php">
                    <i class="bi bi-bar-chart-fill"></i>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>review/review.php">
                    <i class="bi bi-star"></i>
                    Reviews
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>terms_and_conditions/terms_and_conditions.php">
                    <i class="bi bi-stack"></i>
                    Terms & Conditions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>change_password.php">
                    <i class="bi bi-gear"></i>
                    Change Password
                </a>
            </li>
        </ul>
    </div>
</nav>