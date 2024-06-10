<?php

//SYSTEM
//My 1st Function - Clean the Input Data Before Saving into the Database
function cleanInput($input = null)
{
    if ($input === null) return "";
    return htmlspecialchars(stripslashes(trim($input)));
}

//My 2nd Function - Create the Connection with the Database
function dbConn()
{
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "flash_reception_hall";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Connection Error" . $conn->connect_error);
    } else {
        return $conn;
    }
}

//My 3rd Function - Upload the Files into the Database
//    function uploadFiles($file,$new_file_name,$destination){
//        $message = array();
//        $result = array();
//        $file = $_FILES[$file];
//        
//        //Get file propeties
//        $file_name = $file['name'];
//        $tempname = $file['tmp_name'];
//        $size = $file['size'];
//        $error = $file['error'];
//        
//        //Get the file extention
//        $fileext = explode(".", $file_name);
//        $fileext = strtolower(end($fileext));
//        
//        //Define allowed file types to be upload
//        $allowedext = array('png', 'jpg', 'jpeg');
//        
//        //Check if the file type is allowed
//        if (in_array($fileext, $allowedext)) {
//            if ($error === 0) {
//                if ($size <= 2097152) {
//                    //Rename the uploaded file with unique name
//                    $cDate = date("Y-m-d");
//                    $file_name_new = $new_file_name.".".$fileext;
//                    $result['file_name'] = $file_name_new;
//
//                    //Create the destination for the uploaded files
//                    $file_destination = $destination.$file_name_new;
//
//                    if (move_uploaded_file($tempname, $file_destination)) {
//                        echo 'The file uploaded successfully';
//                    } else {
//                        $message['error_file'] = "There is an error uploading the file...";
//                    }
//                } else {
//                    $message['error_file'] = "File Size is Invalid...";
//                }
//            } else {
//                $message['error_file'] = "There was a error in the file...";
//            }
//        } else {
//            $message['error_file'] = "This File Type is Not Allowed...";
//        }
//        if(!empty($message)){
//            $result["error_message"] = $message['error_file'];
//        }
//        
//        return $result;
//    }
function uploadFiles($file, $new_file_name, $destination)
{
    //        $message = '';
    $result = array();
    $file = $_FILES[$file];

    //Get file propeties
    $file_name = $file['name'];
    $tempname = $file['tmp_name'];
    $size = $file['size'];
    $error = $file['error'];

    //Get the file extention
    $fileext = explode(".", $file_name);
    $fileext = strtolower(end($fileext));

    //Define allowed file types to be upload
    $allowedext = array('png', 'jpg', 'jpeg');

    //Check if the file type is allowed
    if (in_array($fileext, $allowedext)) {
        if ($error === 0) {
            if ($size <= 2097152) {
                //Rename the uploaded file with unique name
                $cDate = date("Y-m-d");
                $file_name_new = $new_file_name . "." . $fileext;
                $result['file_name'] = $file_name_new;

                //Create the destination for the uploaded files
                $file_destination = $destination . $file_name_new;

                if (move_uploaded_file($tempname, $file_destination)) {
                    echo 'The file uploaded successfully';
                } else {
                    $message = "There is an error uploading the file...";
                }
            } else {
                $message = "File Size is Invalid...";
            }
        } else {
            $message = "There was a error in the file...";
        }
    } else {
        $message = "This File Type is Not Allowed...";
    }
    if (!empty($message)) {
        $result["error_message"] = $message;
    }

    return $result;
}

//My 4th Function - Validate the Password
function validatePassword($password)
{
    $uppercase_letter = preg_match('@[A-Z]@', $password);
    $lowercase_letter = preg_match('@[a-z]@', $password);
    $numeric_value = preg_match('@[0-9]@', $password);
    $special_characters = preg_match('@[^\w]@', $password);

    if (!$uppercase_letter || !$lowercase_letter || !$numeric_value || !$special_characters) {
        return "Password should include at least one capital letter, a simple letter, a number and a special character";
    } else if (strlen($password) < 8) {
        return "Password should be at least 8 characters";
    } else if (strpos($password, " ")) {
        return "Password Should not Contain Spaces";
    }
    return "";
}

//My 5th Function - Validate the Text Fields
function validateTextFields($value)
{
    if (!preg_match('/^[A-Za-z\s]+$/', $value)) {
        return TRUE;
    }
}

//My 6th Function - Validate the Contact Numbers
function validateContactNumber($contact_number)
{
    $message;
    if (!preg_match('/^[0][0-9]{9}$/', $contact_number)) {
        return TRUE;
    }
}

//My 7th Function - Validate Email
function validateEmail($email)
{
    $message;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return TRUE;
    }
}

//My 8th Function - Validate the Pattern of NIC 
function validateNICPattern($nic)
{
    $oldnic_pattern = "/^[0-9]{9}V$/";
    $newnic_pattern = "/^[0-9]{12}$/";

    if (preg_match($oldnic_pattern, $nic) || preg_match($newnic_pattern, $nic)) {
        return TRUE;
    }
}

//My 9th Function - Validate the Gender
function getGender($nic, $gender)
{
    $oldnic_pattern = "/^[0-9]{9}V$/";
    $newnic_pattern = "/^[0-9]{12}$/";

    if (preg_match($oldnic_pattern, $nic)) {
        $days = intval(substr($nic, 2, 3));
    } else if (preg_match($newnic_pattern, $nic)) {
        $days = intval(substr($nic, 4, 3));
    }
    if ($days < 500) {
        $gen = 'Male';
    } else {
        $gen = 'Female';
    }

    if ($gender != $gen) {
        return TRUE;
    }
}

//My 10th Function - Validate the Birth Date
function getBirthDate($nic, $dob)
{
    date_default_timezone_set('Asia/Colombo');
    $oldnic_pattern = "/^[0-9]{9}V$/";
    $newnic_pattern = "/^[0-9]{12}$/";
    $days = 0;
    $birthyear = 0;
    if (preg_match($oldnic_pattern, $nic)) {
        $birthyear = 1900 + intval(substr($nic, 0, 2));
        $days = intval(substr($nic, 2, 3));
    } else if (preg_match($newnic_pattern, $nic)) {
        $birthyear = intval(substr($nic, 0, 4));
        $days = intval(substr($nic, 4, 3));
    }
    if ($days >= 500) {
        $days -= 500;
    }
    //$days--;
    $birthdate = date_create_from_format('Yz', $birthyear . $days);
    if($days >= 500){
        $birthdate->modify('-2 days');
    }else{
        $birthdate->modify('-1 days');
    }
    //var_dump($birthdate);
    $birthdate = $birthdate->format('Y-m-d');
    var_dump($birthdate);
    if ($birthdate == $dob) {
        return TRUE;
    }
}

//My 11th Function
function getUpdatedFields($old_values, $new_values)
{
    $updated_fields = array();
    foreach ($old_values as $exfield => $exvalue) {
        foreach ($new_values as $upfield => $upvalue) {
            if ($exfield == $upfield && $exvalue != $upvalue) {
                $updated_fields[] = $exfield;
                break;
            }
        }
    }
    return $updated_fields;
}

//My 12th Function
function generatePassword()
{
    $length = 8;
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@!#";
    $password = substr(str_shuffle($characters), 0, $length);

    return $password;
}

//My 13th Function
function generateUsername()
{
    $length = 8;
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $username = substr(str_shuffle($characters), 0, $length);

    return $username;
}

function hasRole($role_id)
{
    return $_SESSION['user_role_id'] == $role_id;
}

function hasAnyRole($role_ids)
{
    foreach ($role_ids as $role_id) {
        if (hasRole($role_id)) {
            return true;
        }
    }
    return FALSE;
}

function paginate($page, $pageSize)
{
    if ($page === null) {
        $page = 1;
    }
    $startIndex = ($page - 1) * $pageSize;

    return " LIMIT $startIndex, $pageSize";
}

function getNumRows($sqlStartWithFrom)
{
    $sql = "SELECT count(*) as c $sqlStartWithFrom";
    $db = dbConn();
    $result = $db->query($sql);
    if ($result->num_rows == 0) {
        $db->close();
        return 0;
    }
    $count =  $result->fetch_assoc()['c'];
    $db->close();
    return $count;
}
