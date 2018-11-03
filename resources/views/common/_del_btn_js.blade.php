<script>
    $('.del_btn').click( function(){
        var btn=$(this);
        var url=$(this).data('href');
        if( confirm ('删除后不能恢复,你确定要删除吗?')){
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    _token: "{{ csrf_token()}}"
                },
                success: function (msg){
                    if (msg == 'success'){
                        alert('删除成功');
                        btn.closest('tr').remove();
                    }else{
                        alert('删除失败' + msg);
                    }
                }
            });
        }
    });
</script>