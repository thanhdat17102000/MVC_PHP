CKEDITOR.editorConfig = function( config ) {
    config.baseHref = $("base").attr("href");
    config.baseUrl = $("base").attr("href");
	config.skin = 'office2013';
    config.extraPlugins = 'sourcedialog,dnimage,youtube,showblocks,colorbutton,colordialog,';
    config.extraPlugins += 'font,format,justify,blockquote,indentblock,fontawesome,table,removeformat,chart,find,magicline,';
    config.extraPlugins += 'codesnippet,dnstyle';
    config.height=450;
    config.allowedContent=true;
    
    
    config.embed_provider="ckeditor/embed_provider?resource-url={url}&callback={callback}";
    
    config.fontAwesome_version = '4.6';
    config.fontAwesome_html_tag = 'i';
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    CKEDITOR.dtd.$removeEmpty['ins'] = false;
    CKEDITOR.dtd.$removeEmpty['i'] = false;
    config.fontAwesome_unicode = false;
    
    
};
