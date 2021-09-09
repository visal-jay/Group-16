<!DOCTYPE html>
<html lang="en" id="id1">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Public/assets/newstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/c119b7fc61.js" crossorigin="anonymous"></script>
    <title>Forum</title>
</head>

<style>
    h3 {
        margin: 0;
    }

    update {
        display: flex;
        justify-content: flex-end;
    }

    .align-left {
        text-align: left;
    }

    .form {
        min-width: 50%;
        overflow: hidden;
        height: 0px;
        transition: height, 0.3s linear;
    }

    .show-form {
        height: 700px;
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
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .date {
        display: flex;
        flex-direction: row;
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

    .blurred {
        filter: blur(2px);
        overflow: hidden;
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

    input[type="date"]::before {
        content: attr(data-placeholder);
        width: 100%;
    }

    input[type="date"]:focus::before,
    input[type="date"]:valid::before {
        display: none
    }

    .still {
        overflow: hidden;
    }

    ::placeholder {
        color: black;
        opacity: 1;
    }

    textarea {
        min-height: 200px;
        padding: 12px 20px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #f8f8f8;
        font-size: 16px;
        resize: none;
    }

    .card-container {
        width: 80%;
    }

    @media screen and (max-width:800px) {
        .card-container {
            height: fit-content;
            width: 80%;
        }

        .form {
            width: 80%;

        }

        .show-form {
            height: 800px;
            transition: height, 0.3s linear;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        #map {
            width: 300px;
            height: 300px;
        }

        .event-card-details {
            flex-direction: column;
        }

    }
</style>


<body>
    <div id="background">
        <?php if ($organization || $moderator) { ?>
            <div class="flex-col flex-center margin-side-lg">
                <button class="btn btn-solid btn-close margin-lg" onclick="togglePopup('form'); blur_background('background'); stillBackground('id1')">Add Announcement &nbsp; <i class="fas fa-plus"></i></button>
            </div>
        <?php } ?>
        <div class="flex-col flex-center">
            <?php foreach ($announcements as $announcement) { ?>
                <div class="card-container margin-md">
                    <div class="event-card-details">
                        <h3 class="margin-md"><?= $announcement["title"] ?></h3>
                        <date class="margin-md"><?= $announcement["date"] ?></date>
                        <description class="margin-md"><?= $announcement["announcement"] ?></description>

                        <update class="margin-md">
                            <button class="btn margin-side-md" onclick="edit(); editForm('<?= $announcement['title'] ?>','<?= $announcement['announcement'] ?>','<?= $announcement['announcement_id'] ?>'); togglePopup('edit-form'); blur_background('background'); stillBackground('id1')"><i class="btn-icon far fa-edit margin-side-md"></i>&nbsp;Edit</button>
                            <button class="btn clr-red border-red " onclick="remove()"><i class="far fa-trash-alt margin-side-md"></i>&nbsp;Remove</button>
                            <div class="flex-row flex-space" style="display: none;">
                                <p class="margin-side-md" style="white-space: nowrap;">Are you sure</p>
                                <form method="post" action="/event/deleteAnnouncement?event_id=<?= $_GET["event_id"] ?>" class="flex-row flex-center">
                                    <input name="announcement_id" class="hidden" value="<?= $announcement["announcement_id"] ?>">
                                    <button class="btn-icon flex-row flex-center"><i type="submit" class="fas fa-check clr-green margin-side-md"></i>&nbsp;</button>
                                </form>
                                <i class="btn-icon fas fa-times clr-red margin-side-md" onclick="cancel()"></i>
                            </div>
                        </update>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php if ($organization || $moderator) { ?>
        <div class="popup" id="form">
            <div class="content">
                <form action="/event/addAnnouncement?event_id=<?= $_GET["event_id"] ?>" method="post" class="form-container">
                    <div>
                        <h3 class="margin-md">New Announcement</h3>
                    </div>

                    <div class="form-item">
                        <label>Title</label>
                        <input type="text" class="form-ctrl" placeholder="Enter Title" name="title" required>
                    </div>

                    <div class="form-item">
                        <label>Announcement</label>
                        <textarea name="announcement" class="form-ctrl" placeholder="Enter announcement" required></textarea>
                    </div>

                    <button class="btn btn-solid margin-md" type="submit">Post</button>

                    <div>
                        <button class="btn-icon btn-close" onclick="togglePopup('form'); blur_background('background'); stillBackground('id1')"><i class="fas fa-times"></i></button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ($organization || $moderator) { ?>
        <div class="popup" id="edit-form">
            <div class="content">
                <form action="/event/editAnnouncement?event_id=<?= $_GET["event_id"] ?>" method="post" class="form-container">

                    <div class="form-item">
                        <label>Title</label>
                        <input type="text" class="form-ctrl" placeholder="Enter Title" name="title" id="edit-title" required>
                    </div>

                    <div class="form-item">
                        <label>Announcement</label>
                        <textarea name="announcement" class="form-ctrl" placeholder="Enter announcement" id="edit-announcement" required></textarea>
                    </div>

                    <button name="announcement_id" class="btn btn-solid margin-md" type="submit" id="edit-announcement-id">Save</button>

                    <div>
                        <button class="btn-icon btn-close" onclick="togglePopup('edit-form'); blur_background('background'); stillBackground('id1')"><i class="fas fa-times"></i></button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</body>

<script>
    function togglePopup(id) {
        document.getElementById(id).classList.toggle("active");
    }

    function blur_background(id) {
        document.getElementById(id).classList.toggle("blurred")
    }

    function stillBackground(id) {
        document.getElementById(id).classList.toggle("still");
    }

    function add() {
        document.querySelector(".form").classList.toggle("show-form");
    }

    function edit() {
        var data = document.getElementsByClassName("data");
        var form = document.getElementsByClassName("form");
        for (var i = 0; i < data.length; i++) {
            data[i].classList.toggle("hidden");
        }
        for (var i = 0; i < form.length; i++) {
            form[i].classList.toggle("hidden");
        }
    }

    function editForm(title, announcement, announcement_id) {
        document.getElementById("edit-title").value = title;
        document.getElementById("edit-announcement").value = announcement;
        document.getElementById("edit-announcement-id").value = announcement_id;
    }

    //check about the 'onclick' on text and the icon of the button
    function remove() {
        event.target.style.display = "none";
        event.target.nextElementSibling.style.display = "flex";
    }

    function cancel() {
        var cancel = event.target.parentNode;
        cancel.style.display = "none";
        cancel.previousElementSibling.style.display = "block";

    }
</script>

</html>