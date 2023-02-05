<?php

function validate_pin_code($pinCode): bool
{
    return is_numeric($pinCode) && strlen($pinCode) == 4;
}