
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pagetitle mt-4">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="row mb-3">
        <div class="col-md-2">
            <?php
            require_once __DIR__ . 'components/total_annual_customers';
            ?>
        </div>
        <div class="col-md-2">
            <?php
            require_once __DIR__ . 'components/total_annual_reservations';
            ?>
        </div>
        <div class="col-md-2">
            <?php
            require_once __DIR__ . 'components/annual_income';
            ?>
        </div>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '4' || $_SESSION['user_role_id'] == '6') {
            ?>
            <div class="col-md-2">
                <?php
                require_once __DIR__ . 'components/annual_expenses';
                ?>
            </div>
            <div class="col-md-2">
                <?php
                require_once __DIR__ . 'components/annual_profit';
                ?>
            </div>
            <?php
        }
        ?>
        <div class="col-md-2"></div>
    </div>
</main>