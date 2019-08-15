<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="api-token" content="{{ Auth::check() ? 'Bearer '.JWTAuth::fromUser(Auth::user()) : '' }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<html>
      账号：<input type="text" id="name">
      密码：<input type="text" id="pwd">
      <input type="submit" id="submit">
<span id="span"></span>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $("#submit").click(function() {
        var name = $('#name').val()
        var pwd = $('#pwd').val()
        $.ajax({
        url: "<?php echo url('logindo');?>",
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