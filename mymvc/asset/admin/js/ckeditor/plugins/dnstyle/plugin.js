CKEDITOR.plugins.add('dnstyle',
        {
            icons: 'dnstyle',
            init: function (editor)
            {
                editor.addCommand('dnstyle',
                        {
                            exec: function (editor)
                            {
                                //todo something
                                alert(1);
                            }
                        });

                editor.ui.addButton('DnStyle',
                        {
                            label: 'Custom style',
                            command: 'dnstyle',
                            toolbar: 'styles'
                        });
            }
        });
