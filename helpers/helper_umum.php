<?php

function _d($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
}

// cukup kesulitan di pagination menggunakan fucntion
function pagination($row, $menu)
{
    $number = $GLOBALS['num'];
    $page_num = ceil($row / $GLOBALS['query_num']);

    for ($i = 1; $i <= $page_num; $i++) {
        echo "<li class='page-item" . ($number == $i || ($number == 0 && $i == 1)) ? 'active' : '' . "
            <a class='page-link bg-light' href='index.php?p=$menu&num=$i'>$i</a>
        </li>";
    }
}

// fungsi base url 
function base_url($url = null)
{
    $base_url = 'http://localhost/perpustakaan';
    if ($url != null) {
        return $base_url . "/" . $url;
    } else {
        return $base_url;
    }
}
