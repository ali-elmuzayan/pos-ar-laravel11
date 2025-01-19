var product=[];

$(function() {
    $('#txtbarcode_id').on('change', function() {
        var barcode = $('#txtbarcode_id').val();
        var url = productRoute.replace(':code', barcode);

        $.ajax({
            url:url,
            method: "get",
            dataType: "json",
            data: {id:barcode},
            success:function(data){
                console.log(data)
            },
            error:function(url) {
                alert(url)
            }
        })
    })
})

