<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php 
        require_once __DIR__ . '/dashboard_banner.php'; 
    ?>
    <div class="row mb-3">
        <div class="col">
            <?php
                require_once '/components/total_annual_customers';
            ?>
        </div>
        <div class="col">
            <?php
                require_once '/components/total_annual_reservations';
            ?>
        </div>
        <div class="col">
            <?php
                require_once '/components/annual_income';
            ?>
        </div>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '4' || $_SESSION['user_role_id'] == '6') {
            ?>
            <div class="col">
                <?php
                    require_once '/components/annual_expenses';
                ?>
            </div>
            <div class="col">
                <?php
                    require_once '/components/annual_profit';
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</main>