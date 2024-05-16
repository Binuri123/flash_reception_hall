<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="book-open" class="align-text-bottom"></span>
                    Reservations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#customer_payments" data-bs-toggle="collapse" href="#">
                    <span data-feather="dollar-sign" class="align-text-bottom"></span>
                    <span>Customer Payments</span>
                    <span data-feather="chevron-down" class="align-text-bottom"></span>
                </a>
                <ul id="customer_payments" class="nav-content collapse submenuitem" data-bs-parent="#sidebar-nav" style="text-decoration: none;">
                    <li>
                        <a href="<?= SYSTEM_PATH ?>customer_payment/verify.php">
                            <span data-feather="alert-octagon" class="align-text-bottom"></span>
                            <span>Received Payments</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= SYSTEM_PATH ?>customer_payment/confirm.php">
                            <i class="bi bi-circle"></i><span>Approved Payments</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Suppliers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Supplier Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="dollar-sign" class="align-text-bottom"></span>
                    Supplier Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers" class="align-text-bottom"></span>
                    Integrations
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle" class="align-text-bottom"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Current month
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Last quarter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Social engagement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Year-end sale
                </a>
            </li>
        </ul>
    </div>
</nav>