<?php
include 'include/Database.php';
for ($i = 0; $i < 10; $i++)
{
    // DB::addPost('Test title', 'Test body');
}

header('Location: index.php');