<?php
include 'header.php';
include 'sidebar.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'check_availability') {
    extract($_POST);

    $event_date = cleanInput($event_date);
    $start_time = cleanInput($start_time);
    $end_time = cleanInput($end_time);
    $guest_count = cleanInput($guest_count);

    $message = array();
    //Required Field Validation
    if (empty($event)) {
        $message['error_event'] = 'An Event Should be Selected';
    }

    if (empty($event_date)) {
        $message['error_event_date'] = 'The Event Date Should be Selected';
    }

    if (empty($start_time)) {
        $message['error_start_time'] = 'A Start Time Should be Selected';
    }

    if (empty($end_time)) {
        $message['error_end_time'] = 'A End Time Should be Selected';
    }

    if (empty($guest_count)) {
        $message['error_guest_count'] = 'Your Guest Count Should be Entered';
    }

    if (empty($hall)) {
        $message['error_hall'] = 'A Hall Should be Selected';
    }

//    if (!empty($event_date)) {
//        $today = date('Y-m-d');
//        $mindate = date('Y-m-d', strtotime('+14 days', strtotime($today)));
//        $maxdate = date('Y-m-d', strtotime('+1 year', strtotime($today)));
//        if($event_date < $mindate){
//            $message['error_event_date'] = 'You Should Reserve The Venue 14 Days Ahead From the Event Date';
//        }elseif($event_date>$maxdate){
//            $message['error_event_date'] = 'You Should Reserve The Venue Within Year From Today';
//        }
//    }
    
//    if (!empty($start_time)) {
//        $mintime = '07:00 AM';
//        $maxtime = '00:00 AM';
//        if($start_time < $mintime){
//            $message['error_event_date'] = 'You Should Reserve The Venue 14 Days Ahead From the Event Date';
//        }elseif($event_date>$maxdate){
//            $message['error_event_date'] = 'You Should Reserve The Venue Within Year From Today';
//        }
//    }

    if (!empty($message)) {
        $db = dbConn();
        $sql = "SELECT * FROM hall WHERE availability ='Available' "
                . "AND IN (SELECT hall_id FROM hall_event WHERE event_id='$event') "
                . "AND min_capacity<='$guest_count' AND max_capacity>='$guest_count' "
                . "AND NOT IN (SELECT hall_id FROM reservation WHERE date = $event_date AND status_id = 2 "
                . "AND (start_time ='$start_time' OR end_time = '$start_time' OR start_time = '$end_time' OR end_time = '$end_time' "
                . "OR (end_time BETWEEN '$start_time' AND '$end_time') "
                . "OR (start_time<'$start_time' AND end_time>'$end_time'))";
        $result = $db->query($sql);
        
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
?>
        <a href="<?= WEB_PATH ?>reservation/event_details.php"><?= $row['hall_name'] ?></a>
<?php
            }
        }else{
            echo 'Sorry The date and time you are looking for is not available';
        }
    }
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="event" class="form-label">Event</label>
                                            <select id="event" name="event" class="form-control form-select">
                                                <option value="">Select a Event</option>
                                                <?php
                                                $db = dbConn();
                                                $sql = "SELECT * FROM event";
                                                $result = $db->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <option value=<?= $row['event_id']; ?> <?php if ($row['event_id'] == @$event) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_event"] ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            $today = date('Y-m-d');
                                            $mindate = date('Y-m-d', strtotime('+14 days', strtotime($today)));
                                            $maxdate = date('Y-m-d', strtotime('+1 year', strtotime($today)));
                                            ?>
                                            <label for="event_date" class="form-label">Event Date</label>
                                            <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Pick a Date" id="event_date" name="event_date" value="<?= @$event_date ?>">
                                            <div class="text-danger"><?= @$message["error_event_date"] ?></div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" min="07:00 AM" max="12:00 AM" class="form-control" placeholder="Pick a Date" id="start_time" name="start_time" value="<?= @$start_time ?>">
                                            <div class="text-danger"><?= @$message["error_start_time"] ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" min="07:00 AM" max="12:00 AM" class="form-control" placeholder="Pick a Date" id="end_time" name="end_time" value="<?= @$end_time ?>">
                                            <div class="text-danger"><?= @$message["error_end_time"] ?></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="guest_count" class="form-label">Guest Count</label>
                                            <input type="number" name="guest_count" id="guest_count" class="form-control" value="<?= @$guest_count ?>">
                                            <div class="text-danger"><?= @$message["error_guest_count"] ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hall" class="form-label">Hall</label>
                                            <select id="hall" name="hall" class="form-control">
                                                <option value="">Select a Hall</option>
                                                <?php
                                                $db = dbConn();
                                                //$where = null;
//                                if(!empty($event)){
//                                    $where = " hall_id IN (SELECT hall_id FROM hall_event WHERE event_id=$event_id)";
//                                }
//                                if(!empty($start_date) && !empty($end_date)){
//                                    if($start_date != $end_date){
//                                        
//                                    }else{
//                                        $where = " date = '$start_date' AND ";
//                                    }
//                                }

                                                $sql = "SELECT * FROM hall";

//                                if (isset($guest_count)) {
//                                    $sql = "SELECT * FROM hall WHERE min_capacity <= $guest_count AND max_capacity >= $guest_count";
//                                }

                                                $result = $db->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <option value=<?= $row['hall_id']; ?> <?php if ($row['hall_id'] == @$hall) { ?> selected <?php } ?>><?= $row['hall_name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_hall"] ?></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12" style="text-align:right">
                                            <button type="reset" class="btn btn-warning">Cancel</button>
                                            <button type="submit" class="btn btn-success" name="action" value="check_availability">Check</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-md-4">
                <!-- Recent Activity -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Recent Activity <span>| Today</span></h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                                <div class="activite-label">32 min</div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">56 min</div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    Voluptatem blanditiis blanditiis eveniet
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 hrs</div>
                                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                <div class="activity-content">
                                    Voluptates corrupti molestias voluptatem
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">1 day</div>
                                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                <div class="activity-content">
                                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 days</div>
                                <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                <div class="activity-content">
                                    Est sit eum reiciendis exercitationem
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">4 weeks</div>
                                <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                <div class="activity-content">
                                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                                </div>
                            </div><!-- End activity item-->

                        </div>

                    </div>
                </div><!-- End Recent Activity -->

                <!-- Budget Report -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body pb-0">
                        <h5 class="card-title">Budget Report <span>| This Month</span></h5>
                        <div id="budgetChart" style="min-height: 400px;" class="echart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () = > {
                            var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                            legend: {
                            data: ['Allocated Budget', 'Actual Spending']
                            },
                                    radar: {
                                    // shape: 'circle',
                                    indicator: [{
                                    name: 'Sales',
                                            max: 6500
                                    },
                                    {
                                    name: 'Administration',
                                            max: 16000
                                    },
                                    {
                                    name: 'Information Technology',
                                            max: 30000
                                    },
                                    {
                                    name: 'Customer Support',
                                            max: 38000
                                    },
                                    {
                                    name: 'Development',
                                            max: 52000
                                    },
                                    {
                                    name: 'Marketing',
                                            max: 25000
                                    }
                                    ]
                                    },
                                    series: [{
                                    name: 'Budget vs spending',
                                            type: 'radar',
                                            data: [{
                                            value: [4200, 3000, 20000, 35000, 50000, 18000],
                                                    name: 'Allocated Budget'
                                            },
                                            {
                                            value: [5000, 14000, 28000, 26000, 42000, 21000],
                                                    name: 'Actual Spending'
                                            }
                                            ]
                                    }]
                            });
                            });</script>
                    </div>
                </div><!-- End Budget Report -->
                <!-- Website Traffic -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body pb-0">
                        <h5 class="card-title">Website Traffic <span>| Today</span></h5>
                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                        <script>
                                    document.addEventListener("DOMContentLoaded", () = > {
                                    echarts.init(document.querySelector("#trafficChart")).setOption({
                                    tooltip: {
                                    trigger: 'item'
                                    },
                                            legend: {
                                            top: '5%',
                                                    left: 'center'
                                            },
                                            series: [{
                                            name: 'Access From',
                                                    type: 'pie',
                                                    radius: ['40%', '70%'],
                                                    avoidLabelOverlap: false,
                                                    label: {
                                                    show: false,
                                                            position: 'center'
                                                    },
                                                    emphasis: {
                                                    label: {
                                                    show: true,
                                                            fontSize: '18',
                                                            fontWeight: 'bold'
                                                    }
                                                    },
                                                    labelLine: {
                                                    show: false
                                                    },
                                                    data: [{
                                                    value: 1048,
                                                            name: 'Search Engine'
                                                    },
                                                    {
                                                    value: 735,
                                                            name: 'Direct'
                                                    },
                                                    {
                                                    value: 580,
                                                            name: 'Email'
                                                    },
                                                    {
                                                    value: 484,
                                                            name: 'Union Ads'
                                                    },
                                                    {
                                                    value: 300,
                                                            name: 'Video Ads'
                                                    }
                                                    ]
                                            }]
                                    });
                                    });
                        </script>
                    </div>
                </div><!-- End Website Traffic -->
                <!-- News & Updates Traffic -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body pb-0">
                        <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>
                        <div class="news">
                            <div class="post-item clearfix">
                                <img src="dashboard_assets/img/news-1.jpg" alt="">
                                <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                                <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                            </div>
                            <div class="post-item clearfix">
                                <img src="dashboard_assets/img/news-2.jpg" alt="">
                                <h4><a href="#">Quidem autem et impedit</a></h4>
                                <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                            </div>
                            <div class="post-item clearfix">
                                <img src="dashboard_assets/img/news-3.jpg" alt="">
                                <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                                <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                            </div>
                            <div class="post-item clearfix">
                                <img src="dashboard_assets/img/news-4.jpg" alt="">
                                <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                                <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                            </div>
                            <div class="post-item clearfix">
                                <img src="dashboard_assets/img/news-5.jpg" alt="">
                                <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                                <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                            </div>
                        </div><!-- End sidebar recent posts-->
                    </div>
                </div><!-- End News & Updates -->
            </div><!-- End Right side columns -->
        </div>
    </section>
</main><!-- End #main -->
<?php include 'footer.php'; ?>