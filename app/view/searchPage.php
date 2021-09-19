<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Public/assets/newstyles.css">
    <script src="https://kit.fontawesome.com/c119b7fc61.js" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <title>Document</title>
</head>
<style>
    h1 {
        text-align: center;
        margin-top: 0;
    }

    h3 {
        margin: 0;
    }



    .flex-row-to-col {
        display: flex;
        flex-direction: row;
    }

    choices {
        margin-top: 1rem;
        width: 100%;
        background: #EEEEEE;
        border-radius: 8px;
        transition: height, 0.3s linear;
        overflow: visible;
    }

    .show-choices {
        height: 70px;
        transition: height, 0.3s linear;
        overflow: visible;
    }

    .slidecontainer {
        width: 30%;
    }

    .slider {
        -webkit-appearance: none;
        border-radius: 8px;
        width: 100%;
        height: 0.5rem;
        background: #d3d3d3;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        border-radius: 50%;
        width: 1rem;
        height: 1rem;
        background: #04AA6D;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: #04AA6D;
        cursor: pointer;
    }

    .slidecontainer p {
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .choice-menu {
        display: none;
    }

    #sort,
    #date,
    #way,
    #mode {
        margin: 0;
        margin-left: 0.5rem;
    }

    search {
        width: 100%;
        max-width: 100%;
        background-color: #0A1931;
        padding: 2rem;
        box-sizing: border-box;
    }



    search input[type=search] {
        width: 90%;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
    }

    search input[type=search]:focus {
        width: 100%;
    }



    .homepage {
        margin: 0 auto;
        width: 80%;
    }

    .grid {
        margin-top: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, 250px);
        width: 100%;
        justify-content: center;
        gap: 2rem;
    }

    figure {
        min-height: 100px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        border-radius: 3px;
        margin: 0;
        min-width: 250px;
        width: 250px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
    }

    figure p,
    h1,
    h2,
    h3 {
        font-family: Roboto, Arial, sans-serif;
    }

    figure p {
        margin: 0;
    }


    figure .content {
        position: relative;
    }

    figure .stats {
        top: 0;
        position: absolute;
        width: 100%;
        height: 100% !important;
        background-color: #000000aa;
        color: white;
        display: none;
        text-align: center;
        align-items: center !important;
        justify-content: center;
    }

    .photo-container {
        position: relative;
    }

    figure:hover .stats {
        display: flex;

    }

    figure img {
        aspect-ratio: 4/2;
        max-width: 250px !important;
    }

    figure .about {
        font-size: smaller;
        white-space: normal;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
    }


    .grid div img {
        aspect-ratio: 4/2;
        width: 100%;
        border-radius: 8px;
    }

    #map {
        width: 450px;
        height: 400px;
    }

    .map-index{
        z-index: -1;
    }

    @media screen and (max-width:800px) {

        .slider {
            width: auto;
        }

        .grid {
            grid-gap: 10px;
            grid-template-columns: repeat(auto-fill, 250px);
        }

        .choice-menu {
            display: none;
            display: flex;
            align-self: flex-end;
        }

        choices {
            height: 0;
            overflow: hidden;

        }

        .show-choices {
            height: 220px;
            transition: height, 0.3s linear;
        }

        .slidecontainer {
            width: 80%;
        }

        h1 {
            font-size: 1.5rem;
        }

        .flex-row-to-col {
            align-items: flex-start;
            justify-content: left;
            flex-direction: column;
        }

        #near-me {
            margin: 10px;
        }
    }
</style>
<?php include "nav.php" ?>

<body>
    <div class="homepage flex-col flex-center">
        <h1>Search to your choice</h1>
        <search class="flex-row-to-col flex-center border-round">
            <form action="/Search/view" class="flex-row-to-col flex-center">
                <div class="search-bar" style="height:fit-content">
                    <input type="search" class="form-ctrl clr-white" placeholder="Search" id="in-search" onkeyup="range='';">
                    <button type="submit" class="btn-icon clr-green "><i class=" fa fa-search "> </i></button>
                </div>
                <div><button type="button" class="btn btn-solid" id="near-me" onclick="nearme()"><i class="fas fa-map-marker-alt"></i>&nbsp;Near me</button></div>

            </form>
        </search>

        <div class="choice-menu margin-md">
            <button class="btn-icon" onclick="choices()"><i class="fas fa-sliders-h" style="font-size:1.5em"></i></button>
        </div>

        <choices class="flex-col">
            <div class="flex-row-to-col  flex-space">
                <button type="button" class="btn btn-solid margin-md" onclick="document.getElementById('map-container').classList.toggle('hidden');resizeMap();">Search by location</button>
                <div class="flex-row flex-center margin-md">
                    <label>Date: &nbsp; </label>
                    <input type="text" id="calendar-input"  class="hidden" value="" onchange="search();">
                    <div style="position: relative;">
                        <button type="button" class="btn" onclick="calendarShow();" style="border: 1px solid #ccc;color:black">year-month-date &nbsp;<i class="far fa-calendar-alt"></i></button>
                        <div style="position: absolute; top:40px; left:-50px;" class="hidden" id="search-input-calendar">
                            <?php include "calendarInput.php" ?>
                        </div>
                    </div>
                </div>

                <select class="form-ctrl" id="mode" name="mode" style="margin-left:0.5rem" required onchange="search();">
                    <option value="" disabled selected>Select the mode of the event</option>
                    <option value="Physical">Physical</option>
                    <option value="Virtual">Virtual</option>
                    <option value="Physical & Virtual">Physical & Virtual</option>
                </select>

                <div class="flex-row-to-col flex-center">
                    <div class="flex-row flex-center margin-md">
                        <select id="sort" class="form-ctrl" onchange="search();">
                            <option selected disabled>Sort by</option>
                            <option value=distance>Distance</option>
                            <option value=start_date>Date</option>
                            <option value=volunteered>Volunteers</option>
                            <option value=donations>Donations</option>
                        </select>
                        <select id="way" class="form-ctrl" style="margin-left:0.5rem" onchange="search();">
                            <option selected disabled>Sort</option>
                            <option value=ASC>Ascending</option>
                            <option value=DESC>Descending</option>
                        </select>
                    </div>

                </div>
            </div>
        </choices>

        <div id="map-container" class="margin-md hidden" style="width: 100%;text-align:center;">
            <i class="fas fa-times margin-md" style="cursor: pointer; float:right;" onclick="document.getElementById('map-container').classList.toggle('hidden');"></i>
            <div id="map"></div>
        </div>

        <events class="grid">
        </events>
    </div>

</body>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN2HxM42eIrEG1e5b9ar2H_2_V6bMRjWk&callback=initMap&libraries=&v=weekly" async></script>
<script>

    function calendarShow(){
        document.getElementById('search-input-calendar').classList.toggle('hidden');
        document.getElementById("map-container").classList.toggle('map-index');
        document.querySelector('.grid').classList.toggle('map-index');
    }
    const debounce = (func, delay) => {
        let debounceTimer
        return function() {
            const context = this
            const args = arguments
            clearTimeout(debounceTimer)
            debounceTimer
                = setTimeout(() => func.apply(context, args), delay)
        }
    }

    function createElementFromHTML(htmlString) {
        var div = document.createElement('div');
        div.innerHTML = htmlString.trim();
        return div.firstChild;
    }

    let params = new URLSearchParams(location.search);
    var range = params.get("distance");
    document.getElementById("in-search").value = params.get("search");

    if (range) {
        document.getElementById("map-container").classList.toggle("hidden");
        resizeMap();
    }

    function getCoordinates() {
        return new Promise(
            function(resolve, reject) {
                navigator.geolocation.getCurrentPosition(resolve, reject);
            }
        );
    }

    async function search() {

        const position = await getCoordinates();
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;

        var name = document.getElementById("in-search").value;
        var mode = (document.getElementById("mode").value);
        var range = range;
        var date = document.getElementById("calendar-input").value;
        var sort = document.getElementById("sort").value == "Sort by" ? "" : document.getElementById("sort").value;
        var way = document.getElementById("way").value == "Sort" ? "" : document.getElementById("way").value;


        let parent_container = document.querySelector('events');
        

        $.ajax({
            url: "ajax/Search/searchAll", //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: {
                name: name,
                mode: mode,
                latitude: latitude,
                longitude: longitude,
                distance: range,
                start_date: date,
                order_type: sort,
                way: way,
                status: 'published',
            },
            success: function(result) {
                parent_container.innerHTML = "";
                result.forEach(evn => {
                    let template = `
                    <figure onclick="location.href = '/event/view?page=about&&event_id=${evn.event_id}' ">
                        <div class="content">
                            <div class="photo-container"><img src="${evn.cover_photo}" style="object-fit: cover;" alt="">
                                <div class="stats">
                                <div>
                                    <span>Volunteered ${evn.volunteered==null ? 0 : Math.round(evn.volunteer_percent)}%</span>
                                    <br>
                                    <span>Donations ${evn.dotaion_percent==null ? 0 : Math.round(evn.dotaion_percent)}%</span>
                                    <br>
                                    <span>Distance ${evn.distance==null ? " - " : Math.round(evn.distance)} KM</span>
                                    </div>
                                </div>
                            </div>
                            <p class="margin-md" style="margin-bottom:0;color:white;padding:4px;background-color:#F67280;border-radius:15px;text-align:center;font-size:0.85em;">Event</p>
                            <p class="margin-md" style="margin-bottom:0;"><b>${evn.event_name}</b></p>
                            <p class="margin-md about" style="margin-top:0">${evn.start_date}</p>
                            <div class="flex-col margin-side-md" >
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <p>Donations</p>
                                <p>${evn.donation_status==0 ? '<i class="fas fa-times fa-xs clr-red margin-side-md"></i>' : '<i class="fas fa-check fa-xs clr-green margin-side-md"></i>'}</p>
                                </div>
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <div style="display:flex;align-items:center;position:relative;width:100%;"><div style="border-radius:6px;position:absolute;width:${(evn.donation_percent==null || evn.donation_percent<5) ? 5 : Math.round(evn.donation_percent)}%;background-color:#FFB319;height:6px;"></div></div>
                                <p>${evn.donation_percent==null ? 0 : Math.round(evn.donation_percent)}%</p>

                                </div>
                            </div>
                            <div class="flex-col margin-side-md">
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <p>Volunteered</p>
                                <p>${evn.volunteer_status==0 ? '<i class="fas fa-times fa-xs clr-red margin-side-md"></i>' : '<i class="fas fa-check fa-xs clr-green margin-side-md"></i>'}</p>
                                </div>
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <div style="display:flex;align-items:center;position:relative;width:100%;"><div style="border-radius:6px;position:absolute;width:${(evn.volunteer_percent==null || evn.volunteer_percent<5) ? 5 : Math.round(evn.volunteer_percent)}%;background-color:#8236CB;height:6px;"></div></div>
                                <p>${evn.volunteer_percent==null ? 0 : Math.round(evn.volunteer_percent)}%</p>
                                </div>
                            </div>
                            <div>
                                <p class="margin-md about">${evn.about}</p>
                            </div>
                        </div>
                    </figure>
                    `;
                    parent_container.appendChild(createElementFromHTML(template));
                });
            }
        });
        Nearsearch(latitude, longitude);
        if (!(range || mode || date || sort || way))
            orgSearch(name);
    }

    function orgSearch(name) {
        $.ajax({
            url: "ajax/Search/searchOrganisation", //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: {
                org_username: name,
            },
            success: function(result) {
                let parent_container = document.querySelector('events');
                result.forEach(org => {
                    let template = `
                    <figure onclick="location.href = '/organisation/view?org_id=${org.uid}' ">
                        <div class="content">
                            <div class="photo-container"><img src="${org.cover_pic}" style="object-fit: cover;" alt="">
                            <p class="margin-md" style="margin-bottom:0;color:white;padding:4px;background-color:#44c9d6;border-radius:15px;text-align:center;font-size:0.85em;">Organisation</p>
                            <p class="margin-md" style="margin-bottom:0;"><b>${org.username}</b></p>
                            <p class="margin-md about" style="margin-top:0">${org.email}</p>
                            <p class="margin-md about" style="margin-top:0">${org.contact_number}</p>
                            <div>
                                <p class="margin-md about">${org.about}</p>
                            </div>
                        </div>
                    </figure>
                    `;
                    parent_container.appendChild(createElementFromHTML(template));
                });

            }
        });
    }

    window.onload = search;
    document.getElementById("in-search").addEventListener('keyup', debounce(search, 100));


    function choices() {
        document.getElementsByTagName("choices")[0].classList.toggle("show-choices");
    }



    function getCoordinates() {
        return new Promise(
            function(resolve, reject) {
                navigator.geolocation.getCurrentPosition(resolve, reject);
            }
        );
    }


    var map;
    var markers = [];
    async function initMap() {
        const position = await getCoordinates();
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        const current_location = {
            lat: latitude,
            lng: longitude
        };
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: current_location,
        });

        var custom_marker = {
            url: '/Public/assets/street-view-solid.svg',
            size: new google.maps.Size(100, 100),
            // The origin for this image is (0, 0).
            origin: new google.maps.Point(0, 0),
            // The anchor for this image is the base of the flagpole at (0, 32).
            anchor: new google.maps.Point(0, 0),
        }
        new google.maps.Marker({
            position: current_location,
            draggable: false,
            map,
            title: "Your location",
            icon: custom_marker
        });

        map.addListener("center_changed", () => {
            let latlang = map.getCenter();
            Nearsearch(latlang.lat(), latlang.lng());
        });
        Nearsearch(latitude, longitude);
    }

    async function Nearsearch(latitude, longitude) {
        var range = 1000;
        var date = document.getElementById("calendar-input").value;
        var sort = document.getElementById("sort").value == "Sort by" ? "" : document.getElementById("sort").value;
        var way = document.getElementById("way").value == "Sort" ? "" : document.getElementById("way").value;
        hideMarkers();
        $.ajax({
            url: "ajax/Search/searchAll", //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: {
                latitude: latitude,
                longitude: longitude,
                distance: range,
                start_date: date,
                order_type: sort,
                way: way,
                status: 'published',
            },
            success: function(result) {

                if (result.length == 0)
                    return;
                else
                    result.forEach(evn => {
                        let template = `
                    <figure onclick="location.href = '/event/view?page=about&&event_id=${evn.event_id}' ">
                        <div class="content">
                            <div class="photo-container"><img src="${evn.cover_photo}" style="object-fit: cover;" alt="">
                                <div class="stats">
                                <div>
                                    <span>Volunteered ${evn.volunteered==null ? 0 : Math.round(evn.volunteer_percent)}%</span>
                                    <br>
                                    <span>Donations ${evn.dotaion_percent==null ? 0 : Math.round(evn.dotaion_percent)}%</span>
                                    <br>
                                    <span>Distance ${evn.distance==null ? "- " : Math.round(evn.distance)} KM</span>
                                    </div>
                                </div>
                            </div>
                            <p class="margin-md" style="margin-bottom:0;color:white;padding:4px;background-color:#F67280;border-radius:15px;text-align:center;font-size:0.85em;">Event</p>
                            <p class="margin-md" style="margin-bottom:0;"><b>${evn.event_name}</b></p>
                            <p class="margin-md about" style="margin-top:0">${evn.start_date}</p>
                            <div class="flex-col margin-side-md" >
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <p>Donations</p>
                                <p>${evn.donation_status==0 ? '<i class="fas fa-times fa-xs clr-red margin-side-md"></i>' : '<i class="fas fa-check fa-xs clr-green margin-side-md"></i>'}</p>
                                </div>
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <div style="display:flex;align-items:center;position:relative;width:100%;"><div style="border-radius:6px;position:absolute;width:${(evn.donation_percent==null || evn.donation_percent<5) ? 5 : Math.round(evn.donation_percent)}%;background-color:#FFB319;height:6px;"></div></div>
                                <p>${evn.donation_percent==null ? 0 : Math.round(evn.donation_percent)}%</p>

                                </div>
                            </div>
                            <div class="flex-col margin-side-md">
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <p>Volunteered</p>
                                <p>${evn.volunteer_status==0 ? '<i class="fas fa-times fa-xs clr-red margin-side-md"></i>' : '<i class="fas fa-check fa-xs clr-green margin-side-md"></i>'}</p>
                                </div>
                                <div class ="flex-row" style="justify-content:space-between;align-items:center;">
                                <div style="display:flex;align-items:center;position:relative;width:100%;"><div style="border-radius:6px;position:absolute;width:${(evn.volunteer_percent==null || evn.volunteer_percent<5) ? 5 : Math.round(evn.volunteer_percent)}%;background-color:#8236CB;height:6px;"></div></div>
                                <p>${evn.volunteer_percent==null ? 0 : Math.round(evn.volunteer_percent)}%</p>
                                </div>
                            </div>
                            <div>
                                <p class="margin-md about">${evn.about}</p>
                            </div>
                        </div>
                    </figure>
                    `;
                        const infowindow = new google.maps.InfoWindow({
                            content: template,
                        });

                        let pos = {
                            lat: evn.latitude,
                            lng: evn.longitude
                        }
                        let marker = new google.maps.Marker({
                            position: pos,
                            map,
                            title: evn.event_name,
                        });

                        markers.push(marker);

                        marker.addListener("click", () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                                shouldFocus: false,
                            });
                        });
                    });
            }
        });
    }

    function hideMarkers() {
        setMapOnAll(null);
    }

    function deleteMarkers() {
        hideMarkers();
        markers = [];
    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function resizeMap() {
        document.getElementById("map").style.width = parseInt(document.getElementById("map-container").offsetWidth) + "px";
    }
    window.addEventListener("resize", resizeMap);
</script>


</html>