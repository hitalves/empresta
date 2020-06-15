<?php
function loadScript($n) {
    $src = asset('css/main.css');
    $script = '<script src="' . $src . '"></script>';
    print $script;
}