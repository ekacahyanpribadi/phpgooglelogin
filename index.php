<?php
session_start(); // Start session nya
// Kita cek apakah user sudah login atau belum
// Cek nya dengan cara cek apakah terdapat session username atau tidak
if(isset($_SESSION['username'])){ // Jika session username ada berarti dia sudah login
  header('location: welcome.php'); // Kita Redirect ke halaman welcome.php
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Demo Login with Google</title>
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <?php 
    //extract($_SESSION);
    //print_r($_SESSION);    
    ?>
    <div style="margin:20px 0;"></div>
    <div id="win" class="easyui-window" title="Login" style="width:400px;">
        <form id="ff" method="post" action="#" novalidate enctype="multipart/form-data">
            <div style="margin-top:20px; text-align: center;">
                <input class="easyui-textbox" id="username" name="username" iconWidth="28" label="User:" style="width:70%">
            </div>
            <div style="margin-top:20px; text-align: center;">
                <input class="easyui-passwordbox" id="password" name="password" iconWidth="28" label="Password:" style="width:70%">
            </div>
            <div style="margin-top:20px;padding:5px;text-align:center;">
                <!-- <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()"
                    style="width:80px">Submit</a> -->
                <a href="javascript:void(0)" class="easyui-linkbutton" icon="icon-ok" onclick="submitForm()"
                    style="width:100px">Login</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" icon="icon-cancel" onclick="resetForm()"
                    style="width:100px">Cancel</a>
            </div>
            <div style="margin-top:20px;padding:5px;text-align:center;">
                <a href="lib/google.php" class="easyui-linkbutton" style="width:200px">Login with Google</a>
            </div>
        </form>
    </div>
    <script>
        var url = 'p_login_action.php';
        //$(document).ready(function () {
        function submitForm() {
            $('#ff').form('submit', {
                url: url,
                onSubmit: function () {
                    // do some check
                    // return false to prevent submit;
                    $.messager.progress({
                        title: 'Mohon Menunggu',
                        msg: 'Data sedang diproses ...',
                        interval: 3700, // ask server for progress every 2 seconds
                        //callback: progressMonitor
                    });
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    //console.log(obj.code);    
                    console.log(obj.status);
                    //console.log(obj.data); 
                    if (obj.status != "200") {
                        //$.messager.alert('Error',obj.data,'error')
                        $.messager.confirm('Error', obj.data, function (r) {
                            if (r) {

                                $.messager.progress('close');
                            }
                        });

                    } else {
                        $('#p').progressbar('setValue', '100');
                        $.messager.confirm('Success', obj.data, function (r) {
                            if (r) {
                                $.messager.progress('close');
                                $('#ff').form('clear');
                            }
                        });
                    }
                }
            });
        }

        function clearForm() {
            $('#ff').form('clear');
        }


        //});
    </script>
</body>

</html>
<?php

?>