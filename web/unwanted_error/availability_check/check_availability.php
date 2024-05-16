<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#check_availability">
    Check Availability
</button>

<div class="modal fade" id="check_availability" tabindex="-1" aria-labelledby="check_availability_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="check_availability_modal">Check Availability</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label" for="start_date">Start Date</label>
                                </div>
                                <div class="col-md-8">
                                    <?php
                                    $current_date = date('Y-m-d');
                                    $min = $current_date->modify('+14 days')->format('Y-m-d');
                                    $max = $current_date->modify('+1 year')->format('Y-m-d');
                                    ?>
                                    <input type="date" min="<?= $min ?>" max="<?= $max ?>" name="start_date" id="start_date" value="<?= @$start_date ?>">
                                    <div class="text-danger"><?= @$message["error_start_date"] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label" for="end_date">End Date</label>
                                </div>
                                <div class="col-md-8">
                                    <?php
                                    $current_date = date('Y-m-d');
                                    $min = $current_date->modify('+14 days')->format('Y-m-d');
                                    $max = $current_date->modify('+1 year')->format('Y-m-d');
                                    ?>
                                    <input type="date" min="<?= $min ?>" max="<?= $max ?>" name="end_date" id="end_date" value="<?= @$end_date ?>">
                                    <div class="text-danger"><?= @$message["error_end_date"] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Check</button>
            </div>
        </div>
    </div>
</div>