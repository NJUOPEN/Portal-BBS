<?php
if ($_FILES["file"]["error"] > 0) {
    echo "Error: ".$_FILES["file"]["error"]."<br />";
} else {
    $filename = $_FILES["file"]["name"];
    $filetype = $_FILES["file"]["type"];
    $filesize = $_FILES["file"]["size"] / 1024;
    $fileaddr = $_FILES["file"]["tmp_name"];

    /* debug
    echo $filetype."<br />";
    echo $fileaddr."<br />";

    echo "Is uploaded file: ".is_uploaded_file($fileaddr)."<br />";
     */

    //TODO:确定一个保存路径,以及和数据库的配合
    move_uploaded_file($fileaddr, BBS_ROOT."/".$filename);
}
?>
