<div id="uploader">
    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
</div>
 
<script type="text/javascript">
// Initialize the widget when the DOM is ready
$(function() {
    $("#uploader").plupload({

    init: {
                FilesAdded: function (up, files) {

                },
                FileUploaded: function (up, file, response) {

                },
                UploadComplete: function (up, files) {


                	files.forEach(function(entry) {
                		filetype = entry.type.split("/")[0];
                		upload_dir = "http://"+document.location.hostname+"/uploads/"+filetype+"/"+entry.name;
                		$("#"+entry.id).append("<span class='upload_url'>URL del Archivo: <a href='"+upload_dir+"' target='_blank'>"+upload_dir+"</a></span>");
					    console.log(entry);
					});

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