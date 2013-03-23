CKEDITOR.dialog.add('grafikart', function(editor)
{
console.log(editor);
	return {
		title : 'Insérer un medium',
		minWidth : 1000,
		minHeight : 500,
 
		contents :
		[
			{
				id : 'iframe',
				label : '',
				expand : true,
				elements :
				[ {
					type   : 'iframe',
					width  : '100%',
					height : '500px',
					src    : editor.config.grafikartPath,
				} ]
			},
		]
	};
});