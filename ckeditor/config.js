CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
	];

	config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,About,Sourcedialog,CreatePlaceholder,Source';

	config.removeDialogTabs = 'link:advanced';

	config.extraPlugins = 'image2,widget,lineutils,clipboard,dialog,dialogui,notification,notificationaggregator,widgetselection,panelbutton,floatpanel,panel,button,openlink,link,fakeobjects,contextmenu,menu,autolink,toolbar,textmatch,textwatcher,ajax,xml,tableselection,tabletools,balloontoolbar,balloonpanel,table,emoji,enterkey,contextmenu,colorbutton,richcombo,listblock,font,richcombo,codesnippet,imageresizerowandcolumn,autoembed,undo,sourcedialog,sourcearea,imagebase,filetools,placeholder,divarea,autocomplete';
	
	config.mathJaxLib = '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
	
	config.codeSnippet_theme = 'default';
};
