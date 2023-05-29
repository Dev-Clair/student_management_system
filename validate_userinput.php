<?php

/** VALIDATE_NAME CLASS */
function clean_name($name): string
{
    /**
     * Cleans and formats userinput using the trim, strim_tags and ucwords functions
     * @param string - $name
     * returns string
     */
    return ucwords(trim(strip_tags($name)));
}

/** VALIDATE_NAME CLASS */
function validate_name($formatted_name): string
{
    /**
     * Validates userinput using the ctype_alpha function
     * @param string - $formatted_name
     * returns true or false
     */
    if (!ctype_alpha($formatted_name))
        return "false";
    return "true";
}

/** VALIDATE_CLASS CLASS */
function clean_class($class): string
{
    /**
     * Cleans and formats userinput using the trim, strim_tags and strtolower functions
     * @param string - $class
     * returns string
     */
    return strtolower(trim(strip_tags($class)));
}

/** VALIDATE_CLASS CLASS */
function validate_class($formatted_class): string
{
    /**
     * Validates userinput by searching if userinput is in a defined list of allowed values
     * @param string - $formatted_class
     * returns true or false
     */
    $allowed_values = ["stem", "commerce", "art"];
    if (!in_array($formatted_class, $allowed_values))
        return "false";
    return "true";
}

/** VALIDATE_GRADE CLASS */
function clean_grade($grade): string
{
    /**
     * Cleans and formats userinput using the trim and strim_tags functions
     * @param string - $name
     * returns string
     */
    return trim(strip_tags($grade));
}

/** VALIDATE_GRADE CLASS */
function validate_grade($formatted_grade): string
{
    /**
     * Validates userinput using a comparison condition
     * @param string - $formatted_grade
     * returns true or false
     */
    if ($formatted_grade < 0 || $formatted_grade > 10)
        return "false";
    return "true";
}

function redirect_to($page_name)
{
    /**
     * redirects to page name passed as argument
     * @param string - $page_name
     */
    $address = 'Location: ' . $page_name;
    return header($address);
}
