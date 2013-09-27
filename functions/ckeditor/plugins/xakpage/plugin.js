// Register a plugin named "xakpage".
(function()
{
    CKEDITOR.plugins.add( 'xakpage',
    {
        init : function( editor )
        {
            // Register the command.
            editor.addCommand( 'xakpage',{
                exec : function( editor )
                {
                    // Create the element that represents a print break.
                   
                    editor.insertHtml("#p#副标题#e#");
                }
            });
            // alert('xakpage!');
            // Register the toolbar button.
            editor.ui.addButton( 'MyPage',
            {
                label : '插入分页符',
                command : 'xakpage',
                icon: 'images/page.gif'
            });
            // alert(editor.name);
        },
        requires : [ 'fakeobjects' ]
    });
})();
