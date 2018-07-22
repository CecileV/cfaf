
var options = {
	filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
	filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
	filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
	filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
};

$(document).ready(function() {
	$('textarea.ckeditor1').ckeditor(options);
	$('#lfm').filemanager('file');



});


