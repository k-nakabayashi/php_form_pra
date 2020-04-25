
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php include(HEAD);?>
</head>
<body>
    <div class="contianer">
    <form method="POST" id="js-Form">
        <!-- <form action="confirmUser"  method="POST" id="js-Form"> -->
            <label for="">
                <p>名前</p>
                <input type="text" name="name">
            </label>

            <label for="">
                <p>メール</p>
                <input type="email" name="email">
            </label>
            
            <label for="">
                <p>パスワード</p>
                <input type="text" name="password">
            </label>
            
            <label for="">
                <p>確認用パスワード</p>
                <input type="text" name="confirming_password">
            </label>
            
            <input type="hidden" name="csrf_token">
            <button id="js-Submit">送信</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    $(function () {


    $submit = $('#js-Submit');
    $submit.on('click', function (event) {
       
        event.preventDefault();
        $form = document.getElementById('js-Form');
        let valideteOK = false;
        valideteOK = startValidate($form);
        if (valideteOK) {
            // $form.submit();
        }
    });

    //非同期のタイミング管理が必要
    //全部非同期バリーデーションを実行し、全部終わったらreturn
    function startValidate($i_form) {

     
        checkEqualPass($i_form.password.value, $form.confirming_password.value);
        checkDuplicateEmail($i_form.email.value);
        if (Object.keys(window.alertError).length !== 0) {
            
            let errorMessage = "";
            for (let key in window.alertError) {
                errorMessage += "・" + window.alertError[key];
            }
            alert(errorMessage);
            return false; 
        }
        return true;
    }

    function checkEqualPass(i_password, i_confirming_password){
        let equalOK = i_password == i_confirming_password? true : false;
        if (!equalOK) {
            window.alertError['password'] = window.error['MSG03'];
        }
    }
    function checkDuplicateEmail ($i_email) {

        $.ajax({
            type: 'post',
            url: 'checkDuplicateEmail',
            dataType: 'json',
            data: {
                route: 'api',
                email: $i_email,
            }
        }).then(function (data) {
            let result = data.data;
            if (result == 'false') {
                window.alertError['email'] = window.error['MSG08'];
            }
        });
    }

    window.alertError = {};
    window.error = {
        'MSG01': "<?php echo MSG01 ?>",
        'MSG02': "<?php echo MSG02 ?>",
        'MSG03': "<?php echo MSG03 ?>",
        'MSG04': "<?php echo MSG04 ?>",
        'MSG08': "<?php echo MSG08 ?>",
    }
});
</script>
</body>
</html>