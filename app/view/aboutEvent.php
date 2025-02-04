<!DOCTYPE html>
<html lang="en" id="id1">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Public/assets/newstyles.css">
    <link rel="me" href="https://twitter.com/twitterdev">
    <link rel="canonical" href="/Event/view?page=home&event_id=<?= $_GET['event_id'] ?>">
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/c119b7fc61.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/Public/assets/visal logo.png" type="image/icon type">
    <title>Communityretreat</title>

    <!-- meta for facebook sharer -->
    <meta property="og:url" content="https://www.communityretreat.me/Event/view?page=home&event_id=<?= $_GET['event_id'] ?>">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $event_name ?>" />
    <meta property="og:description" content="Volunteer, Donate events" />
    <meta property="og:image" content="https://www.communityretreat.me/<?= $cover_photo ?>" />
</head>


<style>
    .container-size1 {
        width: 70%;
    }



    .head-margin {
        margin: unset;
    }

    .popup .content {
        position: fixed;
        transform: scale(0);
        width: 40%;
        z-index: 2;
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        background: white;
        box-shadow: 0px 0px 11px 2px rgba(0, 0, 0, 0.93);
        z-index: 1;
        left: 50%;
        top: 50%;
        display: flex;
        flex-direction: column;
    }

    .popup .btn-close {
        position: absolute;
        right: 10px;
        top: 10px;
        width: 30px;
        height: 30px;
        color: black;
        font-size: 1.5rem;
        padding: 2px 5px 7px 5px;

    }

    .popup.active .content {
        transition: all 300ms ease-in-out;
        transform: translate(-50%, -50%);
    }

    .volunteer-popup {
        height: 440px;
        overflow: scroll;
    }

    .blurred {
        filter: blur(2px);
        overflow: hidden;
    }

    .progress {
        width: 43%;
        background: #eeeeee;
        height: 28px;
        margin: 15px;
        border-radius: 20px;
    }

    .volunteers-progress-bar,
    .donaters-progress-bar {
        width: 0;
        background: #16c79a;
        color: #fff;
        height: 28px;
        line-height: 28px;
        border-radius: 20px;
        text-align: center;
        vertical-align: middle;
    }

    .still {
        overflow: hidden;
    }

    .container-size {
        width: 70%;
    }

    .about-textarea {
        height: 150px;
        padding: 12px 20px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 6px;
        background: transparent;
        font-size: 16px;
        resize: none;
        font-size: 1rem;
        font-family: inherit;
        margin-bottom: 0.8rem;
    }

    .about-textarea:focus {
        box-shadow: 0px 0px 0px 1px #16c79a;
        border-color: #16c79a;
    }


    .form-ctrl {
        margin-bottom: 0px;
    }

    input[type="date"]::before {
        content: attr(data-placeholder);
        width: 100%;
    }

    input[type="date"]:focus::before,
    input[type="date"]:valid::before {
        display: none
    }

    input[type="time"]::before {
        content: attr(data-placeholder);
        width: 100%;
    }

    input[type="time"]:focus::before,
    input[type="time"]:valid::before {
        display: none
    }

    .icon-width {
        width: 20px;
    }

    ::placeholder {
        color: black;
        opacity: 1;
    }

    label {
        white-space: nowrap;
        height: fit-content;
        width: fit-content !important;
    }

    #map {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
        position: relative;
        height: 350px;
        width: 600px;
        border-radius: 8px;
    }

    .home-events {
        border-radius: 8px;
        min-height: max-content;
        display: grid;
        grid-template-columns: 1fr 1fr;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        margin: 1rem 0 2rem 0;
    }

    .terms-and-conditions {
        text-align: left;
    }

    h4 {
        font-weight: 500;
    }

    .center {
        text-align: center;
    }

    @media screen and (max-width:800px) {
        .progress {
            width: 75%;
        }

        .margin-lg {
            margin: 10px 0px;
        }

        #map {
            position: relative;
            height: 230px;
            width: 230px;
            border-radius: 8px;
        }

        .container-size {
            width: 90%;
        }

        .container-size1 {
            width: 90%;
        }

        .popup .content {
            width: 70%;
            position: fixed;
            text-align: center;
            top: 50%;
            left: 50%;
        }

        .popup.active .content {
            top: 290px;
        }

        .about-textarea {
            width: 100%;
        }

        .textbox {
            box-sizing: border-box;
            padding: 1rem;
        }

        .home-events {
            grid-template-columns: 1fr;
            grid-gap: 1rem;
        }

        .grid-row-1 {
            grid-row: 1;
        }

        .grid-row-2 {
            grid-row: 2;
        }
    }
</style>

<body id="body">
    <div id="background">
        <div class="flex-col flex-center">
            <div class="container-size">
                <h1>About</h1>
            </div>
            <div class="content border-round container-size margin-md" id="details" style="background-color: #eeeeee">
                <?php if ($organization || $moderator) { ?>
                    <form action="/Event/updateDetails?event_id=<?= $_GET["event_id"] ?>" method="post" id="update-form" enctype="multipart/form-data">
                    <?php } ?>
                    <div class="date-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width far fa-calendar-alt clr-green margin-side-lg"></i>
                            <h4 class="head-margin data">Starts on <?= $start_date ?><br>Ends on <?= $end_date ?></h4>
                            <?php if ($organization || $moderator) { ?>
                                <div class="flex-row-to-col">
                                    <div class="flex-col">
                                        <label class="form hidden" for="start_date">Event starts on</label>
                                        <input type="date" id="start_date" value="<?= $start_date ?>" name="start_date" class="form form-ctrl margin-side-md hidden" data-placeholder="Event starts on?" required></input>
                                    </div>
                                    <div class="flex-col">
                                        <label class="form hidden" for="end_date">Event ends on</label>
                                        <input type="date" id="end_date" value="<?= $end_date ?>" name="end_date" class="form form-ctrl margin-side-md hidden" data-placeholder="Event ends on?" required></input>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="time-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width far fa-clock clr-green margin-side-lg"></i>
                            <h4 class="head-margin data">At <?= $start_time ?></h4>
                            <?php if ($organization || $moderator) { ?>
                                <div class="flex-row-to-col flex-center">
                                    <div class="flex-row flex-center">
                                        <label class="form hidden" for="start_time">Starts at?</label>
                                        <input type="time" value="<?= $start_time ?>" name="start_time" class="form form-ctrl margin-side-md hidden" data-placeholder="Event starts at?" required></input>
                                    </div>
                                    <div class="flex-row flex-center">
                                        <label class="form hidden" for="end_time">Ends at?</label>
                                        <input type="time" value="<?= $end_time ?>" name="end_time" class="form form-ctrl margin-side-md hidden" data-placeholder="Event ends at?" required></input>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="time-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width fas fa-hourglass-start clr-green margin-side-lg"></i>
                            <h4 class="head-margin">Duration <?= $duration ?></h4>
                        </div>
                    </div>

                    <div class="venue-container">
                        <div class="flex-row margin-lg ">
                            <i class="btn-icon icon-width fas fa-map-marker-alt clr-green margin-side-lg"></i>
                            <div class="flex-col">
                                <div class="border-round<?php if (!isset($latitude) && !isset($longitude) && ($mode == "Virtual")) echo "form hidden"; ?>" id="map"></div>
                                <div class="latlang" class="form hidden">
                                    <input class="hidden" name="longitude" id="longitude" value=NULL>
                                    <input class="hidden" name="latitude" id="latitude" value=NULL>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="globe-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width fas fa-globe clr-green margin-side-lg"></i>
                            <h4 class="head-margin data"><?= $mode ?></h4>
                            <?php if ($organization || $moderator) { ?>
                                <div class="form hidden">
                                    <div class="flex-row flex-center">
                                        <label class="form hidden" for="mode">Event mode</label>
                                        <select name="mode" class="form-ctrl margin-side-md" id="mode" required onchange="eventMode(event);">
                                            <option value="<?= $mode ?>" selected><?= $mode ?></option>
                                            <?php $options = ["Physical", "Virtual", "Physical & Virtual"];
                                            foreach ($options as $option) {
                                                if ($option != $mode) { ?>
                                                    <option value="<?= $option ?>"><?= $option ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="flag-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width far fa-flag clr-green margin-side-lg"></i>
                            <div class="flex-row">
                                <p class="head-margin">Event by <a class="clr-black" href="/Organisation/view?page=about&org_id=<?= $org_uid ?>"><b><?= $organisation_username ?></b></a></p>
                            </div>
                        </div>
                    </div>

                    <div class="human-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width fas fa-user-friends clr-green margin-side-lg"></i>
                            <h4 class="head-margin"><?= $volunteered ?> people volunteered</h4>
                        </div>
                    </div>

                    <div class="human-container">
                        <div class="flex-row margin-lg">
                            <i class="btn-icon icon-width fas fa-hand-holding-usd clr-green margin-side-lg"></i>
                            <h4 class="head-margin"><?php echo 'Rs. ' . number_format($donations, 2) ?> Donations recieved</h4>
                        </div>
                    </div>

                    <div class="textbox flex-col content border-round margin-md" style="background-color: #eeeeee">
                        <h3 class="margin-lg">Description</h3>
                        <div class="data">
                            <p class="margin-lg"><?= $about ?></p>
                        </div>
                        <textarea name="about" value="<?= $about ?>" class="form about-textarea margin-lg hidden" placeholder="Enter about us"><?= $about ?></textarea>
                    </div>

                    <?php if ($organization || $moderator) { ?>
                    </form>
                <?php } ?>

            </div>

            <?php if (($volunteer_status == 1) && ($status == 'published')) { ?>
                <div class="flex-col flex-center content border-round container-size1 margin-md volunteer-container" style="background-color: #03142d;">
                    <p class="margin-md" style="color:white; text-align:center">Interested in joining hands with us?</p>
                    <div class="progress" data-width="<?php if ($volunteer_percent == "NULL") echo "0";
                                                        else echo round($volunteer_percent); ?>%">
                        <div class="volunteers-progress-bar"></div>
                    </div>
                    <?php if ($guest_user) { ?>
                        <button class="btn clr-green margin-md" onclick="window.location.href='/Login/view/'"><i class="fas fa-user-friends"></i>&nbsp;I want to volunteer</button>
                    <?php } else if ($organization || $admin) { ?>
                        <button class="btn clr-green margin-md" disabled><i class="fas fa-user-friends"></i>&nbsp;I want to volunteer</button>
                    <?php } else if ($registered_user) { ?>
                        <button class="btn clr-green margin-md" onclick="togglePopup('volunteer-form'); blur_background('background');stillBackground('id1')"><i class="fas fa-user-friends"></i>&nbsp;I want to volunteer</button>
                    <?php } ?>

                </div>
            <?php } ?>

            <?php if (($donation_status == 1) && ($status == 'published')) { ?>
                <div class="flex-col flex-center content border-round container-size1 margin-md donation-container" style="background-color: #03142d; text-align:center">
                    <p style="color:white">Would you like to give value to your hard-earned money by contributing to this community service project?</p>
                    <div class="progress" data-width="<?php if ($donation_percent == NULL) echo "0";
                                                        else echo round($donation_percent); ?>%">
                        <div class="donaters-progress-bar"></div>
                    </div>
                    <?php if ($guest_user) { ?>
                        <button class="btn clr-green margin-md" onclick="window.location.href='/Login/view/'"><i class="fas fa-hand-holding-usd"></i>&nbsp;Donate Now!</button>
                    <?php } else if ($organization || $admin) { ?>
                        <button class="btn clr-green margin-md" disabled><i class="fas fa-hand-holding-usd"></i>&nbsp;Donate Now!</button>
                    <?php } else if ($registered_user) { ?>
                        <button class="btn clr-green margin-md" onclick="togglePopup('form'); blur_background('background');stillBackground('id1')"><i class="fas fa-hand-holding-usd"></i>&nbsp;Donate Now!</button>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="content border-round container-size1 home-events">
                <div class="flex-col flex-center grid-row-1" style="text-align:center">
                    <h4 class="margin-md felx-row flex-center">Want to clear out all your doubts?<br>Curious to know who we are?</h4>
                    <p>We are just one click away!</p>
                    <div>
                        <button class="btn btn-solid margin-md" onclick="window.location.href='/RegisteredUser/chatApp?new_chat_id=<?= 'EVN' . $_GET['event_id'] ?>'">Chat with us</button>
                    </div>
                </div>
                <div class="flex-row flex-center">
                    <img src="/Public/assets/chat.gif" style="height:200px" alt="">
                </div>
            </div>

            <div class="flex-row flex-center margin-lg">
                <div class="margin-md">
                    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button margin-md" data-size="large" data-show-count="false">Tweet</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
                <div class="margin-md" style="margin-bottom: 12px; border-radius:20px; overflow:hidden;width:75px">
                    <div id="fb-root"></div>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v12.0" nonce="xqUnsUm7"></script>
                    <div class="fb-share-button" data-href="https://www.communityretreat.me/Event/view?page=about&event_id=<?= $_GET['event_id'] ?>" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                </div>
            </div>

            <?php if (($moderator || $organization) && ($status != 'ended')) { ?>
                <div class="flex-row flex-center content border-round container-size1">
                    <button class="btn data margin-lg" onclick="edit()">Edit &nbsp;&nbsp; <i class="fas fa-edit "></i></button>
                    <button type="button" class="btn btn-solid bg-red border-red form margin-side-md hidden" onclick="edit()">Close &nbsp;&nbsp; <i class="fas fa-times "></i></button>
                    <button name="event_id" value="<?= $_GET["event_id"] ?>" form="update-form" type="submit" class="btn btn-solid form hidden">Save &nbsp; <i class="fas fa-check "></i></button>
                    <?php if ($status == "added") { ?>
                        <input type="text" name="status" form="update-form" class="hidden" id="publish-input">
                        <button type="button" id="publish-btn" class="btn margin-lg" onclick="publish(); togglePopup('publish'); blur_background('background'); stillBackground('id1')">Publish</button>
                    <?php } ?>
                </div>
            <?php } ?>
            <!-- complaint div -->
            <div class="container-size">
                <?php if (!($organization || $admin)) include "complaint.php" ?>
            </div>
        </div>
    </div>

    <div class="popup" id="publish">
        <div class="content">
            <div>
                <h2>Event Published!</h2>
            </div>
        </div>
    </div>
    <div class="popup" id="volunteer-form">
        <div class="content volunteer-popup">
            <div>
                <h3>What are the days you would like to volunteer ?</h3>
            </div>
            <form action="/Volunteer/volunteerEvent?event_id=<?= $_GET["event_id"] ?>" method="post">
                <button type="button" class="btn-icon btn-close" onclick="togglePopup('volunteer-form'); blur_background('background'); stillBackground('id1')"><i class="fas fa-times"></i></button>
                <?php
                $event_days = [];

                $startDate = new DateTime($start_date);
                $interval = new DateInterval('P1D');
                $realEnd = new DateTime($end_date);
                $realEnd->add($interval);


                $period = new DatePeriod($startDate, $interval, $realEnd);
                foreach ($period as $date) {
                    $event_days = $date->format('Y-m-d');
                    if ($volunteer_capacity_exceeded[$event_days] == true) {
                        $v_flag = FALSE;
                        echo "<div class='flex-row flex-center'><h3>" . $event_days . "</h3>
                            <input type='checkbox'  name='volunteer_date[]' value='$event_days'";
                        for ($i = 0; $i < count($volunteer_date); $i++) {
                            if ($event_days == $volunteer_date[$i]['volunteer_date']) {
                                echo 'checked ';
                                $v_flag = TRUE;
                            }
                        };
                        if (!$v_flag) {
                            echo " disabled ";
                        }
                        echo "></div>";
                    } else {
                        echo "<div class='flex-row flex-center'><h3>" . $event_days . "</h3>
                            <input type='checkbox'  name='volunteer_date[]' value='$event_days'";
                        for ($i = 0; $i < count($volunteer_date); $i++) {
                            if ($event_days == $volunteer_date[$i]['volunteer_date']) {
                                echo 'checked';
                            }
                        };
                        echo "></div>";
                    }
                }


                ?>
                <button class="btn btn-solid margin-md" type="submit" id="volunteer-btn" onClick="swithtoUnvolunteer()">Volunteer</button>
            </form>

        </div>

    </div>

    <div class="popup" id="form">
        <div class="content">
            <div>
                <h2>Donation form</h2>
            </div>
            <div>
                <button class="btn-icon btn-close" onclick="togglePopup('form'); blur_background('background'); stillBackground('id1')"><i class="fas fa-times"></i></button>
            </div>
            <form action="/Donations/pay?event_id=<?= $_GET['event_id'] ?>" class="form-container" method="post">

                <div class="form-item">
                    <label>Amount</label>
                    <input type="number" name="amount" id="amount" min="1000" step="10" required class="form-ctrl" placeholder="Enter The Amount(LKR)">
                </div>

                <div>
                    <div class="terms-and-conditions">
                        <ul>
                            <h3 class="center">Terms and Conditions</h3>
                            <li>
                                <p>No refunds will be made except for the removal or cancellation of an event after a donation has been made.</p>
                            </li>
                        </ul>
                    </div>
                    <div onload="disableSubmit()">
                        <input type="checkbox" min="0" name="terms" id="terms" onchange="activateButton(this)"> I Agree Terms & Coditions
                    </div>
                </div>


                <button class="btn btn-solid margin-md" type="submit" id="donate-btn" disabled>Donate</button>
            </form>
        </div>
    </div>


</body>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSB7zeeAI3QC42UmxHEFqS715ulfPFASc&callback=initMap&libraries=&v=weekly" async></script>


<script>
    <?php if ($organization || $moderator) { ?>

        function publish() {
            document.getElementById("publish-input").name = "status";
            document.getElementById("publish-input").value = "published";
            setTimeout(function() {
                document.getElementById("update-form").submit()
            }, 2000);
        }

        <?php $today = gmdate("Y-m-d", (int)shell_exec("date '+%s'"));
        $min_date = min($today, $start_date); ?>

        document.getElementById("start_date").setAttribute("min", "<?= $min_date ?>");
        document.getElementById("end_date").setAttribute("min", "<?= $today ?>");
        document.getElementById("start_date").addEventListener("change", () => {
            document.getElementById("end_date").setAttribute("min", document.getElementById("start_date").value);
        });


        function edit() {

            var data = document.getElementsByClassName("data");
            var form = document.getElementsByClassName("form");
            for (var i = 0; i < data.length; i++) {
                data[i].classList.toggle("hidden");
            }
            for (var i = 0; i < form.length; i++) {
                form[i].classList.toggle("hidden");
            }

            if (marker.getDraggable() == true)
                marker.setOptions({
                    draggable: false
                });
            else
                marker.setOptions({
                    draggable: true
                });
        }


        if (document.getElementById("mode").value == "Virtual") {
            document.getElementById("map").style.opacity = "0.3";
            document.getElementById("map").style.pointerEvents = "none";
        }


        function eventMode(event) {
            if (event.target.value == "Physical" || event.target.value == "Physical & Virtual") {
                document.getElementById("map").style.opacity = "1";
                document.getElementById("map").style.pointerEvents = "unset";
                document.getElementById("map").classList.remove("hidden");

            } else {
                document.getElementById("map").style.opacity = "0.3";
                document.getElementById("map").style.pointerEvents = "none";
            }
        }


    <?php } ?>

    <?php if (isset($_GET["volunteerErr"])) echo "edit();" ?>

    function togglePopup(id) {
        document.getElementById(id).classList.toggle("active");
    }

    function blur_background(id) {
        document.getElementById(id).classList.toggle("blurred")
    }

    <?php if ($registered_user && isset($_GET["action"]) && $_GET["action"] == "donate") { ?>
        window.addEventListener('load', (event) => {
            togglePopup('form');
            blur_background('background');
            stillBackground('id1')
        });
    <?php } ?>

    <?php if ($registered_user && isset($_GET["action"]) && $_GET["action"] == "volunteer") { ?>
        window.addEventListener('load', (event) => {
            togglePopup('volunteer-form');
            blur_background('background');
            stillBackground('id1')
        });
    <?php } ?>

    <?php if ($registered_user && isset($_GET["action"]) && $_GET["action"] == "complain") { ?>
        window.addEventListener('load', (event) => {
            popupForm('complaint-form');
        });
    <?php } ?>

    function disableSubmit() {
        document.getElementById("donate-btn").disabled = true;
    }

    function stillBackground(id) {
        document.getElementById(id).classList.toggle("still");
    }

    function activateButton(element) {

        if (element.checked) {
            document.getElementById("donate-btn").disabled = false;
        } else {
            document.getElementById("donate-btn").disabled = true;
        }

    }


    function animateProgressBar(el, width) {

        var usedWidth = width;
        if (parseInt(width.replace('%', '')) < 20) {
            usedWidth = '20%';
        }

        el.animate({
            width: (parseInt(width.replace('%', '')) > 100 ? "100%" : usedWidth)
        }, {
            duration: 2000,
            step: function(now, fx) {
                if (fx.prop == 'width') {
                    if (parseInt(width.replace('%', '')) < now && now <= 100) {
                        now = parseInt(width.replace('%', ''));
                    }
                    el.html(Math.round(now * 100) / 100 + '%');
                }
            }
        });

        setTimeout(() => {
            el.html(width);
        }, 2100)
    }

    $('.progress').each(function() {
        animateProgressBar($(this).find("div"), $(this).data("width"));
    });



    let map;
    var marker;

    function initMap() {
        resizeMap();
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -34.397,
                lng: 150.644
            },
            zoom: 8,
        });
        getLocation();
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }


    function showPosition(position) {
        var latitude = '<?= $latitude ?>';
        var longitude = '<?= $longitude ?>';


        latitude = (latitude == '' || latitude == 0) ? position.coords.latitude : latitude;
        longitude = (longitude == '' || longitude == 0) ? position.coords.longitude : longitude;

        var myLatlng = new google.maps.LatLng(latitude, longitude);

        marker = new google.maps.Marker({
            position: myLatlng,
            draggable: false,
            title: "Event location"
        });

        console.log(latitude, longitude);
        // To add the marker to the map, call setMap();
        marker.setMap(map);

        google.maps.event.addListener(marker, 'dragend', function(evt) {
            console.log("asdasd");
            document.getElementById('longitude').value = evt.latLng.lng().toFixed(3);
            document.getElementById('latitude').value = evt.latLng.lat().toFixed(3);
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
        map.setCenter(myLatlng);
        map.setZoom(15);
    }

    function resizeMap() {
        console.log(document.getElementById("details").offsetWidth);
        document.getElementById("map").style.width = parseInt(document.getElementById("details").offsetWidth) * 0.7 + "px";
    }
    window.addEventListener("resize", resizeMap);


    function fillComplaint() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var complaint_event_id = document.getElementById("complaint_event_id");
        complaint_event_id.setAttribute("value", urlParams.get('event_id'));
        console.log(urlParams.get('event_id'));
        var complaint_name = document.getElementById('complaint_name');
        complaint_name.setAttribute("value", '<?= $event_name ?>');
        var complaint_status = document.getElementById('complaint_status');
        complaint_status.setAttribute("value", 'event');

    }

    fillComplaint();

    function renderVoluneerDonationContainers() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var donation_container = document.querySelector('.donation-container');
        var volunteer_container = document.querySelector('.volunteer-container');
        if (urlParams.get('action') == "volunteer") {
            volunteer_container.style.display = 'flex';
            console.log('hello pik');
        }
        if (urlParams.get('action') == "donate") {
            donation_container.style.display = 'flex';
        }
    }
    renderVoluneerDonationContainers();
</script>

</html>