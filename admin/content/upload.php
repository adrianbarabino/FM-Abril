<div id="uploader">
    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
</div>
 
<script type="text/javascript">
function file_append (id, filename, url) {
	var append = '<li class="plupload_file ui-state-default plupload_delete" id="'+id+'" style="width:100px;"><div class="plupload_file_thumb" style="width:100px;height:60px;"><img src="'+url+'" width="100" height="60" id="uid_194radfonmkr1dh519t9166il2gc_canvas"></img></div><div class="plupload_file_status"><div class="plupload_file_progress ui-widget-header" style="width: 0%"> </div><span class="plupload_file_percent"> </span></div><div class="plupload_file_name" title="'+filename+'"><span class="plupload_file_name_wrapper">'+filename+' </span></div><div class="plupload_file_action"><div class="plupload_action_icon ui-icon ui-icon-circle-minus"> </div></div><div class="plupload_file_size">43 kb </div><div class="plupload_file_fields"> </div><span class="upload_url">URL del Archivo: <a href="'+url+'" target="_blank">'+url+'</a></span></li>';
	return append;
}

// Initialize the widget when the DOM is ready
$(function() {
    $("#uploader").plupload({

    init: {
    			PostInit: function (argument) {
    				$(".plupload_filelist_content").append(file_append('123', 'logo.png', 'http://dev.fmabril.net/uploads/image/logo.png'));
    			},
                FilesAdded: function (up, files) {

                },
                FileUploaded: function (up, file, response) {
                		filetype = file.type.split("/")[0];
                		upload_dir = "http://"+document.location.hostname+"/uploads/"+filetype+"/"+file.name;
                		$("#"+file.id).append("<span class='upload_url'>URL del Archivo: <a href='"+upload_dir+"' target='_blank'>"+upload_dir+"</a></span>");
					    console.log(file);                },
                UploadComplete: function (up, files) {



                }
            },
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : "./upload.php",
 
        // Maximum file size
        max_file_size : '2mb',
 
        chunk_size: '1mb',
 
        // Resize images on clientside if we can
        resize : {
            height : 600,
            quality : 90,
            crop: false // crop to exact dimensions
        },
 
        // Specify what files to browse for
        filters : [
            {title : "Image files", extensions : "jpg,gif,png"},
            {title : "Zip files", extensions : "zip,avi"}
        ],
 
        // Rename files by clicking on their titles
        rename: true,
         
        // Sort files
        sortable: true,
 
        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,
 
        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },
 
        // Flash settings
        flash_swf_url : './js/plupload/Moxie.swf',
     
        // Silverlight settings
        silverlight_xap_url : './js/plupload/Moxie.xap'
    });
});
</script>