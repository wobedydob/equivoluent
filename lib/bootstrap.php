<?php

include 'functions.php';
include 'validation.php';

function getUserMapper(): \Mapper\UserMapper
{
    return new \Mapper\UserMapper();
}

function getUserCollectionMapper(): \Mapper\CollectionMapper
{
    return new \Mapper\CollectionMapper(new \Mapper\UserMapper());
}