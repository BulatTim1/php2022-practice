<?php
namespace App\Snippets;

if (isset($_SESSION['alerts'])) {
    foreach ($_SESSION['alerts'] as $alert) {
        echo '<div class="alert alert-danger">' . $alert . '</div>';
    }
    $_SESSION['alerts'] = [];
}