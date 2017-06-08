/**
 * Created by Administrator on 2017/5/26 0026.
 */
$(function() {
    $("#file_upload").uploadify({
        'swf'             : SCOPE.uploadify_swf,
        'uploader'        : SCOPE.image_upload,
        'buttonText'      : '图片上传',
        'fileTypeDesc'    : 'Image Files',
        'fileObjName'     : 'file',
        'fileTypeExts'    : '*.gif; *.jpg; *.png',
        'onUploadSuccess' : function(file, data, response) {
            /*console.log(file);
            console.log(data);
            console.log(response);*/
            if(response){
                var obj=JSON.parse(data);
                $('#upload_org_code_img').attr('src',obj.data);
                $('#file_upload_image').attr('value',obj.data);
                $('#upload_org_code_img').show();
            }
        }
    });

    $("#file_upload_other").uploadify({
        'swf'             : SCOPE.uploadify_swf,
        'uploader'        : SCOPE.image_upload,
        'buttonText'      : '图片上传',
        'fileTypeDesc'    : 'Image Files',
        'fileObjName'     : 'file',
        'fileTypeExts'    : '*.gif; *.jpg; *.png',
        'onUploadSuccess' : function(file, data, response) {
            /*console.log(file);
            console.log(data);
            console.log(response);*/
            if(response){
                var obj=JSON.parse(data);
                $('#upload_org_code_img_other').attr('src',obj.data);
                $('#file_upload_image_other').attr('value',obj.data);
                $('#upload_org_code_img_other').show();
            }
        }
    });
});