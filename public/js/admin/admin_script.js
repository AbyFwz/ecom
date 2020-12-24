 $(document).ready(function() {
    // Check current pwd
    $("#current_pwd").keyup(function() {
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            type: 'post',
            url: '/admin/check-current-pwd',
            data: {current_pwd:current_pwd},
            success:function (resp) {
                // alert(resp);
                if (resp == 'false') {
                    $("#chkCurrentPwd").html("<font color=red>Current Password is incorrect</font>");
                } else if(resp == 'true') {
                    $("#chkCurrentPwd").html("<font color=green>Current Password is correct</font>");
                }
            }, error:function () {
                alert("error")
            }
        });
    });
 });