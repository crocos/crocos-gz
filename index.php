<?php
/**
 *
 */

?>
<html>
<head>
<title>g.dev.crocos.jp</title>
<style type="text/css">
body {
    font-family: Helvetica, "ヒラギノ 角ゴ Pro W3";
    font-size: 18px;
}

.image-list {
    margin: 0;
    padding: 0;
}

.image-list li {
    padding: 5px;
    float: left;
    list-style: none;
}
.image-list li img {
    border: solid 1px #ccc;
    padding: 5px;
}

.image-list li img:hover {
    background: #f0f0f0;
}



</style>
</head>

<body>

<h1>Crocos Gyazo</h1>


<h2>Application</h2>
<ul>
<li>Mac: <a href="cgyazo.zip">cgyazo.app (zip)</a></li>
</ul>

<?php
/*
<h2>Recent Uploaded</h2>

<ul class="image-list">
 */
?>
<?php
/*
foreach (
    new LimitIterator(
        new ArrayIterator(array_reverse(glob('./data/*.png'))),
        0,
        40
    ) as $img):
?>
    <li><img src="<?php echo $img; ?>" /></li>
<?php
endforeach;
 */
?>
</ul>
</body>
</html>
