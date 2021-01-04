$(document).ready(function () {
    
    $("#sort").on('change',function(){
        var sort = $(this).val();
        var url = $("#url").val();
        $.ajax({
            url:url,
            method:"post",
            data:{sort:sort, url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        })
    });

    // Get Attribute Price on ProductDetails
    $("#getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: '/get-product-price',
            data:{size:size,product_id:product_id},
            type: 'post',
            success:function (resp) {
                // alert(resp)
                $(".getAttrPrice").html("Rp."+resp);
            }, error:function () {
                alert("Error")
            }
        })
    })
})