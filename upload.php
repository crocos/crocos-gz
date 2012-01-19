<?php
/**
 *
 */

//$hash = md5($_POST['imagedata']);
$hash = md5($_POST['imagedata']);
$dir = date("Ymd");
$now = date("YmdHis");
$fname = $dir . '/' . $hash . '.png';
if (!is_dir("data/{$dir}")) {
    mkdir("data/{$dir}");
}
file_put_contents("data/{$fname}", $_POST['imagedata']);
$db_filename = "db/id.db";
$db = unserialize(file_get_contents($db_filename));
$db[$hash] = $_POST['id'];
file_put_contents("db/id.db", serialize($db));
echo "http://g.dev.crocos.jp/data/$fname";
