<?php
/*
 * Author: Dahir Muhammad Dahir
 * Date: 26-April-2020 5:44 PM
 * About: identification and verification
 * will be carried out in this file
 */

namespace fingerprint;

require_once ("../core/helpers/helpers.php");
require_once ("../core/querydb.php");
require_once ("../../vendor/db.pdo.php");


if (!empty($_POST["data"])) {
    $match = false;
    $employee = '';
    $user_data = json_decode($_POST["data"]);
    $user_id = $user_data->id;
    //this is not necessarily index_finger it could be
    //any finger we wish to identify
    $pre_reg_fmd_string = $user_data->index_finger[0];

    $db = new \DBConnect();
    $db->query("select * from view_employee");
    $hands = $db->set();
    foreach ($hands as $hand) {
        $hand_data = json_decode(json_encode($hand));
        $enrolled_fingers = [
            "index_finger" => $hand_data->indexfinger,
            "middle_finger" => $hand_data->middlefinger
        ];

        $json_response = verify_fingerprint($pre_reg_fmd_string, $enrolled_fingers);
        $response = json_decode($json_response);

        if ($response === "match") {
            $match = true;
            echo getUserDetails($hand['id']);
            break;
        }
    }

} else {
    echo "post request with 'data' field required";
}
