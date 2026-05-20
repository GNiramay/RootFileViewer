<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$files  = glob("*.root");
$dirs   = array_filter(glob("*"), "is_dir");
$dirs   = array_values(array_diff($dirs, [".", ".."]));

echo json_encode([
    "root_files" => $files  ? array_values($files)  : [],
    "dirs"       => $dirs   ? array_values($dirs)   : []
]);