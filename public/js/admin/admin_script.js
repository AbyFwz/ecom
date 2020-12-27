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

    // Change section status
    $(".updateSectionStatus").click(function () {
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status',
            data: {status:status, section_id:section_id},
            success:function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp['status'] == 0) {
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus' id='section-{{ $sec->id }}' section_id='{{ $sec->id }}'>Inactive</a>");
                } else if(resp['status'] == 1){
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus' id='section-{{ $sec->id }}' section_id='{{ $sec->id }}'>Active</a>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change category status
    $(".updateCategoryStatus").click(function () {
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: {status:status, category_id:category_id},
            success:function (resp) {
                // alert(resp['status']);
                // alert(resp['category_id']);
                if (resp['status'] == 0) {
                    $("#category-"+category_id).html("<a href='javascript:void(0)' class='updateCategoryStatus' id='category-{{ $cat->id }}' category_id='{{ $cat->id }}'>Inactive</a>");
                } else if(resp['status'] == 1){
                    $("#category-"+category_id).html("<a href='javascript:void(0)' class='updateCategoryStatus' id='category-{{ $cat->id }}' category_id='{{ $cat->id }}'>Active</a>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });
 });