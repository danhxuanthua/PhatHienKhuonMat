<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>jQuery FaceDetection Examples</title>
    
   
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <style>

        .picture-container {
            position: relative;
            width: 600px;
            height: auto;
            margin: 20px auto;
            border: 10px solid #fff;
            box-shadow: 0 5px 5px #000;
        }
            .picture {
                display: block;
                width: 100%;
                height: auto;
            }
            
        .face {
            position: absolute;
            border: 2px solid #FFF;
        }
    </style>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <h2>Demo phát hiện khuôn mặt</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="image" class="btn btn-info"/>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Upload </button>
                </form>

                <a id="try-it" href="#">
                    <button type="button" name="" class="btn btn-warning"> <span class="glyphicon glyphicon-search"></span> Tìm khuôn mặt </button>
                    
                </a>
                        
            </div>
            <div class="col-sm-7">
                <div class="picture-container">
                    <img id="picture" class="img-responsive" src="<?php echo upload_file('image');  ?>">
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="dist/jquery.facedetection.js"></script>
   
    <script>
        /* global $ */
        $(function () {
            "use strict";
            
            $('#try-it').click(function (e) {
                e.preventDefault();

                $('.face').remove();

                $('#picture').faceDetection({
                    complete: function (faces) {                        
                        for (var i = 0; i < faces.length; i++) {
                            $('<div>', {
                                'class':'face',
                                'css': {
                                    'position': 'absolute',
                                    'left':     faces[i].x * faces[i].scaleX + 'px',
                                    'top':      faces[i].y * faces[i].scaleY + 'px',
                                    'width':    faces[i].width  * faces[i].scaleX + 'px',
                                    'height':   faces[i].height * faces[i].scaleY + 'px'
                                }
                            })
                            .insertAfter(this);
                        }
                    },
                    error:function (code, message) {
                        alert('Error: ' + message);
                    }
                });
            });
        });
    </script>

    <?php

    function upload_file($name){

        if(isset($_FILES[$name])){
            $errors= array();
            $file_name = $_FILES[$name]['name'];
            $file_size =$_FILES[$name]['size'];
            $file_tmp =$_FILES[$name]['tmp_name'];
            $file_type=$_FILES[$name]['type'];
            $file_ext=@strtolower(end(explode('.',$_FILES[$name]['name'])));
              
            $expensions= array("jpeg","jpg","png");
              
            if(in_array($file_ext,$expensions)=== false){
                $errors[]="Không chấp nhận định dạng ảnh có đuôi này, mời bạn chọn JPEG hoặc PNG.";
            }
            if($file_size > 2097152){
                    $errors[]='Kích cỡ file nên là 2 MB';
                }
              
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,'img/'.$file_name);
                $result = 'img/' . $file_name;
            }
            else{
                print_r($errors);
            }
        }
        return $result;
    }     
?>
</body>
</html>

