<?php
/*
 * Author: Dahir Muhammad Dahir
 * Modified by: Devpedz
 * Date: 26-April-2020 12:41 AM
 * About: this file is responsible
 * for all Database queries
 */

namespace fingerprint;

require_once ("db.pdo.php");

function setUserFmds($user_id, $index_finger_fmd_string, $middle_finger_fmd_string)
{

    $db = new \DBConnect1();
    $sql_query = "update tbl_employee set indexfinger=?, middlefinger=? where id=?";
    $db->query($sql_query);
    $db->bind(1, $index_finger_fmd_string);
    $db->bind(2, $middle_finger_fmd_string);
    $db->bind(3, $user_id);


    if ($db->execute() > 0) {
        return "success";
    } else {
        return "failed in querydb";
    }
}

function getUserFmds($user_id)
{
    $db = new \DBConnect1();
    $db->query("select indexfinger, middlefinger from tbl_employee where id=? AND `status` = 'ACTIVE'");
    $db->bind(1, $user_id);
    $fmds = $db->single();
    return json_encode($fmds);
}

function getUserDetails($user_id)
{
    $db = new \DBConnect1();
    $db->query("select *,'success' as status from view_employee where id=? AND `status` = 'ACTIVE'");
    $db->bind(1, $user_id);
    $user_info = $db->single();
    return json_encode($user_info);
}

function getAllFmds()
{
    $db = new \DBConnect1();
    $db->query("select indexfinger, middlefinger from tbl_employee where indexfinger != '' AND `status` = 'ACTIVE'");
    $allFmds = $db->set();
    return json_encode($allFmds);
}