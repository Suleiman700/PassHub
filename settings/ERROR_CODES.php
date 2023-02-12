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
    "CATEGORIES" => array(
        "DELETE" => array(
            "QUERY_FAILED" => array(
                "NAME" => "Error deleting category",
                "CODE" => "CDQ.1001",
                "CAUSE" => "The insert query failed to execute properly. This could be due to a variety of reasons including incorrect SQL syntax, missing data, or connectivity issues.",
                "FIX" => "Check the SQL syntax, verify that all required data has been provided, and troubleshoot any connectivity issues."
            ),
            "VALIDATION" => array(
                "DOESNT_BELONG_TO_USER" => array(
                    "NAME" => "You dont own this category",
                    "CODE" => "CDVD.1001",
                    "CAUSE" => "Found out that category id does not belong to user id",
                    "FIX" => "Make sure that the category id you are trying to check belongs to the user id when trying to delete it"
                ),
                "NOT_FOUND" => array(
                    "NAME" => "Category was not found",
                    "CODE" => "CDVN.1002",
                    "CAUSE" => "Found out that category id does not exist",
                    "FIX" => "Make sure that the category id you are trying to check exists in database when trying to delete it"
                ),
                "IDENTIFIER_NOT_FOUND" => array(
                    "NAME" => "Category identifier was not found",
                    "CODE" => "CDVI.1003",
                    "CAUSE" => "Found out that category id identifier does not exist",
                    "FIX" => "Make sure that the category id is sent to the server when you are trying to delete it"
                ),
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
            "VALIDATION" => array(
                "FIELDS" => array(
                    "ONE_OR_MORE_ARE_INVALID" => array(
                        "NAME" => "One or more fields are invalid",
                        "CODE" => "PIVFO.1001",
                        "CAUSE" => "One or more required fields are empty or not set",
                        "FIX" => "Make sure to check the required fields and check if they are set properly"
                    ),
                ),
                "CATEGORY" => array(
                    "DOESNT_BELONG_TO_USER" => array(
                        "NAME" => "You dont own this category",
                        "CODE" => "PIVCD.1001",
                        "CAUSE" => "Found out that category id does not belong to user id",
                        "FIX" => "Make sure that the category id you are trying to check belongs to the user id when trying to create a new password"
                    ),
                    "NOT_FOUND" => array(
                        "NAME" => "Category was not found",
                        "CODE" => "PIVCN.1002",
                        "CAUSE" => "Found out that category id does not exist",
                        "FIX" => "Make sure that the category id you are trying to check exists in database when trying to create a new password"
                    ),
                ),
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