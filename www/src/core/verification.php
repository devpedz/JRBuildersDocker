<?php
/*
 * Author: Dahir Muhammad Dahir
 * Date: 26-April-2020 5:44 PM
 * About: identification and verification
 * will be carried out in this file
 */

namespace fingerprint;

require_once("../core/helpers/helpers.php");
require_once("../core/querydb.php");

if (!empty($_POST["data"])) {
    $user_data = json_decode($_POST["data"]);
    $user_id = $user_data->id;
    //this is not necessarily index_finger it could be
    //any finger we wish to identify
    $pre_reg_fmd_string = $user_data->fingerprint_data[0];
    // echo $pre_reg_fmd_string;
    // $payload_array = json_decode($payload_json, true);

    // Access the index_finger array from finger_verify
    // $index_finger = $payload_array['finger_verify']['index_finger'];
    $verify_finger = $user_data->fingerprint_verify;
    echo $verify_finger;

    $enrolled_fingers = [
        "index_finger" => $verify_finger,
        "middle_finger" => $verify_finger
    ];
    $json_response = verify_fingerprint($pre_reg_fmd_string, $enrolled_fingers);
    $response = json_decode($json_response);

    if ($response === "match") {
        echo json_encode("match");
        // echo getUserDetails($user_id);
    } else {
        echo json_encode("failed");
    }
} else {
    echo "post request with 'data' field required";
}
