CKEDITOR.plugins.add('dnimage', {
    icons: 'dnimage',
    init: function (editor) {
        editor.addCommand('dnimage', {
            exec: function (editor)
            {
                a = $("<input type='file'/ >");
                a.change(function (e)
                {
                    file = e.target.files[0];
                    if (!file || !file.type.match(/image.*/))
                    {
                        console.log("File type is not allow to upload");
                        return;
                    }
                    if (file.size > 3 * 1024 * 1024)
                    {
                        console.log("File length is over to upload");
                        return;
                    }
                    reader = new FileReader();
                    reader.onload = function (f)
                    {
                        curr = CKEDITOR.currentInstance;
                        $.ajax(
                                {
                                    url: "ckeditor/imageUpload",
                                    type: "post",
                                    datetype: "json",
                                    beforeSend: function ()
                                    {
                                        //do some thing
                                        loaderElem = new CKEDITOR.dom.element('loader-elem');
                                        loaderHtmlStr = '<div style="position: relative; z-index: 100;text-align: center;background: white;opacity: 0.75;pointer-events:none">' + '<div style="width: 100%;padding:0.5em 0px">Please wait while image is uploading...</div>' + '</div>';
                                        loaderDomEle = CKEDITOR.dom.element.createFromHtml(loaderHtmlStr);
                                        loaderElem.append(loaderDomEle);
                                        editor.insertElement(loaderElem);
                                        CKEDITOR.currentInstance.setReadOnly(true);

                                    },
                                    data:
                                            {
                                                filedata: f.target.result,
                                                filename: file.name
                                            },
                                    success: function (result)
                                    {
                                        CKEDITOR.instances[curr.name].setReadOnly(false);
                                        imgElem = '<img src="' + result + '" style="max-width:100%">';
                                        imgDomElem = CKEDITOR.dom.element.createFromHtml(imgElem);
                                        editor.insertElement(imgDomElem);
                                        loaderElem.remove();
                                    },
                                    error: function ()
                                    {
                                        //do some thing
                                        console.log("error");
                                        CKEDITOR.instances[curr.name].setReadOnly(false);
                                        loaderElem.remove();
                                    }
                                });
                    };
                    reader.readAsDataURL(file);
                });
                a.click();
            }
        });
        editor.ui.addButton('DnImage', {
            label: 'Image Uploader',
            command: 'dnimage',
            toolbar: 'insert'
        });
    }
});
