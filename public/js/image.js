$(document).ready(function(){
    // clicking on updateImg
    $(document).on('click', '#updateImg', function(e){
        e.preventDefault();

        if(!$('#photo').length){
            $("#oldImg").html('<input type="file" name="logo" id="image" class="form-control showImage" >');
            $('#updateImg').hide();
            $('#cancelUpdateImg').show();

        }
    });

    // clicking on cancelUpdateImg
    $(document).on('click', '#cancelUpdateImg', function(e){
        e.preventDefault();

        if($('#photo').length){
            $("#oldImg").html('');
            $('#updateImg').show();
            $('#cancelUpdateImg').hide();

        }

    });
});
