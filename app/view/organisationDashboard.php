<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Public/assets/newstyles.css">
    <script src="https://kit.fontawesome.com/c119b7fc61.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
    .photo-container {
        height: 60%;
        text-align: center;
        position: relative;
        padding: 2rem 2rem 0rem 2rem;
    }

    .profile-pic {
        max-width: 9%;
        min-width: 80px;
        aspect-ratio: 1/1;
        background-color: gray;
        border: 1px solid white;
        position: absolute;
        overflow: hidden;
        top: 20px;
        left: 0;
        right: 0;
        margin: auto
    }


    .cover-place-holder {
        vertical-align: center;
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        max-height: 300px;
        min-height: 100px;
        background-color: gray;
        overflow: hidden;
        aspect-ratio: 5/2;
        max-width: 80%;
    }

    .photo-element {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .nav-secondary {
        display: flex;
        align-items: center;
        justify-content: center;

    }

    .nav-secondary-bar {

        display: flex;
        align-items: center;
        overflow: auto;

    }

    .active {
        background-color: #16c79a !important;
        color: white !important;
    }

    /* Designing for scroll-bar */
    ::-webkit-scrollbar {
        width: 2px;
        height: 8px;
        margin: 2rem;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: gainsboro;
        border-radius: 5px;
        padding: 10px;
        margin: 1rem;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #16c79a;
        border-radius: 5px;
        border: 1 px solid #16c79a;
        margin: 1rem;
        height: 1px;
        width: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #16c79a;
    }


    p {
        text-align: justify;
        text-justify: inter-word;
    }

    h1,
    h2 {
        margin: 5px 0;
    }

    .info {
        padding: 0 2rem;
    }

    #map {
        width: 100%;
        aspect-ratio: 2/1;
    }

    .image-upload {
        position: absolute;
        bottom: 11px;
        right: 11px;
    }

    .image-upload>input {
        display: none;
    }

    .latlang>input{
        height: 0px;
    }



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

    @media screen and (max-width:767px) {
        h1 {
            font-size: 1.5rem;
        }

        h2 {
            font-size: 1rem;
        }



        .event-card-details {
            flex-direction: column;
        }

        #map {
            width: 300px;
            height: 300px;
        }
    }
</style>
<?php include "nav.php"; ?>
<body>
    <?php $_SESSION["user"]["user_type"]="organization"; if($_SESSION["user"]["user_type"]=="organization") { ?> 
    <form action="/organisation/update" method="post">
    <?php } ?>
        <div class="photo-container">
            <div class="cover-place-holder cover border-round">
                <img src="../Public/assets/photo.jpeg" alt="" class="photo-element" styl>
                <?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
                <div class="image-upload hidden form">
                    <label for="file-input">
                        <i class="fas fa-edit clr-white"></i>
                    </label>
                    <input id="file-input" type="file" />
                </div>
                <?php } ?>
            </div>
            <div class="profile-pic border-round">
                <img src="../Public/assets/newphoto.jpeg" alt="" class="photo-element">
                <?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
                <div class="image-upload hidden form">
                    <label for="file-input">
                        <i class="fas fa-edit clr-white"></i>
                    </label>
                    <input id="file-input" type="file" />
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="flex-col flex-center ">
            <div class="info ">
                <div class="flex-row flex-center">
                    <div class="data">
                        <h1><?= $username ?></h1>
                    </div>
                </div>
                <div class="flex-col">
                    <h2>About us</h2>
                    <div class="data">
                        <p><?= $about_us ?></p>
                    </div>
                    <?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
                    <textarea name="about_us" class="form form-ctrl hidden" placeholder="Enter about us"><?= $about_us ?></textarea>
                    <?php } ?>
                </div>
                <div class="flex-col">
                    <h2>Contact us</h2>
                    <?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
                    <input type="email" class="form form-ctrl hidden" placeholder=" Enter email" value="<?= $email ?>" required>
                    <input type="tel" name="contact_number" class="form form-ctrl hidden" placeholder="Enter telephone number" value="<?= $contact_number ?>" pattern="^[+]?[0-9]{10,12}$" required>
                    <?php } ?>
                    <div class="data">
                        <a href="mailto:<?= $email ?>"><?= $email ?> </a>
                        <p><?= $contact_number ?></p>
                    </div>
                </div>
                <?php if($_SESSION["user"]["user_type"]=="organization" || (isset($map) && $map==true)) { ?>
                <div class="flex-col flex-center">
                    <h2>Locate us</h2>
                    <div id="map"></div>
                    <div class="latlang" class="form hidden">
                        <input class="hidden" name="longitude" id="longitude" value="<?= $longitude ?>">
                        <input class="hidden" name="latitude" id="latitude" value="<?= $latitude ?>">
                    </div>
                </div>
                <?php } ?>

                <?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
                <div class="flex-row" style="justify-content:flex-end;">
                    <button type="button" class="btn btn-solid data" onclick="edit()">Edit &nbsp;&nbsp; <i class="fas fa-edit "></i></button>
                    <button type="button" class="btn btn-solid bg-red border-red margin-side-md form hidden" onclick="edit()">Close &nbsp;&nbsp; <i class="fas fa-times "></i></button>
                    <button type="submit" class="btn btn-solid form hidden">Save &nbsp; <i class="fas fa-check "></i></button>
                </div>
                <?php } ?>
            </div>
        </div>
     <?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
    </form>
    <?php } ?>
    <div class="nav-secondary">
        <div class="nav-secondary-bar margin-lg">
            <a class="btn  margin-side-md" style=" margin-bottom:10px;" href="/view/adoption_listing.php ">About</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="# ">Events</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="# ">Gallery</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="/view/adoption_listing.php ">Feedback</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="/view/adoption_listing.php ">About</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="# ">Events</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="# ">Gallery</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="/view/adoption_listing.php ">Feedback</a>
            <a class="  btn margin-side-md active" style=" margin-bottom:10px;" href="/view/adoption_listing.php ">About</a>
            <a class=" btn margin-side-md" style=" margin-bottom:10px;" href="# ">Events</a>
            <a class=" btn margin-side-md" style=" margin-bottom:10px;" href="# ">Gallery</a>
            <a class="btn margin-side-md" style=" margin-bottom:10px;" href="/view/adoption_listing.php ">Fuck</a>
        </div>
    </div>


</body>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN2HxM42eIrEG1e5b9ar2H_2_V6bMRjWk&callback=initMap&libraries=&v=weekly" async></script>

<script>  
<?php if($_SESSION["user"]["user_type"]=="organization") { ?> 
    function edit() {
        if (marker.draggable == false)
            marker.setOptions({
                draggable: true
            });
        else
            marker.setOptions({
                draggable: false
            });
        var data = document.getElementsByClassName("data");
        var form = document.getElementsByClassName("form");
        for (var i = 0; i < data.length; i++) {
            data[i].classList.toggle("hidden");
        }
        for (var i = 0; i < form.length; i++) {
            form[i].classList.toggle("hidden");
        }
    }
    <?php } ?>

    function resizeProfile() {
        var coverHeight = (document.querySelector(".cover").offsetHeight);
        document.querySelector(".profile-pic").style.top = coverHeight + "px";
        var profileHeight = (document.querySelector(".profile-pic").offsetHeight);
        document.querySelector(".photo-container").style.height = (parseInt(coverHeight) + parseInt(profileHeight) * 0.75) + "px";
    }

    function resizeInfo() {
        var coverWidth = (document.querySelector(".cover").offsetWidth);
        document.querySelector(".info").style.width = coverWidth + "px";
    }

    function resize() {
        resizeProfile();
        resizeInfo();
    }
    window.onload = resize();
    window.addEventListener("resize", resize);


    document.querySelector(".active").scrollIntoView({
        behavior: 'auto',
        block: 'center',
        inline: 'center'
    });

    let map;
    var marker;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -34.397,
                lng: 10.644
            },
            zoom: 6,
        });
        showPosition();
    }

    function showPosition(position) {
        var myLatlng = new google.maps.LatLng(<?= $latitude ?>, <?= $longitude ?>);

        marker = new google.maps.Marker({
            position: myLatlng,
            draggable: false,
            title: "Hello World!"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
        map.setCenter(myLatlng);
        map.setZoom(10)

        google.maps.event.addListener(marker, 'dragend', function(evt) {
            document.getElementById('longitude').value=evt.latLng.lng().toFixed(3);
            document.getElementById('latitude').value=evt.latLng.lat().toFixed(3);
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
    }
</script>

</html>