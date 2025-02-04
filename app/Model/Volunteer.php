<?php

class Volunteer extends Model
{
    public function getVolunteerDetails($event_id, $offset=0, $no_of_records_per_page=0, $volunteer_date = -1)
    { //get volunteer details from backend to UI
        if($offset==0 && $no_of_records_per_page==0 && $volunteer_date == -1){
            $query = "SELECT registered_user.uid,registered_user.username, registered_user.contact_number, registered_user.email, volunteer.participated,  date_format(volunteer.date,'%x-%m-%d') as date, volunteer.volunteer_date FROM volunteer LEFT JOIN registered_user ON volunteer.uid=registered_user.uid WHERE event_id =:event_id ORDER BY date";
            $params = ["event_id" => $event_id];
        }
        else if ($volunteer_date != -1) {
            $query = "SELECT registered_user.uid ,registered_user.username, registered_user.contact_number, registered_user.email, volunteer.participated,  date_format(volunteer.date,'%x-%m-%d') as date, volunteer.volunteer_date FROM volunteer LEFT JOIN registered_user ON volunteer.uid=registered_user.uid WHERE event_id =:event_id AND volunteer_date = :volunteer_date ORDER BY date";
            $params = ["event_id" => $event_id, "volunteer_date"=> $volunteer_date];
        } 
        else {
            $query = "SELECT registered_user.uid,registered_user.username, registered_user.contact_number, registered_user.email, volunteer.participated,  date_format(volunteer.date,'%x-%m-%d') as date, volunteer.volunteer_date FROM volunteer LEFT JOIN registered_user ON volunteer.uid=registered_user.uid WHERE event_id =:event_id ORDER BY date LIMIT :offset , :no_of_records_per_page";
            $params = ["event_id" => $event_id, "offset" => $offset, "no_of_records_per_page" => $no_of_records_per_page];
        }

        $result = Model::select($query, $params);
        return $result;
    }

    public function disableVolunteer($event_id)
    { //disable volunteers for an event
        $query = 'UPDATE event SET volunteer_status=0 WHERE event_id =:event_id';
        $params = ["event_id" => $event_id];
        Model::insert($query, $params);
    }

    public function enableVolunteer($event_id)
    { //enable volunteers for an event
        $query = 'UPDATE event SET volunteer_status=1 WHERE event_id =:event_id';
        $params = ["event_id" => $event_id];
        Model::insert($query, $params);
    }

    public function updateVolunteerCapacity($event_id, $capacities)
    { //give a volunteer capacity for an event from the UI to store in backend

        $query = 'SELECT event_date FROM volunteer_capacity WHERE event_id = :event_id';
        $params = ["event_id" => $event_id];
        $result = Model::select($query, $params);

        for ($i = 0; $i < count($result); $i++) {
            $update_query = 'UPDATE volunteer_capacity SET capacity = :capacity WHERE event_id =:event_id AND event_date = :event_date';
            $update_params = ["capacity" => (int)$capacities[$i], "event_id" => $event_id, "event_date" => $result[$i]['event_date']];
            Model::insert($update_query, $update_params);
        }
    }

    public function removeVolunteerCapacity($event_id, $start_date, $end_date)
    {
        $query = 'DELETE FROM volunteer_capacity WHERE event_id = :event_id AND event_date  NOT BETWEEN :start_date AND :end_date';
        $params = ["event_id" => $event_id, "start_date" => $start_date, "end_date" => $end_date];
        Model::insert($query, $params);
    }

    public function removeVolunteers($event_id)
    {
 
        $query = 'DELETE FROM volunteer WHERE event_id = :event_id';
        $params = ["event_id" => $event_id];
        Model::insert($query,$params);

    }

    public function removeVolunteersOutofRange($event_id,$uid,$start_date,$end_date){

        $delete_query = "DELETE FROM  volunteer WHERE uid = :uid AND event_id = :event_id AND  (volunteer_date NOT BETWEEN  :start_date AND :end_date)";
        $delete_params = ['uid' => $uid, 'event_id' => $event_id , "start_date" => $start_date, "end_date" => $end_date];
        Model::insert($delete_query,$delete_params);

    }

    public function getVolunteerCapacities($event_id)
    {
        $query = 'SELECT event_date,capacity FROM volunteer_capacity WHERE event_id = :event_id';
        $params = ["event_id" => $event_id];
        $result = Model::select($query, $params);
        return $result;
    }

    public function getVolunteeredDates($uid,$event_id)
    {
        $params = ["uid" => $uid, "event_id" => $event_id];
        $query = 'SELECT volunteer_date FROM volunteer WHERE uid = :uid AND event_id = :event_id';
        $result = Model::select($query, $params);
        return $result;
    }

    public function checkVolunteerCount($event_id, $start_date, $end_date)
    {
        $startDate = new DateTime($start_date);
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($end_date);
        $realEnd->add($interval);
        $period = new DatePeriod($startDate, $interval, $realEnd);
        $capacity_exceeded = [];

        foreach ($period as $date) {
            $event_day = $date->format('Y-m-d');
            $query = 'SELECT DISTINCT uid from volunteer WHERE event_id = :event_id AND volunteer_date = :event_date';
            $params = ["event_id" => $event_id, "event_date" => $event_day];
            $volunteer_count = count(Model::select($query, $params));

            $query_capacity = 'SELECT capacity FROM volunteer_capacity WHERE event_id = :event_id AND event_date = :event_date';
            $params = ["event_id" => $event_id, "event_date" => $event_day];
            $capacity = Model::select($query_capacity, $params);

            if ($volunteer_count == $capacity[0]['capacity']) {
                $capacity_exceeded[$event_day] = true;
            } else {
                $capacity_exceeded[$event_day] = false;
            }
        }

        return $capacity_exceeded;
    }

    public function getVolunteerSum($event_id)
    {
        $volunteer_sum = [];

        $query = 'SELECT event_date FROM volunteer_capacity WHERE event_id = :event_id';
        $params = ["event_id" => $event_id];
        $result = Model::select($query, $params);

        for ($i = 0; $i < count($result); $i++) {

            $params_volunteer = ["event_id" => $event_id, "volunteer_date" => $result[$i]["event_date"]];
            $query_volunteer = 'SELECT count(uid) AS volunteer_sum FROM volunteer WHERE event_id = :event_id AND volunteer_date = :volunteer_date GROUP BY volunteer_date ';
            $volunteer_sum[$result[$i]["event_date"]] = Model::select($query_volunteer, $params_volunteer);
        }

        return $volunteer_sum;
    }


    public function addVolunteerDetails($uid,$event_id, $volunteer_dates = NULL)
    {

        $event_details = (new Events)->getDetails($event_id);


        if ($volunteer_dates == NULL) {
            $delete_query = "DELETE FROM  volunteer WHERE uid = :uid AND event_id = :event_id";
            $delete_params = ['uid' => $uid , 'event_id' => $event_id];
            Model::insert($delete_query, $delete_params);
            return "You unvolunteered from {$event_details['event_name']}";
        } 
        else {
           
            $delete_query = "DELETE FROM  volunteer WHERE uid = :uid AND event_id = :event_id";
            $delete_params = ['uid' => $uid, 'event_id' => $event_id];
            Model::insert($delete_query, $delete_params);

            foreach ($volunteer_dates as $volunteer_date) {
                $query = 'INSERT INTO `volunteer`(`uid`,`event_id`,`volunteer_date`) VALUES (:uid,:event_id,:volunteer_date)';
                $params = ['uid' => $uid, 'event_id' => $event_id, 'volunteer_date' => $volunteer_date];
                Model::insert($query, $params);
            }

            return "You volunteered for {$event_details['event_name']}";           
        }
    }

    //complete this
    public function markParticipation($event_id)
    {
        $time = (int)shell_exec("date '+%s'");
        $date = date("Y-m-d", $time);
        $query = "INSERT INTO volunteer (uid,volunteer_date,event_id,participated) VALUES (:uid,:volunteer_date,:event_id,1) ON DUPLICATE KEY UPDATE participated=1";
        $params = ["uid" => $_SESSION["user"]["uid"], "event_id" => $event_id, "volunteer_date" => $date];
        Model::insert($query, $params);
    }

    public function getVolunteeredUid($event_id)
    {
        $params = ["event_id" => $event_id];
        $query = 'SELECT DISTINCT uid FROM volunteer WHERE event_id = :event_id';         
        $result = Model::select($query, $params);
        return $result;
    }
 
    public function getvolunteereduidOutofRange($event_id, $start_date, $end_date){

        $params = ["event_id" => $event_id, "start_date" => $start_date, "end_date" => $end_date];
        $query = 'SELECT DISTINCT uid FROM volunteer WHERE event_id = :event_id AND volunteer_date  NOT BETWEEN :start_date AND :end_date ';
        $result = Model::select($query, $params);
        return $result;
    }



    public function getReport($data)
    {
        $query = "SELECT COUNT(event_id) as volunteer_sum ,date_format(date,'%x-%m-%d') as day FROM volunteer WHERE event_id = :event_id GROUP BY day ORDER BY day ASC";
        $params = ["event_id" => $data["event_id"]];
        $result = Model::select($query, $params);

        if (count($result) == 0)
            return false;
        else
            return $result;
    }

    public function getDailyVolunteerCount($event_id){
        $query= "SELECT COUNT(uid) as daily_volunteers, date_format(volunteer_date,'%Y-%m-%d') as day FROM volunteer WHERE event_id = :event_id GROUP BY day ORDER BY day ASC";
        $params = ["event_id" => $event_id];
        $result = Model::select($query, $params);
        if (count($result) == 0)
            return [];
        else
            return $result;
    }

    public function getParticipantCount($event_id){
        $query= "SELECT COUNT(uid) as participants, date_format(volunteer_date,'%Y-%m-%d') as day FROM volunteer WHERE participated = 1 AND event_id = :event_id GROUP BY day ORDER BY day ASC";
        $params = ["event_id" => $event_id];
        $result = Model::select($query, $params);
        if (count($result) == 0)
            return [];
        else
            return $result;
    }

    public function getEventVolunteerDates($event_id){
        $event  = (new Events)->getDetails($event_id);
        $startDate = new DateTime($event["start_date"]);
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($event["end_date"]);
        $realEnd->add(new DateInterval('P1D'));
        $period = new DatePeriod($startDate, $interval, $realEnd);
        $dates=[];
        foreach($period as $date){
            $event_day = $date->format('Y-m-d');
            array_push($dates, $event_day);
        }
        return $dates;
    }


}
