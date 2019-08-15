<div>{{$website}}</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<a href="{{url('loginout')}} ">退出</a>
<input type="text" id="name"><input id="pwd" type="text"><input type="submit" id="submit">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $("#submit").click(function() {
        var name = $('#name').val()
        var pwd = $('#pwd').val()
        $.ajax({
            url: "<?php echo url('add');?>",
            data:{
                '_token': $('meta[name=csrf-token]').attr("content"),
                name:name,
                pwd:pwd
            },
            type: "post",
            dataType: "json",
            success: function (result) {
                if (result.status=='ok'){
                    $('#span').html(result.data);
                    location.href='<?php echo url("index") ?>'
                }else{
                    $('#span').html(result.data);
                }

            }
        })
    })
</script>