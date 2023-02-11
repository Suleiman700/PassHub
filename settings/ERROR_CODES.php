<?php

$ERROR_CODES = array(
    "ENCRYPTION" => array(
        "USER_SECRETS" => array(
            "NOT_FOUND" => array(
                "NAME" => "No encryption error",
                "CODE" => "EUN.1001",
                "CAUSE" => "User secrets were not found in the database.",
                "FIX" => "Check if the user exists in the database and their secrets have been stored properly."
            ),
        ),
    ),
    "DECRYPTION" => array(
        "USER_SECRETS" => array(
            "NOT_FOUND" => array(
                "NAME" => "No decryption keys",
                "CODE" => "DUN.1001",
                "CAUSE" => "User secrets were not found in the database.",
                "FIX" => "Check if the user exists in the database and their secrets have been stored properly."
            ),
        ),
    ),
    "PASSWORDS" => array(
        "INSERT" => array(
            "QUERY_FAILED" => array(
                "NAME" => "Error saving password",
                "CODE" => "PIQ.1001",
                "CAUSE" => "The insert query failed to execute properly. This could be due to a variety of reasons including incorrect SQL syntax, missing data, or connectivity issues.",
                "FIX" => "Check the SQL syntax, verify that all required data has been provided, and troubleshoot any connectivity issues."
            ),
        ),
        "GET" => array(
            "NOT_FOUND" => array(
                "NAME" => "Passwords not found",
                "CODE" => "PGN.1001",
                "CAUSE" => "No passwords have been found.",
                "FIX" => "Check the function that gets user passwords."
            ),
        ),
    ),
);