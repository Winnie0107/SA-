<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>惜物盲盒</title>

</head>

<body>
    <?php
        session_start();
        $dbaction = $_POST['dbaction'];
        $PNumber = $_POST['PNumber'];
        $PName = $_POST['PName'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $details = $_POST['details'];
        $selled = 0;
        $seller = $_SESSION['account'];
        $image_new_name = "1";
        $image_upload_path = "bookpicture/";
        $SNumber = $_POST['SNumber'];
        $RNumber = $_POST['RNumber'];
        
        $link = mysqli_connect('localhost', 'root', '12345678', 'box');
        if ($dbaction == "insert") {
            $sql = "insert into product (PNumber, PName, category, price, selled, seller) values (NULL, '$PName', '$category', '$price', '$selled', '$seller')";
            if (mysqli_query($link, $sql)) {
                //echo "新增成功";
                $sql = "SELECT * FROM product ORDER BY PNumber DESC LIMIT 1";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $BNumber = $row['BNumber'];
                }
                
                $path = "bookpicture/".$PNumber;
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                
                try{
                    for($i=0;$i<3;$i++){
                        $is_upload = move_uploaded_file($_FILES["file"]["tmp_name"][$i],"bookpicture/".$PNumber."/".$_FILES["file"]['name'][$i]);
                        rename("bookpicture/".$BNumber."/".$_FILES["file"]['name'][$i],"bookpicture/".$PNumber.'/'.$i.'.png');

                    }
                    
                }
                catch(Exception $e){}
            }
        }
    ?>        
        
</body>


