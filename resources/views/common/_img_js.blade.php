<script>
    function test(){
        var $file = document.getElementById('file');
        $file.click();
    }
    function preview(obj) {
        //获取input上传的图片数据
        var file = obj.files[0];
        //得到bolb对象路径,可当成普通的文件路径一样使用,复制给src;
        url = window.URL.createObjectURL(file);
        //预览
        var face = document.getElementById('face');
        face.src = url;
    }
</script>