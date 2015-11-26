<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BusinessDB extends mysqli {
    
    // single instance of self shared among all instances
    private static $instance = null;

    // db connection config vars
    private $user = "ChrisAring";
    private $pass = "SurrealLem0n";
    private $dbName = "allvolunteerver1";
    private $dbHost = "localhost";
    
  //This method must be static, and must return an instance of the object if the object does not already exist.
    public static function getInstance() {
    if (!self::$instance instanceof self) {
        self::$instance = new self;
    }
    return self::$instance;
    }

 // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
 // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }
 
    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public function get_business_id_by_name($name) {
        $user = $this->query("SELECT id FROM businesses WHERE name = '"
                . $this->real_escape_string($name) . "'");
        if ($user->num_rows > 0){
            $row = $user->fetch_row();
            return $row[0];
        } else {
            return null;
        }
    }
    
        public function get_user_name_from_email($name) {
        $user = $this->query("SELECT name FROM users WHERE accountEmail = '"
                . $this->real_escape_string($name) . "' OR name = '" . $this->real_escape_string($name) . "'");
        if ($user->num_rows > 0){
            $row = $user->fetch_row();
            return $row[0];
        } else {
            return null;
        }
    }
    
        public function get_business_name_from_email($name) {
        $user = $this->query("SELECT name FROM businesses WHERE accountEmail = '"
                . $this->real_escape_string($name) . "' OR name = '" . $this->real_escape_string($name) . "'");
        if ($user->num_rows > 0){
            $row = $user->fetch_row();
            return $row[0];
        } else {
            return null;
        }
    }

    public function get_businesses_by_business_id($businessID) {
        return $this->query("SELECT id, name, owner_name, address, city, state, postal_code,"
                . " email, area_code, exchange_code, line_number, extension, website, goal,"
                . " work_type, positions_open, compensated_experience, hours_needed, begin_month, end_month,"
                . " other_information FROM businesses WHERE id=" . $this->real_escape_string($businessID));
    }

    public function get_user_id_by_name($user) {
        return $this->query("SELECT id FROM users WHERE name='".$this->real_escape_string($user)."'");   
    }
    
    public function get_user_accountEmail_id_by_name($user) {
        return $this->query("SELECT id FROM users WHERE accountEmail='".$this->real_escape_string($user)."'");   
    }

    public function get_business_accountEmail_id_by_name($user) {
        return $this->query("SELECT id FROM businesses WHERE accountEmail='".$this->real_escape_string($user)."'");   
    }
    
    public function create_user ($name, $password){
        $this->query("INSERT INTO users (name, password) VALUES ('" . $this->real_escape_string($name) . "', '" . $this->real_escape_string($password) . "')");
    }

    public function verify_user_credentials ($name, $password){
        $result = $this->query("SELECT 1 FROM users
                WHERE (name = '" . $this->real_escape_string($name) . "' OR accountEmail = '" . $this->real_escape_string($name) . "') AND password = '" . $this->real_escape_string($password) . "'");
        return $result->data_seek(0);
    }

    public function verify_business_credentials ($business, $password){
        $result = $this->query("SELECT 1 FROM businesses
                WHERE (name = '" . $this->real_escape_string($business) . "' OR accountEmail = '" . $this->real_escape_string($business) ."') AND password = '" . $this->real_escape_string($password) . "'");
    return $result->data_seek(0);
    }

    public function create_business ($business, $password){
        $this->query("INSERT INTO businesses (name, password) VALUES ('" . $this->real_escape_string($business) . "', '" . $this->real_escape_string($password) . "')");
    }
    
    public function get_business_id_by_name_only($business) {
        return $this->query("SELECT id FROM businesses WHERE name='".$this->real_escape_string($business)."'");   
    }

    public function update_business($businessID, $owner, $address, $city, $state, $postal_code, $email, $phoneFull,
        $extension, $website, $goal, $work_type, $positions_open, $compensated_experience, $hours_needed, $begin_month,
        $end_month, $other_information){
        if ($this->format_phone_for_sql($phoneFull)==null){
            $test = $this->query("UPDATE businesses SET owner_name = '" . $this->real_escape_string($owner) .
                "', address = '" . $this->real_escape_string($address) .
                "', city = '" . $this->real_escape_string($city) .
                "', state = '" . $this->real_escape_string($state) .
                "', postal_code = '" . $this->real_escape_string($postal_code) .
                "', email = '" . $this->real_escape_string($email) .
                "', extension = '" . $this->real_escape_string($extension) .
                "', website = '" . $this->real_escape_string($website) .
                "', goal = '" . $this->real_escape_string($goal) .
                "', work_type = '" . $this->real_escape_string($work_type) .
                "', positions_open = '" . $this->real_escape_string($positions_open) .
                "', compensated_experience = '" . $this->real_escape_string($compensated_experience) .
                "', hours_needed = '" . $this->real_escape_string($hours_needed) .
                "', begin_month = '" . $this->real_escape_string($begin_month) .
                "', end_month = '" . $this->real_escape_string($end_month) .
                "', other_information = '" . $this->real_escape_string($other_information) . "' WHERE id = " . $this->real_escape_string($businessID)) or die(mysqli_error($this));
        } else {
            $phoneFull = $this -> format_phone_for_sql($phoneFull);
            $area_code = $phoneFull[0];
            $exchange_code = $phoneFull[1];
            $line_number = $phoneFull[2];
    //$description = $this->real_escape_string($description);
            

            
            $this->query("UPDATE businesses SET owner_name = '" . $owner .
                "', address = '" . $this->real_escape_string($address) .
                "', city = '" . $this->real_escape_string($city) .
                "', state = '" . $this->real_escape_string($state) .
                "', postal_code = '" . $this->real_escape_string($postal_code) .
                "', email = '" . $this->real_escape_string($email) .
                "', area_code = '" . $this->real_escape_string($area_code) .
                "', exchange_code = '" . $this->real_escape_string($exchange_code) .
                "', line_number = '" . $this->real_escape_string($line_number) .
                "', extension = '" . $this->real_escape_string($extension) .
                "', website = '" . $this->real_escape_string($website) .
                "', goal = '" . $this->real_escape_string($goal) .
                "', work_type = '" . $this->real_escape_string($work_type) .
                "', positions_open = '" . $this->real_escape_string($positions_open) .
                "', compensated_experience = '" . $this->real_escape_string($compensated_experience) .
                "', hours_needed = '" . $this->real_escape_string($hours_needed) .
                "', begin_month = '" . $this->real_escape_string($begin_month) .
                "', end_month = '" . $this->real_escape_string($end_month) .
                "', other_information = '" . $this->real_escape_string($other_information) . "' WHERE id = " . $this->real_escape_string($businessID)) or die(mysqli_error($this));
        }
    }
            
    function format_phone_for_sql($phoneFull) {
        if ($phoneFull == "") {
            return null;
        } else {
            $phoneFull = $this->real_escape_string($phoneFull);
            $phoneFull = str_replace(' ', '', $phoneFull);
            $phoneFull = str_replace('-', '', $phoneFull);
            $phoneFull = preg_replace('/[^A-Za-z0-9\-]/', '', $phoneFull); // Removes special chars.
            $area_code = substr($phoneFull, 0, 3);
            $exchange_code = substr($phoneFull, 3, 3);
            $line_number = substr($phoneFull, 6, 10);
            return array($area_code, $exchange_code, $line_number);
        }
    }
    
    function get_all_businesses($city, $state, $postal_code, $work_type, $compensated_experience, $hours_needed) {
return $this->query("SELECT name, owner_name, address, city, state, postal_code,"
                . " email, area_code, exchange_code, line_number, extension, website, goal,"
                . " work_type, positions_open, compensated_experience, hours_needed, begin_month, end_month,"
                . " other_information FROM businesses WHERE city LIKE '".$city."' AND state LIKE '".$state."' AND postal_code LIKE '".$postal_code."' AND work_type LIKE '".$work_type."'"
        . " AND compensated_experience LIKE '".$compensated_experience."' AND positions_open != 0");
    }
}