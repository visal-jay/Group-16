<!DOCTYPE html>
<html lang="en" id="id1">

<head>
    <link rel="icon" href="/Public/assets/visal logo.png" type="image/icon type">
    <title>Communityretreat</title>
    <link rel="stylesheet" href="/Public/assets/newstyles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c119b7fc61.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

<style>
    .canvas {
        display: -webkit-inline-box;
        width: 100%;
    }

    .community-retreat {
        color: #16c79a;
    }

    h1,
    h3 {
        text-align: center;
    }

    .table {
        width: 100%;
        background: #e2dfdf;
        text-align: center;
        border-collapse: collapse;
    }

    th,
    td {
        border-bottom: 1px solid #fff;
        padding: 8px;
        border-collapse: collapse;
    }

    .container {
        width: 80%;
        max-width: none;
        padding-bottom: 20px;
    }

    .date-time-container {
        display: flex;
        font-size: 12px;
    }

    .logo-container {
        width: 20%;
    }

    .amount {
        text-align: right;
        width: 50%;
    }

    .volunteer-field {
        text-align: left;

    }

    .income-expenxe-balance-container {
        margin-bottom: 20px;
        border-color: #16c79a;
        border-radius: 8px;
        background-color: #eeeeee;
        box-shadow: 2px 4px #ccbcbc;
        padding: 5px;
        text-align: center;
        display: flex;
        justify-content: space-evenly;
    }

    .sum {
        margin: 15px;
        text-align: center;
    }

    .bold {
        font-weight: 700;
        align-items: center;
        display: flex;
    }
</style>

<?php
if (!isset($moderator)) $moderator = false;
if (!isset($treasurer)) $treasurer = false;
$organization = $admin = $registered_user = $guest_user = false;

if (isset($_SESSION["user"]["user_type"])) {
    if ($_SESSION["user"]["user_type"] == "organization") {
        $organization = true;
    }

    if ($_SESSION["user"]["user_type"] == "admin") {
        $admin = true;
    }

    if ($_SESSION["user"]["user_type"] == "registered_user") {
        $registered_user = true;
    }
} else {
    $guest_user = true;
}
?>


<body>
    <header class="header">
        <div class="logo-container"><a class=" logo ">
                <img src="/Public/assets/visal logo.png ">
            </a>
        </div>

        <div style="width: 60%; text-align:center">
            <p style="color: #16C79A;">Report generated by <a class="community-retreat" href=" /User/home"><b>CommunityRetreat</b> </a>
            </p>
        </div>

        <div class="date-time-container" style="width: 20%;">
            <p>Date and Time: <span id='date-time'></span>.</p>
            <br><br>
        </div>
    </header>
    <div class="container">
        <div class="container">
            <h1><?= $event_name ?></h1>
            <h3>Volunteer Report</h3>
            <div class="center" style="text-align: center;">
                <canvas class="canvas" id="myChart"></canvas>
            </div>

            <div class="income-expenxe-balance-container flex-row">
                <div class="bold sum flex-col">
                    <div>Dates :
                        <?php foreach ($dates as $date) { ?>
                            <!--display the sum of incomes-->
                            <div>
                                <?= $date ?>
                            </div>
                        <?php } ?>
                    </div>
                    <br>
                    <div>Total</div>
                </div>
                <div class="bold sum flex-col">Total volunteers :
                    <?php foreach ($dates as $date) { ?>
                        <!--display the sum of incomes-->
                        <?php
                        $index = array_search($date, array_column($volunteer_count, "day"));
                         if ($index !== false)
                            echo "<div>" . $volunteer_count[$index]["daily_volunteers"] . "</div>";
                        else
                            echo "<div>0</div>";
                        ?>
                    <?php } ?>
                    <br>
                   <div><?= array_sum(array_map('intval',array_column($volunteer_count, "daily_volunteers"))); ?></div>
                </div>

            <div class="bold sum flex-col">
                <div>Actual participants :
                    <?php foreach ($dates as $date) { ?>
                        <!--display the sum of expenses-->
                        <?php
                        $index = array_search($date, array_column($participant_count, "day")); 
                        if ($index !== false)
                            echo "<div>" . $participant_count[$index]["participants"] . "</div>";
                        else
                            echo "<div>0</div>";
                        ?>
                    <?php } ?>
                    <br>
                    <div><?= array_sum(array_map('intval',array_column($participant_count, "participants"))); ?></div>
                </div>
            </div>

        </div>
        <form action="/Volunteer/volunteerReport?event_id=<?= $_GET["event_id"] ?>" method="post">
            <label for="volunteer_date">Sort by volunteering date</label>
            <select class="form-ctrl" id="volunteer_date" name="volunteer_date" onchange="this.form.submit()">
                <option value="" selected>All</option>
                <?php for ($i = 0; $i < count($volunteer_capacities); $i++) {
                    if ($volunteer_date_req == $volunteer_capacities[$i]['event_date']) { ?>
                        <option value="<?= $volunteer_capacities[$i]['event_date'] ?>" selected><?= $volunteer_capacities[$i]['event_date'] ?></option>
                    <?php } else {  ?>
                        <option value="<?= $volunteer_capacities[$i]['event_date'] ?>"><?= $volunteer_capacities[$i]['event_date'] ?></option>
                <?php }
                } ?>
            </select>
        </form>
        <div>
            <table class="table">
                <!--Display the report of all the volunteers-->
                <tr>
                    <th class="volunteer-date-field">Registered date</th>
                    <th>Volunteered date</th>
                    <th>Volunteer</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Participation</th>
                </tr>
                <?php foreach ($volunteers as $volunteer) { ?>
                    <tr>
                        <td class="volunteer-date-field"><?= $volunteer["date"] ?></td>
                        <td><?= $volunteer["volunteer_date"] ?></td>
                        <td class="volunteer-field"><?= $volunteer["username"] ?></td>
                        <td class="volunteer-field"><?= $volunteer["email"] ?></td>
                        <td><?= $volunteer["contact_number"] ?></td>
                        <td><?php if ($volunteer["participated"] == 1) {
                                echo '<i class="fas fa-check" style="color:green" ></i>';
                            } else {
                                echo '<i class="fas fa-times" style="color:red"></i>';
                            } ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>

    </div>
</body>

<script>
    /*send data to the graph*/
    const data = <?= $volunteer_graph ?>;
    console.log(data);
    const backgroundColor = ['#6F69AC', '#FEC260', '#93B5C6', '#FA8072']
    const borderColor = ['#6F69AC80', '#FEC26080', '#93B5C680', '#FA807280']

    let keys = [];
    let amounts = [];
    for (const event in data) {
        keys.push(data[event]["day"]);
        amounts.push(data[event]["volunteer_sum"]);
    }

    //console.log(keys, amount);

    var myLineChart = new Chart('myChart', {
        type: 'line',
        data: {
            labels: keys,
            datasets: [{
                label: 'Volunteers',
                data: amounts,
                backgroundColor: backgroundColor[0],
                borderColor: borderColor[0],
                fill: false
            }]

        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Volunteers',
                        precision: 0,
                    },
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                            if (Math.floor(label) === label) {
                                return label;
                            }

                        },
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Date',
                    },
                    ticks: {
                        beginAtZero: true
                    }

                }]
            }
        }
    });
</script>

<script>
    /*get date and time*/
    var dt = new Date();
    document.getElementById('date-time').innerHTML = dt;
</script>