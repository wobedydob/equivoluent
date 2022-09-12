<?php

//region Module validation

// Validates if the Database Module exists.
if(!class_exists('Module\Database')) {
    throw new \Exception('Required Database module not found');
}

// Validates if the Query Module exists.
if(!class_exists('Module\Query')) {
    throw new \Exception('Required Query module not found');
}

// Validates if the Model Module exists.
if(!class_exists('Module\Model')) {
    throw new \Exception('Required Model module not found');
}
//endregion

//region Query validations

// Validates if QuerySelect exists.
if(!class_exists('Query\QuerySelect')) {
    throw new \Exception('QuerySelect query not found!');
}

// Validates if QueryInsert exists.
if(!class_exists('Query\QueryInsert')) {
    throw new \Exception('QueryInsert query not found!');
}

// Validates if QueryUpdate exists.
if(!class_exists('Query\QueryUpdate')) {
    throw new \Exception('QueryUpdate query not found!');
}

// Validates if QueryDelete exists.
if(!class_exists('Query\QueryDelete')) {
    throw new \Exception('QueryDelete query not found!');
}

//endregion