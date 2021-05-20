<?php 
$search = '/[a-zA-Z]\s(\()[a-zA-Z0-9_]+(.)[a-zA-Z]+(\)).,$';
$search = "/([a-zA-Z])\s(\()";
$replace = "/([a-zA-Z])(')\s(=>)\s(')";

$space_left_parentheses = "\s(\()";
$replace_with = " ' => ' ";

$single_quote_three_capital_letters_right_parentheses_single_quote_space_right_arrow_space = "[A-Z]{3}(\)')\s(=>)\s'";
$replace_with = "";

$right_parentheses_comma = "(\)')";
$replace_with = ",";