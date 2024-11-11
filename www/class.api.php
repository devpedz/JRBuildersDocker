<?php

namespace App\Controllers;

class API
{
    function addCategory()
    {
        header('Content-Type: Application/json');
        global $db;
        global $session;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $category_name = $_POST['category_name'];
        $db->query("SELECT * FROM tbl_expense_categories WHERE category_name = ?");
        $db->bind(1, $category_name);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different name.";
        } else {
            $db->query("INSERT INTO tbl_expense_categories(category_name) VALUES (?)");
            $db->bind(1, $category_name);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function getCategory()
    {
        global $db;
        $response = [];

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_expense_categories WHERE id = ?");
        $db->bind(1, $_POST['id']);
        $data = $db->single();
        if ($data) {
            $response['success'] = true;
            $response['category_name'] = $data['category_name'];
        }
        echo json_encode($response);
    }

    function deleteCategory()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $id = $_POST['id'];
        $db->query("DELETE FROM tbl_expense_categories WHERE id = $id");
        $response = [
            'success' => ($db->execute()) ? true : false,
        ];
        echo json_encode($response);
    }
    function updateCategory()
    {
        header('Content-Type: Application/json');
        global $db;
        global $session;
        $project_id = $session->get('project_id');
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $category_name = $_POST['category_name'];
        $category_id = $_POST['category_id'];
        $db->query("SELECT * FROM tbl_expense_categories WHERE category_name = ? AND project_id = ? AND id != ?");
        $db->bind(1, $category_name);
        $db->bind(2, $project_id);
        $db->bind(3, $category_id);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different name.";
        } else {
            $db->query("UPDATE tbl_expense_categories SET category_name = ? WHERE id = ?");
            $db->bind(1, $category_name);
            $db->bind(2, $category_id);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function attendance()
    {
        error_reporting(0);
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $response = [];
        $timeStatus = 'Time-In';
        $full_date = date('Y-m-d H:i:s');
        $date_time = new \DateTime($full_date);
        $date = $date_time->format('Y-m-d');
        $time = $date_time->format('H:i:s');

        $employee_id = $_POST['id'];
        $db->query("SELECT project_id FROM tbl_employee WHERE id = $employee_id");
        $project_id = $db->single()['project_id'];
        $db->query("SELECT * FROM tbl_attendance WHERE employee_id = $employee_id AND `date` = ?");
        $db->bind(1, $date);
        $checkAttendance = $db->single();
        if ($checkAttendance) {
            $db->query("UPDATE tbl_attendance SET `timeOut` = ? WHERE id = ?");
            $db->bind(1, $time);
            $db->bind(2, $checkAttendance['id']);
            $db->execute();
            $timeStatus = 'Time-Out';
        } else {
            $db->query("INSERT INTO tbl_attendance(employee_id,`date`,`year`,weekno,timeIn,project_id) VALUES (?,?,?,?,?,?)");
            $db->bind(1, $employee_id);
            $db->bind(2, $date);
            $db->bind(3, $date_time->format('Y'));
            $db->bind(4, $date_time->format('W'));
            $db->bind(5, $time);
            $db->bind(6, $project_id);
            $db->execute();
        }
        $response['time'] = $date_time->format('h:i A');
        $response['date'] = $date_time->format('F j, Y');
        $response['timeStatus'] = $timeStatus;
        echo json_encode($response);
    }
    function addAttendance()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        global $session;
        $response = [];
        $employee_id = $_POST['employee_id'];
        $project_id = $session->get('project_id');
        $date = $_POST['date'];

        $currentDate = date('Y-m-d', strtotime($date));
        $weekno = date('W', strtotime($date));
        $year = date('Y', strtotime($date));
        $timeIn = $_POST['timeIn'];
        $timeOut = $_POST['timeOut'];
        $db->query("SELECT * FROM tbl_attendance WHERE employee_id = $employee_id AND `date` = ?");
        $db->bind(1, $date);
        $checkAttendance = $db->single();
        if ($checkAttendance) {
            $response['success'] = false;
            $response['message'] = "The employee is already in attendance.";
        } else {
            $db->query("INSERT INTO tbl_attendance(employee_id,`date`,`year`,weekno,timeIn,`timeOut`,project_id) VALUES (?,?,?,?,?,?,?)");
            $db->bind(1, $employee_id);
            $db->bind(2, $currentDate);
            $db->bind(3, $year);
            $db->bind(4, $weekno);
            $db->bind(5, $timeIn);
            $db->bind(6, $timeOut);
            $db->bind(7, $project_id);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function updateAttendance()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        global $session;
        $response = [];
        $attendance_id = $_POST['id'];
        $date = $_POST['date'];
        $currentDate = date('Y-m-d', strtotime($date));
        $weekno = date('W', strtotime($date));
        $year = date('Y', strtotime($date));
        $timeIn = $_POST['timeIn'];
        $timeOut = $_POST['timeOut'];
        $db->query("UPDATE tbl_attendance SET `date` = ?,`year` = ?,weekno = ?,timeIn = ?,`timeOut` = ? WHERE id = ?");
        $db->bind(1, $currentDate);
        $db->bind(2, $year);
        $db->bind(3, $weekno);
        $db->bind(4, $timeIn);
        $db->bind(5, $timeOut);
        $db->bind(6, $attendance_id);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }

    function deleteAttendance()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $id = $_POST['id'];
        $db->query("DELETE FROM tbl_attendance WHERE id = $id");
        $response = [
            'success' => ($db->execute()) ? true : false,
        ];
        echo json_encode($response);
    }
    function getAttendance()
    {
        global $db;
        $response = [];

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM view_attendance WHERE id = ?");
        $db->bind(1, $_POST['id']);
        $data = $db->single();
        if ($data) {
            $response['success'] = true;
            $response['rows'] = $data;
        }
        echo json_encode($response);
    }
    function getUser()
    {
        global $db;
        $response = [];

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_user WHERE id = ?");
        $db->bind(1, $_POST['id']);
        $data = $db->single();
        if ($data) {
            $response['success'] = true;
            $response['rows'] = $data;
        }
        echo json_encode($response);
    }
    function addEmployee()
    {
        global $db;
        global $session;
        $project_id = $session->get('project_id');
        $input = [
            'first_name' => '',
            'middle_name' => '',
            'last_name' => '',
            'suffix' => '',
            'gender' => null,
            'birthday' => null,
            'address' => null,
            'contact_no' => null,
            'position' => null,
            'rate_per_day' => null,
            'status' => null,
            'photo' => null,
            'member_since' => null,
            'project_id' => $project_id
        ];
        foreach ($input as $key => $default) {

            $input[$key] = !empty($_POST[$key]) ? $_POST[$key] : $default;
            if ($key == 'rate_per_day') {
                $amount = str_replace(',', '', $_POST[$key]);
                $rate_per_day = (float) $amount;
                $input[$key] = $rate_per_day;
            }
        }

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_employee WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ? AND birthday = ?");
        $db->bind(1, $input['first_name']);
        $db->bind(2, $input['middle_name']);
        $db->bind(3, $input['last_name']);
        $db->bind(4, $input['suffix']);
        $db->bind(5, $input['birthday']);
        if ($db->single()) {
            echo json_encode(array("success" => false, "message" => 'Employee already exists'));
            exit();
        }
        $columns = implode(',', array_keys($input));
        $values = implode(',', array_fill(0, count($input), '?'));

        $sql = "INSERT INTO tbl_employee($columns) VALUES ($values)";
        $db->query($sql);
        for ($i = 0; $i < count($input); $i++) {
            $index = $i;
            $val = array_values($input)[$index];
            $db->bind($index + 1, $val);
        }
        if ($db->execute()) {
            $lastinsertId = $db->lastinsertid();
            if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == 0) {
                $file_name = $_FILES['imageFile']['name'];
                $file_size = $_FILES['imageFile']['size'];
                $file_tmp = $_FILES['imageFile']['tmp_name'];
                $file_type = $_FILES['imageFile']['type'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                // Specify the directory where the file will be uploaded
                $upload_directory = 'uploads/';

                // Create the uploads directory if it doesn't exist
                if (!is_dir($upload_directory)) {
                    mkdir($upload_directory, 0755, true);
                }
                // Specify the allowed file types
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

                // Check if the file type is allowed
                if (in_array($file_ext, $allowed_types)) {
                    // Move the file to the upload directory
                    $employee_id = $lastinsertId;
                    $employee_id_hash = md5($employee_id);
                    $filename = $employee_id_hash . "." . $file_ext;
                    $db->query("UPDATE tbl_employee SET photo = ? WHERE id = $employee_id");
                    $db->bind(1, $filename);
                    if ($db->execute()) {
                        if (move_uploaded_file($file_tmp, $upload_directory . $filename)) {
                            echo json_encode(array("success" => true, 'redirect' => "/fingerprint-registration/$employee_id"));
                        } else {
                            echo json_encode(array("success" => false, "message" => "Error uploading file."));
                        }
                    }
                } else {
                    echo json_encode(array("success" => false, "message" => "File type not allowed."));
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Error: " . $_FILES['file']['error']));
            }
        }
    }
    function updateEmployee($employee_id)
    {
        global $db;
        global $session;
        $project_id = $session->get('project_id');
        $input = [
            'first_name' => '',
            'middle_name' => '',
            'last_name' => '',
            'suffix' => '',
            'gender' => null,
            'birthday' => null,
            'address' => null,
            'contact_no' => null,
            'position' => null,
            'rate_per_day' => null,
            'status' => null,
            'photo' => null,
            'member_since' => null,
            'project_id' => $project_id,
            'employee_id' => $employee_id
        ];
        foreach ($input as $key => $default) {

            $input[$key] = !empty($_POST[$key]) ? $_POST[$key] : $default;
            if ($key == 'rate_per_day') {
                $amount = str_replace(',', '', $_POST[$key]);
                $rate_per_day = (float) $amount;
                $input[$key] = $rate_per_day;
            }
        }

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_employee WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ? AND birthday = ? AND id != $employee_id");
        $db->bind(1, $input['first_name']);
        $db->bind(2, $input['middle_name']);
        $db->bind(3, $input['last_name']);
        $db->bind(4, $input['suffix']);
        $db->bind(5, $input['birthday']);
        if ($db->single()) {
            echo json_encode(array("success" => false, "message" => 'Employee already exists'));
            exit();
        }
        $columns = implode(',', array_keys($input));
        $values = implode(',', array_fill(0, count($input), '?'));

        $sql = "";

        $db->query("UPDATE tbl_employee SET first_name = ?, middle_name = ?, last_name = ?,suffix = ?,birthday = ?,`address` = ?,position = ?,rate_per_day = ?,`status` = ?, member_since = ?, contact_no = ? WHERE id = ?");
        $db->bind(1, $input['first_name']);
        $db->bind(2, $input['middle_name']);
        $db->bind(3, $input['last_name']);
        $db->bind(4, $input['suffix']);
        $db->bind(5, $input['birthday']);
        $db->bind(6, $input['address']);
        $db->bind(7, $input['position']);
        $db->bind(8, $input['rate_per_day']);
        $db->bind(9, $input['status']);
        $db->bind(10, $input['member_since']);
        $db->bind(11, $input['contact_no']);
        $db->bind(12, $employee_id);
        $db->execute();

        if ($db->execute()) {
            if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == UPLOAD_ERR_OK) {
                $file_name = $_FILES['imageFile']['name'];
                $file_size = $_FILES['imageFile']['size'];
                $file_tmp = $_FILES['imageFile']['tmp_name'];
                $file_type = $_FILES['imageFile']['type'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                // Specify the directory where the file will be uploaded
                $upload_directory = 'uploads/';

                // Create the uploads directory if it doesn't exist
                if (!is_dir($upload_directory)) {
                    mkdir($upload_directory, 0755, true);
                }
                // Specify the allowed file types
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

                // Check if the file type is allowed
                if (in_array($file_ext, $allowed_types)) {
                    // Move the file to the upload directory
                    $employee_id_hash = md5($employee_id);
                    $filename = $employee_id_hash . "." . $file_ext;
                    $db->query("UPDATE tbl_employee SET photo = ? WHERE id = $employee_id");
                    $db->bind(1, $filename);
                    if ($db->execute()) {
                        if (move_uploaded_file($file_tmp, $upload_directory . $filename)) {
                            echo json_encode(array("success" => true, 'redirect' => "/fingerprint-registration/$employee_id"));
                        } else {
                            echo json_encode(array("success" => false, "message" => "Error uploading file."));
                        }
                    }
                } else {
                    echo json_encode(array("success" => false, "message" => "File type not allowed."));
                }
            } else {
                echo json_encode(array("success" => true, 'redirect' => "/fingerprint-registration/$employee_id"));
            }
        }
    }
    function setProject()
    {
        global $session;
        $session->set('project', true);
        $session->set('project_id', $_POST['project']);
        $response = [
            "success" => true,
        ];
        echo "<script>window.location.reload();</script>";
    }

    function getProject()
    {
        global $db;
        $response = [];

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_project WHERE id = ?");
        $db->bind(1, $_POST['id']);
        $data = $db->set();
        if ($data) {
            $response['success'] = true;
            $response['rows'] = $data;
        }
        echo json_encode($response);
    }
    function addProjectEmployee()
    {
        global $db;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $project_id = $_POST['project_id'];
        $employee_id = $_POST['employee_id'];
        $db->query("UPDATE tbl_employee SET project_id = $project_id WHERE id = $employee_id");
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }
    function deleteProjectEmployee()
    {
        global $db;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $employee_id = $_POST['employee_id'];
        $db->query("UPDATE tbl_employee SET project_id = null WHERE id = $employee_id");
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }
    function addProject()
    {
        global $db;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $project_title = $_POST['project_title'];
        $project_description = $_POST['project_description'];
        $project_address = $_POST['project_address'];
        $status = $_POST['status'];
        $db->query("SELECT * FROM tbl_project WHERE project_title = ?");
        $db->bind(1, $project_title);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different name.";
        } else {
            $db->query("INSERT INTO tbl_project(project_title,project_description,project_address,`status`) VALUES (?,?,?,?)");
            $db->bind(1, $project_title);
            $db->bind(2, $project_description);
            $db->bind(3, $project_address);
            $db->bind(4, $status);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function updateProject()
    {
        global $db;
        global $session;
        $userRole = ($session->get('user_data')['role']);
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $project_id = $_POST['project_id'] ?? null;
        $project_title = $_POST['project_title'] ?? null;
        $project_description = $_POST['project_description'] ?? null;
        $project_address = $_POST['project_address'] ?? null;
        $status = $_POST['status'];
        $db->query("SELECT * FROM tbl_project WHERE project_title = ? AND id != ?");
        $db->bind(1, $project_title);
        $db->bind(2, $project_id);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different name.";
        } else {
            if ($userRole == 'Superadmin') {
                $db->query("UPDATE tbl_project SET project_title = ?,project_description = ?,project_address = ?,`status` = ? WHERE id = ?");
                $db->bind(1, $project_title);
                $db->bind(2, $project_description);
                $db->bind(3, $project_address);
                $db->bind(4, $status);
                $db->bind(5, $project_id);
            } else {
                $db->query("UPDATE tbl_project SET `status` = ? WHERE id = ?");
                $db->bind(1, $status);
                $db->bind(2, $project_id);
            }

            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }

    function deleteProject()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $id = $_POST['id'];
        $db->query("DELETE FROM tbl_project WHERE id = $id");
        $response = [
            'success' => ($db->execute()) ? true : false,
        ];
        echo json_encode($response);
    }

    function printExpense()
    {
        include '_print/expense.php';
    }
    function printExpenses()
    {
        include '_print/expenses.php';
    }
    function addExpenses()
    {
        global $db;
        global $session;
        $userRole = ($session->get('user_data')['role']);
        if ($userRole == 'Superadmin') {
            $project_id = $_POST['project_id'];
        } else {
            $project_id = $session->get('project_id');
        }
        if (empty($_POST)) {
            // exit();
        }
        $date = $_POST['date'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $receipt_invoice = $_POST['receipt_invoice'];
        $amount = (float) str_replace(',', '', $_POST['amount']);
        $db->query("INSERT INTO tbl_expenses(`date`,category_id,`description`,receipt_invoice,amount,project_id) VALUES (?,?,?,?,?,?)");
        $db->bind(1, $date);
        $db->bind(2, $category_id);
        $db->bind(3, $description);
        $db->bind(4, $receipt_invoice);
        $db->bind(5, $amount);
        $db->bind(6, $project_id);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }

    function updateExpenses()
    {
        // header('Content-Type: Application/json');
        global $db;
        if (empty($_POST)) {
            exit();
        }
        $date = $_POST['date'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $receipt_invoice = $_POST['receipt_invoice'];
        $id = $_POST['id'];
        $amount = (float) str_replace(',', '', $_POST['amount']);
        $db->query("UPDATE tbl_expenses SET `date` = ?, category_id = ?, `description` = ?, receipt_invoice = ?, amount = ? WHERE id = ?");
        $db->bind(1, $date);
        $db->bind(2, $category_id);
        $db->bind(3, $description);
        $db->bind(4, $receipt_invoice);
        $db->bind(5, $amount);
        $db->bind(6, $id);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }


    function deleteExpenses()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $id = $_POST['id'];
        $db->query("DELETE FROM tbl_expenses WHERE id = $id");
        $response = [
            'success' => ($db->execute()) ? true : false,
        ];
        echo json_encode($response);
    }
    function loadExpenses()
    {
        require "template/expenses.php";
    }
    function loadInventory()
    {
        require "template/inventory.php";
    }
    function printInventory()
    {
        require "template/printInventory.php";
    }

    function addInventory()
    {
        global $db;
        global $session;
        $project_id = $session->get('project_id');

        if (empty($_POST)) {
            // exit();
        }
        $date = $_POST['date_acquired'];
        $type_id = $_POST['type_id'];
        $item_name = $_POST['item_name'];
        $id_plate_no = $_POST['id_plate_no'];
        $description = $_POST['description'];
        $availability = $_POST['availability'];
        $unit_cost = (float) str_replace(',', '', $_POST['unit_cost']);
        $db->query("INSERT INTO tbl_inventory(date_acquired,type_id,item_name,id_plate_no,unit_cost,`description`,`availability`,project_id) VALUES (?,?,?,?,?,?,?,?)");
        $db->bind(1, $date);
        $db->bind(2, $type_id);
        $db->bind(3, $item_name);
        $db->bind(4, $id_plate_no);
        $db->bind(5, $unit_cost);
        $db->bind(6, $description);
        $db->bind(7, $availability);
        $db->bind(8, $project_id);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }
    function updateInventory()
    {
        global $db;
        global $session;
        $item_no = $_POST['item_no'];
        $date = $_POST['date_acquired'];
        $type_id = $_POST['type_id'];
        $item_name = $_POST['item_name'];
        $id_plate_no = $_POST['id_plate_no'];
        $description = $_POST['description'];
        $employee_id = $_POST['employee_id'] ?? null;
        $availability = $_POST['availability'];
        $date_borrowed = !empty($_POST['date_borrowed']) ? $_POST['date_borrowed'] : '';
        $unit_cost = (float) str_replace(',', '', $_POST['unit_cost']);
        $db->query("UPDATE tbl_inventory SET date_acquired = ?, type_id = ?, item_name = ?, id_plate_no = ?, unit_cost = ?, `description` = ?, employee_id = ?, `availability` = ?, date_borrowed = ? WHERE item_no = ?");
        $db->bind(1, $date);
        $db->bind(2, $type_id);
        $db->bind(3, $item_name);
        $db->bind(4, $id_plate_no);
        $db->bind(5, $unit_cost);
        $db->bind(6, $description);
        $db->bind(7, $employee_id ?: \PDO::PARAM_NULL);
        $db->bind(8, $availability);
        $db->bind(9, $date_borrowed);
        $db->bind(10, $item_no);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }
    function addType()
    {
        header('Content-Type: Application/json');
        global $db;
        $type_name = $_POST['type_name'];
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_inventory_types WHERE type_name = ?");
        $db->bind(1, $type_name);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different name.";
        } else {
            $db->query("INSERT INTO tbl_inventory_types(type_name) VALUES (?)");
            $db->bind(1, $type_name);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function updateType()
    {
        header('Content-Type: Application/json');

        global $db;
        global $session;
        $type_id = $_POST['type_id'];
        $type_name = $_POST['type_name'];
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_inventory_types WHERE type_name = ? AND id != ?");
        $db->bind(1, $type_name);
        $db->bind(2, $type_id);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different name.";
        } else {
            $db->query("UPDATE tbl_inventory_types SET type_name = ? WHERE id = ?");
            $db->bind(1, $type_name);
            $db->bind(2, $type_id);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function deleteType()
    {
        header('Content-Type: Application/json');
        global $db;
        $type_id = $_POST['id'];
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $db->query("DELETE FROM tbl_inventory_types WHERE id = ?");
        $db->bind(1, $type_id);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }
    function deleteInventory()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $item_no = $_POST['item_no'];
        $db->query("DELETE FROM tbl_inventory WHERE item_no = $item_no");
        $response = [
            'success' => ($db->execute()) ? true : false,
        ];
        echo json_encode($response);
    }

    function getInventory()
    {
        global $db;
        $response = [];

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM tbl_inventory WHERE item_no = ?");
        $db->bind(1, $_POST['item_no']);
        $data = $db->single();
        if ($data) {
            $response['success'] = true;
            $response['rows'] = $data;
        }
        echo json_encode($response);
    }

    function getExpenses()
    {
        global $db;
        $response = [];

        if (empty($_POST)) {
            exit();
        }
        $db->query("SELECT * FROM view_expenses WHERE id = ?");
        $db->bind(1, $_POST['id']);
        $data = $db->single();
        if ($data) {
            $response['success'] = true;
            $response['rows'] = $data;
        }
        echo json_encode($response);
    }

    function loadEmployees()
    {
        require "template/employees.php";
    }

    function deleteEmployee()
    {
        if (empty($_POST)) {
            exit();
        }
        global $db;
        $id = $_POST['id'];
        $db->query("DELETE FROM tbl_employee WHERE id = $id");
        $response = [
            'success' => ($db->execute()) ? true : false,
        ];
        echo json_encode($response);
    }
    function loadAttendance()
    {
        require "template/attendance.php";
    }

    function loadCategories()
    {
        require "template/categories.php";
    }
    function cancelTransaction()
    {
        global $db;
        if (empty($_POST)) {
            exit();
        }
        $db->query("UPDATE transactions SET cancelled = 'Y' WHERE id = ?");
        $db->bind(1, $_POST['transactionId']);
        if ($db->execute()) {
            echo json_encode(array("ok" => true, "token" => uniqid()));
        }
    }

    function getRate()
    {
        global $db;
        $employee_id = $_POST['employee_id'];
        $db->query("SELECT rate_per_day FROM tbl_employee WHERE id = $employee_id");
        echo $db->single()['rate_per_day'];
    }

    function addCashAdvance()
    {
        // {
        //     "employee_id": 27,
        //     "rate_per_day": 800,
        //     "date": "2024-09-13",
        //     "amount": 1000,
        //     "weeks_to_pay": 1,
        //     "weekly_deduction": 1000
        //   }

        global $db;
        global $session;
        $response = [];
        $project_id = $session->get('project_id');
        $db->query("SELECT SUM(balance) as balance FROM tbl_cash_advance WHERE employee_id = ?");
        $db->bind(1, $_POST['employee_id']);
        $post_date = $_POST['date']; //Current Date
        $weeks_to_pay = $_POST['weeks_to_pay'];
        $CA_date = date('Y-m-d', strtotime('next monday', strtotime($post_date)));
        $currentDate = date('Y-m-d', strtotime($CA_date));
        $currentDayOfWeek = date('W', strtotime($CA_date));
        $currentYear = date('Y', strtotime($CA_date));
        $date = new \DateTime("January 1 $currentYear");
        $currentWeek = ($currentDayOfWeek - 2) + $weeks_to_pay;
        $date->modify("+$currentWeek weeks");
        // Adjust to the nearest Sunday
        $date->modify('Sunday this week');
        // Output the date in the desired format
        $payoff_date = $date->format('Y-m-d');
        if ($db->single()['balance'] <= 0) {
            $db->query("SELECT * FROM tbl_cash_advance WHERE '$CA_date' BETWEEN date AND payoff_date AND employee_id = ?");
            $db->bind(1, $_POST['employee_id']);
            if (!$db->single()) {
                $db->query("INSERT INTO tbl_cash_advance(employee_id,amount,`date`,weeks_to_pay,weekly_deduction,payoff_date,`status`,balance) VALUES (?,?,?,?,?,?,?,?)");
                $db->bind(1, $_POST['employee_id']);
                $db->bind(2, $_POST['amount']);
                $db->bind(3, $CA_date);
                $db->bind(4, $_POST['weeks_to_pay']);
                $db->bind(5, $_POST['weekly_deduction']);
                $db->bind(6, $payoff_date);
                $db->bind(7, 'Unpaid');
                $db->bind(8, $_POST['amount']);
                $db->execute();
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['message'] = "Cash Advance is not approved.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Cash Advance is not approved.";
        }
        echo json_encode($response);
    }

    function deleteCashAdvance()
    {
        global $db;
        $db->query("DELETE FROM tbl_cash_advance_payments WHERE cash_advance_id = ?");
        $db->bind(1, $_POST['id']);
        $db->execute();
        $db->query("DELETE FROM tbl_cash_advance WHERE id = ?");
        $db->bind(1, $_POST['id']);
        $db->execute();
        $response = [
            'success' => true,
        ];
        echo json_encode($response);
    }
    function loadCashAdvance()
    {
        require "template/cash_advance.php";
    }
    function loadPayroll()
    {
        require "template/payroll.php";
    }
    function loadReportExpenses()
    {
        require "template/report.expenses.php";
    }

    function loadUsers()
    {
        require "template/users.php";
    }

    function addUser()
    {
        header('Content-Type: Application/json');
        global $db;
        global $session;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $username = $_POST['username'];
        $db->query("SELECT * FROM tbl_user WHERE username = ?");
        $db->bind(1, $username);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different username.";
        } else {
            $db->query("INSERT INTO tbl_user(username,`password`,full_name,`role`,`status`) VALUES (?,?,?,?,?)");
            $db->bind(1, $_POST['username']);
            $db->bind(2, password_hash($_POST['password'], PASSWORD_BCRYPT));
            $db->bind(3, $_POST['full_name']);
            $db->bind(4, $_POST['role']);
            $db->bind(5, 'ACTIVE');
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function updateUser()
    {
        header('Content-Type: Application/json');
        global $db;
        global $session;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $id = $_POST['id'];
        $username = $_POST['username'];
        $db->query("SELECT * FROM tbl_user WHERE username = ? AND id != ?");
        $db->bind(1, $username);
        $db->bind(2, $id);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different username.";
        } else {
            $db->query("UPDATE tbl_user SET username = ?,full_name = ?,`role` = ?,`status` = ? WHERE id = ?");
            $db->bind(1, $_POST['username']);
            $db->bind(2, $_POST['full_name']);
            $db->bind(3, $_POST['role']);
            $db->bind(4, $_POST['status']);
            $db->bind(5, $id);
            if ($db->execute()) {
                $response['success'] = true;
            }
        }
        echo json_encode($response);
    }
    function updateUserPw()
    {
        header('Content-Type: Application/json');
        global $db;
        global $session;
        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $id = $_POST['id'];
        $db->query("UPDATE tbl_user SET `password` = ? WHERE id = ?");
        $db->bind(1, password_hash($_POST['password'], PASSWORD_BCRYPT));
        $db->bind(2, $id);
        if ($db->execute()) {
            $response['success'] = true;
        }
        echo json_encode($response);
    }
    function updateAccount()
    {
        header('Content-Type: Application/json');
        global $db;
        global $session;
        $userId = $session->get('user_data')['id'];

        $response = [];
        if (empty($_POST)) {
            exit();
        }
        $id = $userId;
        $db->query("SELECT * FROM tbl_user WHERE id = ?");
        $db->bind(1, $id);
        $userdata = $db->single();
        $username = $_POST['username'];
        $db->query("SELECT * FROM tbl_user WHERE username = ? AND id != ?");
        $db->bind(1, $username);
        $db->bind(2, $id);
        if ($db->single()) {
            $response['success'] = false;
            $response['message'] = "Already exist. Try a different username.";
        } else {
            if (password_verify($_POST['current_password'], $userdata['password'])) {
                if ($_POST['new_password'] == $_POST['confirm_password']) {
                    $db->query("UPDATE tbl_user SET username = ?,full_name = ?,`password` = ? WHERE id = ?");
                    $db->bind(1, $_POST['username']);
                    $db->bind(2, $_POST['full_name']);
                    $db->bind(3, password_hash($_POST['new_password'], PASSWORD_BCRYPT));
                    $db->bind(4, $id);
                    if ($db->execute()) {
                        $response['success'] = true;
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Password do not match.";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Current password is invalid.";
            }
        }
        echo json_encode($response);
    }

    function Login()
    {
        global $db;
        global $session;
        if (empty($_POST)) {
            exit();
        }
        $username = $_POST['username'];
        $password = $_POST['login']['password'];
        $db->query("SELECT * FROM tbl_user WHERE username = ? AND `status` = 'ACTIVE'");
        $db->bind(1, $username);
        $row = $db->single();
        $response = [
            'status' => 'error',
            'message' => 'You have entered an username or password.',
        ];

        if ($row && password_verify($password, $row['password'])) {
            $session->set('authenticated', true);
            $userData = [
                'id' => $row['id'],
                'username' => $row['username'],
                'full_name' => $row['full_name'],
                'role' => $row['role'],
            ];
            $session->set('user_data', $userData);
            $response['success'] = true;
            $response['message'] = 'Login success';
        }
        echo json_encode($response);
    }

    function Logout()
    {
        global $session;
        $session->destroy(); //here we can now clear the session.
        header("Location: /login");
        exit();
    }
}
