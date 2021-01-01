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
    $(document).on("click",".updateSectionStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status',
            data: {status:status, section_id:section_id},
            success:function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp['status'] == 0) {
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus' id='section-{{ $sec->id }}' section_id='{{ $sec->id }}'><i class='fas fa-toggle-off' status='Inactive' aria-hidden='true'></i></a>");                    
                } else if(resp['status'] == 1){

                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus' id='section-{{ $sec->id }}' section_id='{{ $sec->id }}'><i class='fas fa-toggle-on'  status='Active' aria-hidden='true'></i></a>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change Brand Status
    $(document).on("click",".updateBrandStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var brand_id = $(this).attr("brand_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-brand-status',
            data: {status:status, brand_id:brand_id},
            success:function (resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp['status'] == 0) {
                    $("#brand-"+brand_id).html('<i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i>');
                } else if(resp['status'] == 1){
                    $("#brand-"+brand_id).html('<i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i>');
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change category status
    $(document).on("click",".updateCategoryStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: {status:status, category_id:category_id},
            success:function (resp) {
                // alert(resp['status']);
                // alert(resp['category_id']);
                if (resp['status'] == 0) {
                    $("#category-"+category_id).html("<i class='fas fa-toggle-off' status='Inactive' aria-hidden='true'></i>");
                } else if(resp['status'] == 1){
                    $("#category-"+category_id).html("<i class='fas fa-toggle-on' status='Active' aria-hidden='true'></i>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change product status
    $(document).on("click",".updateProductStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: {status:status, product_id:product_id},
            success:function (resp) {
                if (resp['status'] == 0) {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-off' status='Inactive' aria-hidden='true'></i>");
                } else if(resp['status'] == 1){
                    $("#product-"+product_id).html("<i class='fas fa-toggle-on' status='Active' aria-hidden='true'></i>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change attribute status
    $(document).on("click",".updateAttributeStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-attribute-status',
            data: {status:status, attribute_id:attribute_id},
            success:function (resp) {
                if (resp['status'] == 0) {
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' status='Inactive' aria-hidden='true'></i>");
                } else if(resp['status'] == 1){
                    $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' status='Active' aria-hidden='true'></i>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change image status
    $(document).on("click",".updateImageStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var image_id = $(this).attr("image_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-image-status',
            data: {status:status, image_id:image_id},
            success:function (resp) {
                if (resp['status'] == 0) {
                    $("#image-"+image_id).html("i class='fas fa-toggle-off' status='Inactive' aria-hidden='true'></i>");
                } else if(resp['status'] == 1){
                    $("#image-"+image_id).html("<i class='fas fa-toggle-on' status='Active' aria-hidden='true'></i>");
                    
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Change attribute status
    $(document).on("click",".updateBannerStatus", function(){
        var status = $(this).children("i").attr("status");
        // var status = $(this).text();
        var banner_id = $(this).attr("banner_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-banner-status',
            data: {status:status, banner_id:banner_id},
            success:function (resp) {
                if (resp['status'] == 0) {
                    $("#banner-"+banner_id).html("<i class='fas fa-toggle-off' status='Inactive' aria-hidden='true'></i>");
                } else if(resp['status'] == 1){
                    $("#banner-"+banner_id).html("<i class='fas fa-toggle-on' status='Active' aria-hidden='true'></i>");
                }
            }, error:function () {
                alert("Error");
            }
        });
    });

    // Append categories level
    $('#section_id').change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: 'post',
            url: '/admin/append-categories-level',
            data: {section_id:section_id},
            success:function (resp) {
                $("#appendCategoriesLevel").html(resp);
            }, error:function () {
                alert("error")
            }
        });
    })

    // Delete confirmation
    $(document).on("click",".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordid;
            }
        }); 
    });

    var maxField = 10;
    var addButton = $('.add_button');
    var wrapper = $('.attr-form');
    var fieldHTML = '<div class="form-row mb-2"><div class="col-auto"><input id="size" name="size[]" type="text" class="form-control" value="" placeholder="Size" required>    </div><div class="col-auto"><input id="sku" name="sku[]" type="text" class="form-control" value="" placeholder="SKU" required>    </div><div class="col-auto"><input id="price" name="price[]" type="number" class="form-control" value="" placeholder="Price" required>    </div><div class="col-auto"><input id="stock" name="stock[]" type="number" class="form-control" value="" placeholder="Stock" required></div>&nbsp;<a href="javascript:void(0)" class="remove_button"><i class="fas fa-trash"></i></a></div>';
    var x = 1;

    $(addButton).click(function () {
        if (x < maxField) {
            x++;
            $(wrapper).append(fieldHTML);
        }
    });

    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent().remove();
        x--;
    });
 });