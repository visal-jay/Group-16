<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Public/assets/newstyles.css">
    <script src="https://kit.fontawesome.com/c119b7fc61.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
    textarea {
        height: 150px;
        padding: 12px 20px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #f8f8f8;
        font-size: 16px;
        resize: none;
    }

    .events {
        width: 80%;
    }

    .event-link {
        text-decoration-color: none;
        color: black;
    }

    .form {
        min-width: 50%;
        overflow: hidden;
        height: 0px;
        transition: height, 0.3s linear;
    }

    .show-form {
        height: 750px;
        transition: height, 0.3s linear;
    }

    #map {
        height: 350px;
        width: 350px;
        border-radius: 8px;
    }

    table {
        width: 100%;
        table-layout: fixed;
    }

    td {
        text-align: center;
        padding: 1rem 0;
    }

    .event-card-details {
        display: flex;
        flex-direction: row;
    }

    .date {
        display: flex;
        flex-direction: row;
    }

    @media screen and (max-width:800px) {
        .events {
            width: 100%;
        }

        .card-container {
            height: 220px;
        }

        .form {
            width: 80%;

        }

        .show-form {
            height: 900px;
            transition: height, 0.3s linear;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        #map {
            width: 300px;
            height: 300px;
        }

        table tr>* {
            display: block;
        }

        table tr {
            display: table-cell;
        }

        table th {
            padding: .5rem 0;
            text-align: left;
        }

        td {
            padding: .5rem 0;
        }

        .event-card-details {
            flex-direction: column;
        }


        .date {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
<?php include "nav.php" ?>

<body>
    <?php if (!isset($_SESSION)) session_start();
    if (!isset($moderator)) $moderator = false;
    if (!isset($treasurer)) $treasurer = false;
    $organization = $admin = $registered_user = $guest_user = false;

    if (isset($_SESSION["user"]["user_type"])) {
        if ($_SESSION["user"]["user_type"] == "organization") {
            $organization = true;
        }
        if ($_SESSION["user"]["user_type"] == "admin") {
            $$admin = true;
        }
        if ($_SESSION["user"]["user_type"] == "registered_user") {
            $registered_user = true;
        }
    } else {
        $guest_user = true;
    }
    ?>
    <div class="flex-col flex-center margin-side-lg">
        <h1>Manage Events</h1>

        <button class="btn btn-solid margin-lg" onclick="addEvent()">Add Event &nbsp; <i class="fas fa-plus"></i></button>
        <div class="form">
            <form class="form-item" method="post" action="/event/addEvent">
                <label>Event name</label>
                <input type="text" name="event_name" class="form-ctrl" placeholder=" Enter Event Name" required style="font-family:Arial, FontAwesome" />
                <label>Description</label>
                <textarea name="about" class="form-ctrl"></textarea>

                <div class="date" style="justify-content:space-evenly">
                    <div class="flex-col">
                        <label>Date</label>
                        <input id="start_date" type="date" name="start_date" class="form-ctrl">
                    </div>
                    <div class="flex-col">
                        <label>Starting time</label>
                        <input type="time" name="start_time" class="form-ctrl">
                    </div>
                    <div class="flex-col">
                        <label>Ending time</label>
                        <input type="time" name="end_time" class="form-ctrl">
                    </div>
                    <div class="flex-col">
                        <label>Mode of the event</label>
                        <select class="form-ctrl" id="mode" name="mode" required onchange="eventMode(event);">
                            <option value="" disabled selected>Select the mode of the event</option>
                            <option value="Physical">Physical</option>
                            <option value="Virtual">Virtual</option>
                            <option value="Physical & Virtual">Physical & Virtual</option>
                        </select>
                    </div>
                </div>
                <div class="flex-col flex-center">
                    <div class="border-round" id="map"></div>
                    <div class="latlang" class="form hidden">
                        <input class="hidden" name="longitude" id="longitude" value=NULL>
                        <input class="hidden" name="latitude" id="latitude" value=NULL>
                    </div>
                </div>
                <button type="submit" class="btn btn-solid margin-md">Add</button>
            </form>
        </div>
        <div class="events">
            <?php foreach ($events as $event) { ?>
                <div class="card-container margin-md">
                    <a class="event-link" href="/event/view?page=about&&event_id=<?= $event["event_id"] ?>">
                        <h3 class="heading"><?= $event["event_name"] ?></h3>
                    </a>
                    <div class="event-card-details margin-md">
                        <table>
                            <tr>
                                <th>Event date</th>
                                <th>Volunteering</th>
                                <th>Donations</th>

                            </tr>
                            <tr>
                                <td><?= $event["start_date"] ?></td>
                                <td><?php if ($event["volunteer_status"]) { ?><i class="fas fa-check clr-green"></i><?php } else { ?><i class="fas fa-times clr-red"></i><?php } ?> </td>
                                <td><?php if ($event["donation_status"]) { ?><i class="fas fa-check clr-green"></i><?php } else { ?><i class="fas fa-times clr-red"></i><?php } ?> </td>
                            </tr>
                        </table>
                        <div class="flex-row flex-center">
                            <button class="btn btn-solid bg-red border-red" onclick="remove()">Remove</button>
                            <div class="flex-row flex-space " style="display: none; padding-top:1rem;">
                                <p class="margin-side-md" style="white-space: nowrap;">Are you sure</p>
                                <form method="post" action="/event/remove" class="flex-row flex-center">
                                    <input name="event_id" class="hidden" value="<?= $event["event_id"] ?>">
                                    <button class="btn-icon flex-row flex-center"><i type="submit" class="fas fa-check clr-green margin-side-md"></i>&nbsp;</button>
                                </form>
                                <i class="fas fa-times clr-red  margin-side-md" onclick="cancel()"></i>
                            </div>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN2HxM42eIrEG1e5b9ar2H_2_V6bMRjWk&callback=initMap&libraries=&v=weekly" async></script>

<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("start_date").setAttribute("min", today);

    var today = new Date();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    function addEvent() {
        document.querySelector(".form").classList.toggle("show-form");
    }

    function eventMode(event) {
        if (event.target.selectedIndex == 1 || event.target.selectedIndex == 3) {
            document.getElementById("map").style.opacity = "1";
            document.getElementById("map").style.pointerEvents = "unset";

        } else {
            document.getElementById("map").style.opacity = "0.3";
            document.getElementById("map").style.pointerEvents = "none";
        }
    }

    function remove() {
        event.target.style.display = "none";
        event.target.nextElementSibling.style.display = "flex";
    }

    function cancel() {
        var cancel = event.target.parentNode;
        cancel.style.display = "none";
        cancel.previousElementSibling.style.display = "block";

    }

    let map;
    var marker;

    function initMap() {
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
        console.log(position);
        var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        marker = new google.maps.Marker({
            position: myLatlng,
            draggable: true,
            title: "Event location"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);

        google.maps.event.addListener(marker, 'dragend', function(evt) {
            document.getElementById('longitude').value = evt.latLng.lng().toFixed(3);
            document.getElementById('latitude').value = evt.latLng.lat().toFixed(3);
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
        map.setCenter(myLatlng);
        map.setZoom(15)
    }
</script>

</html>