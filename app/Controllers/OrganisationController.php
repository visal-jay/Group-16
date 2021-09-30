<?php
//use Defuse\Crypto\File;

class OrganisationController
{
    public function view($org_id = '')
    {
        $user_roles=Controller::accessCheck(["organization","registered_user","guest_user"]);
        $org_id = isset($_GET["org_id"]) ? $_GET["org_id"] : $org_id;
        $data = (new Organisation)->getDetails($org_id);
        View::render("organisationDashboard", $data,$user_roles);
    }

    public function dashboard()
    {
        $this->view($_SESSION["user"]["uid"]);
    }

    public function addPhoto()
    {
        (new UserController)->addActivity("Add photo to gallery");
        (new Gallery)->addPhoto([], true);
        echo json_encode("");
        //Controller::redirect("/Organisation/gallery");
    }


    public function gallery()
    {
        if(isset($_GET["org_id"])){
            $user_roles=Controller::accessCheck(["registered_user","guest_user"]);
            $org_id=$_GET["org_id"];
            }        
        else{
                $user_roles=Controller::accessCheck(["organization"]);
                $org_id = $_SESSION["user"]["uid"];
            }

        if (!$data = (new Gallery)->getGallery(["uid" => $org_id], true))
            $data = array();

        View::render("organisationGallery", array_merge(["photos" => $data]),$user_roles);
    }

    public function deletePhoto()
    {
        (new UserController)->addActivity("Delete photo from gallery");
        (new Gallery)->deletePhoto(["image" => $_POST["photo"]], true);
        Controller::redirect("/Organisation/gallery");
    }

    public function update()
    {
        Controller::validateForm(["about_us", "longitude","latitude"]);
        Controller::accessCheck(["organization"]);
        (new UserController)->addActivity("Dahsboard details updated");
        (new Organisation)->updateDetails($_SESSION["user"]["uid"], $_POST);
        Controller::redirect("/Organisation/dashboard");
    }

    public function events()
    {
        if(isset($_GET["org_id"]))
            $user_roles=Controller::accessCheck(["registered_user","guest_user"]);
        else
            $user_roles=Controller::accessCheck(["organization","registered_user","guest_user"]);

        $org_id = isset($_GET["org_id"]) ? $_GET["org_id"] : $_SESSION["user"]["uid"];

        $events = new Events;
        $data["events"] = array();
        if ($result = $events->query(["org_uid" => $org_id, "status" => "published"]))
            foreach ($result as $event)
                array_push($data["events"], $event);
        if ($result = $events->query(["org_uid" => $org_id, "status" => "added"]))
            foreach ($result as $event)
                array_push($data["events"], $event);

        usort($data["events"], function ($a, $b) {
            return $a['event_id'] <=> $b['event_id'];
        });

        View::render("manageEvents", $data,$user_roles);
    }


    public function report()
    {
        $user_roles=Controller::accessCheck(["organization"]);
        $organisation = new Organisation;
        $data["donation"]= $organisation->donationReport();
        $data["donation_percent"]=$organisation->donationPercentageReport();
        $data["volunteer"]= $organisation->volunteerReport();
        $data["volunteer_percent"]=$organisation->volunteerPercentageReport();
        View::render("report",$data,$user_roles);
    }



    public function profile(){
        $user_roles=Controller::accessCheck(["organization"]);
        $organisation_admin=new Organisation();
        $uid=$_SESSION["user"]["uid"];
        $org_admin_details=$organisation_admin-> getAdminDetails($uid); 
        View::render('organisationProfile',$org_admin_details,$user_roles);
    }

    public function activityLog(){
        $user_roles=Controller::accessCheck(["organization"]);
        View::render('history',[],$user_roles);
    }

    
    public function updateAccountNumber(){
        Controller::validateForm(["bank_name","account_number"]);
        Controller::accessCheck(["organization"]);
        (new UserController)->addActivity("Bank details updated");
        
        $organisation_admin = new Organisation();
        $validate =new Validation();
        $uid=$_SESSION["user"]["uid"];
        $data=["uid"=>$uid,"bank_name"=>$_POST['bank_name'],"account_number"=>$_POST['account_number']];
        if($validate-> bankaccount($_POST['account_number'])){
          $organisation_admin->changeAccountNumber($uid,$data);
          Controller::redirect("/Organisation/profile");
        }
        
    }
    
    function getAvailableUserRoles(){
        echo json_encode((new Organisation)->getAvailableUserRoles($_POST["name"]));
    }

    function addUserRole(){
        Controller::validateForm(["role","uid"],["event_id"]);
        Controller::accessCheck(["organization"]);
        (new UserController)->addActivity("User role added",$_GET["event_id"]);

    
        (new Organisation)->addUserRole($_POST["uid"],$_POST["role"],$_GET["event_id"]);
        Controller::redirect("/Event/view",["page"=>'userroles',"event_id"=>$_GET["event_id"]]);
    }

    function deleteUserRole(){
        Controller::validateForm(["role","uid"],["event_id"]);
        Controller::accessCheck(["organization"]);
        (new UserController)->addActivity("User role deleted",$_GET["event_id"]);

        (new Organisation)->deleteUserRole($_POST["uid"],$_POST["role"],$_GET["event_id"]);
        Controller::redirect("/Event/view",["page"=>'userroles',"event_id"=>$_GET["event_id"]]);
    }

    function test(){
        var_dump($_POST);
        var_dump($_GET);
        var_dump($_FILES);
    }
               
}
