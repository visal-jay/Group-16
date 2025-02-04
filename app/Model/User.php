<?php

class User extends Model
{
    public function checkUserEmail($email)
    {
        $query = 'SELECT COUNT(*) as count FROM login where email = :email ';
        $params = ["email" => $email];
        if ((User::select($query, $params))[0]["count"] == 1)
            return true;
        else
            return false;
    }

    public function authenticate($email,$password,$verified=1)
    {
        $query = 'SELECT uid,user_type,password,COUNT(*) as count FROM login where email = :email AND verified= :verified';
        $params = ["email" => $email,"verified"=>$verified];
        $result=User::select($query,$params);

        if ($result[0]["count"]== 1 && password_verify($password,$result[0]["password"]))
            return $result[0];
        else
            return false;
    }

    public function authenticateWithMails($email,$password,$verified=1,$reset_password=0)
    {
        if ($reset_password==1){
            $query = 'SELECT uid,user_type,password,COUNT(*) as count FROM login where email = :email AND password =:password AND verified= :verified AND reset_password = :reset_password';
            $params = ["email" => $email,"verified"=>$verified,"password"=>$password,"reset_password"=>$reset_password];
        }
        else{
            $query = 'SELECT uid,user_type,COUNT(*) as count FROM login where email = :email AND password =:password AND verified= :verified';
            $params = ["email" => $email,"password"=>$password,"verified"=>$verified];
        }
        $result=User::select($query,$params);
        if ($result[0]["count"]== 1)
            return $result[0];
        else
            return false;
    }

    public function getUsername($uid){
        if($result=(new Organisation)->getDetails($uid))
            return $result["username"];
        if($result=(new RegisteredUser)->getDetails($uid))
            return $result["username"];
        if($result=(new Admin)->getDetails($uid))
            return $result["username"];
    }
    
    public function getForgotPasswordKey ($email){
        $encryption= new Encryption;
        $query = 'SELECT email,password FROM login where email = :email AND verified= 1';
        $params = ["email" => $email];
        $result=User::select($query,$params);

        $query = 'UPDATE login SET reset_password=1 WHERE email = :email AND verified= 1';
        User::insert($query,$params);

        $time= (int)shell_exec("date '+%s'");
        return $encryption->encrypt(array_merge($result[0],["time"=>$time]),'reset password');
    }

    function setVerification($uid){
        $query = 'UPDATE login SET verified=1  WHERE uid = :uid';
        $params = ["uid" => $uid];
        User::insert($query,$params);
    }

    function getFailedLogin($email){
        $query = 'SELECT UNIX_TIMESTAMP(first_failed_login) as first_failed_login, failed_login_count FROM login WHERE email= :email AND verified = :verified LIMIT 1';
        $params = ["email" => $email,"verified"=>1];
        $result=User::select($query,$params);
        if (count($result)>= 1)
            return $result[0];
        else
            return false;
    }

    function updateFailedLogin($email,$failed_login_count,$first_failed_login){
        $first_failed_login=date('Y/m/d H:i:s', $first_failed_login);
        $query = 'UPDATE login SET failed_login_count= :failed_login_count ,first_failed_login= :first_failed_login  WHERE email = :email';
        $params = ["email" => $email,"first_failed_login"=>$first_failed_login,"failed_login_count"=>$failed_login_count];
        User::insert($query,$params);
    }

    
    function checkLoginAcess($email){
        $bad_login_limit = 5;
        $lockout_time = 600;
        $query = 'SELECT UNIX_TIMESTAMP(first_failed_login) as first_failed_login, failed_login_count FROM login WHERE email= :email AND verified = :verified LIMIT 1';
        $params = ["email" => $email,"verified"=>1];
        $result=User::select($query,$params);
        if (count($result)>= 1){
            extract($result[0], EXTR_OVERWRITE);
           $time= (int) shell_exec("date '+%s' ");
            if (($failed_login_count >= $bad_login_limit) && ($time - $first_failed_login < $lockout_time))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    function resetPassword($email,$password){
        $query = 'UPDATE login SET password= :password,reset_password=0 WHERE email = :email';
        $params = ["email" => $email,"password"=>password_hash($password,PASSWORD_DEFAULT)];
        User::insert($query,$params);
    }
    
    function insertActivity($activity,$event_id){

        if($event_id==-1){
            $query =  "INSERT INTO `activity_log` (`event_id`, `uid`,`time_stamp`, `activity`) VALUES (NULL, :uid,  CURRENT_TIMESTAMP,:activity)"; 
            $params = ['uid'=>$_SESSION['user']['uid'],'activity'=>$activity];
        }
        else{
            $query =  "INSERT INTO `activity_log` (`event_id`, `uid`,`time_stamp`, `activity`) VALUES (:event_id, :uid,  CURRENT_TIMESTAMP,:activity)"; 
            $params =['event_id'=>$event_id,'uid'=>$_SESSION['user']['uid'],'activity'=>$activity];
        }
        User::insert($query,$params);
    }

    function getActivity($data){

        $params = $data;
        $query = 'SELECT event_details.event_name,event_details.event_id,activity_log.activity,activity_log.time_stamp FROM activity_log LEFT JOIN event_details ON activity_log.event_id = event_details.event_id WHERE  activity_log.uid = :uid ORDER BY time_stamp DESC LIMIT :offset , :no_of_records_per_page';
        $activities = User::select( $query,$params) ? User::select( $query,$params) : NULL;
         return $activities;  
    }

    function deleteActivity($time_stamp){

        $params = ["uid" => $_SESSION['user']['uid'], "time_stamp" => $time_stamp];
        $query = 'DELETE FROM activity_log WHERE uid =:uid AND time_stamp = :time_stamp';
        User::insert($query,$params);

    }
    
    function insertNotification($notification,$uid,$status, $path,$event_id){
        if($event_id == -1){
            $params = ["uid" => $uid, "notification" => $notification ,"status" => $status,"path" => $path];
            $query = 'INSERT INTO `notification`(`uid`,`event_id`,`time_stamp`,`description`,`status`,`path`) VALUES (:uid,NULL,CURRENT_TIMESTAMP,:notification,:status,:path)'; 
        }
        else{
            $params = ["uid" => $uid, "event_id" => $event_id, "notification" => $notification ,"status" => $status, "path" => $path];
            $query = 'INSERT INTO `notification` (`uid`,`event_id`,`time_stamp`,`description`,`status`,`path`) VALUES (:uid,:event_id,CURRENT_TIMESTAMP,:notification, :status,:path)'; 
        }
        User::insert($query,$params);
    }

    function getNotifications(){
        $notifications = [];
        $params = ["uid" => $_SESSION["user"]["uid"] ];
        $query = 'SELECT reg.profile_pic AS reguser_profile_pic,org.profile_pic AS org_profile_pic,event_details.organisation_username,event_details.cover_photo AS event_cover_pic,event_details.event_name,notification.event_id AS event_id,notification.description AS description ,notification.time_stamp AS time_stamp,notification.viewed AS viewed,notification.status AS status,notification.path AS path FROM notification JOIN event_details ON notification.event_id = event_details.event_id RIGHT JOIN registered_user reg ON notification.uid  =reg.uid  RIGHT JOIN organization org ON event_details.org_uid = org.uid  WHERE  notification.uid = :uid ORDER BY time_stamp DESC';
        $notifications = User::select($query,$params);
        return  $notifications;
    }
    function setNotificationViewed(){
        $params = ["uid" => $_SESSION['user']['uid']];
        $query = 'UPDATE notification SET viewed = 1 WHERE uid = :uid';
        User::insert($query,$params);
    }
    function getNotificationsViewed(){
        $not_viewed = false;
        $params = ["uid" => $_SESSION['user']['uid']];
        $query = 'SELECT viewed FROM notification WHERE uid = :uid';
        $result = User::select($query,$params);
        for($i=0;$i < count($result);$i++){
            if($result[$i]['viewed'] == 0){
                $not_viewed = true;
                break;
            }
            
        }
        return $not_viewed;
    }

    function checkCurrentPassword($uid, $password)
    {
        $query = 'SELECT password FROM login WHERE uid = :uid AND verified=1';
        $params = ["uid" => $uid];
        $result = USER::select($query, $params);
        if (password_verify($password,$result[0]['password'])) {
            return true;
        } else {
            return false;
        }
    }
    
    function  removeUser($uid){
        $query = 'DELETE FROM login WHERE uid = :uid';
        $params = ["uid" => $uid];
        User::insert($query,$params);
    }

    function getDetails($uid){
        if($result=(new Organisation)->getDetails($uid))
            return $result;
        if($result=(new RegisteredUser)->getDetails($uid))
            return $result;
        if($result=(new Admin)->getDetails($uid))
            return $result;
    }



}
