/*! Image Uploader - v1.0.0 - 15/07/2019*/

(function ($) {
    $.fn.imageUploader = function (options) {
        let defaults = { preloaded: [], imagesInputName: "gallery_images", preloadedInputName: "preloaded", label: "Drag & Drop files here or click to browse" };
        let plugin = this;
        plugin.settings = {};
        plugin.init = function () {
            plugin.settings = $.extend(plugin.settings, defaults, options);
            plugin.each(function (i, wrapper) {
                let $container = createContainer();
                $(wrapper).append($container);
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));
                if (plugin.settings.preloaded.length) {
                    $container.addClass("has-files");
                    let $uploadedContainer = $container.find(".uploaded");
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(createImg(plugin.settings.preloaded[i].src, plugin.settings.preloaded[i].id,1));
                    }
                }
            });
        };
        let dataTransfer = new DataTransfer();
        let createContainer = function () {
            let $container = $("<div>", { class: "image-uploader" }),
                $input = $("<input>", { type: "file", id: plugin.settings.imagesInputName + "-" + random(), name: plugin.settings.imagesInputName + "[]", multiple: "" }).appendTo($container),
                $uploadedContainer = $("<div>", { class: "uploaded" }).appendTo($container),
                $textContainer = $("<div>", { class: "upload-text" }).appendTo($container),
                $i = $("<i>", { class: "flaticon-upload" }).appendTo($textContainer),
                $span = $("<span>", { text: plugin.settings.label }).appendTo($textContainer);
            $container.on("click", function (e) {
                prevent(e);
                $input.trigger("click");
            });
            $input.on("click", function (e) {
                e.stopPropagation();
            });
            $input.on("change", fileSelectHandler.bind($container));
            return $container;
        };
        let prevent = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };
        let createImg = function (src, id,type='') {
            let $container = $("<div>", { class: "uploaded-image" }),
                $img = $("<img>", { src: src }).appendTo($container),
                $button = $("<button>", { class: "delete-image" }).appendTo($container),
                $i = $("<i>", { class: "flaticon-delete" }).appendTo($button);
            if (plugin.settings.preloaded.length) {
                $container.attr("data-preloaded", !0);
                let $preloaded = $("<input>", { type: "hidden", name: plugin.settings.preloadedInputName + "[]", value: id });
                $preloaded.attr("data-delete_url",plugin.settings.preloadedDeleteUrl);
                $preloaded.attr("data-type",type);
                $preloaded.appendTo($container);
                if(type==0)
                {
                  $container.attr("data-index", id);
                 }

            } else {
                $container.attr("data-index", id);
            }
            $container.on("click", function (e) {
                prevent(e);
            });
            $button.on("click", function (e) {
                prevent(e);

                 if (plugin.settings.preloaded.length) 

                 {
                            delete_type=$(this).next('input').data('type');
                            val=$(this).next('input').val();
                            
                            if(delete_type ==1)
                            {
                               
                            url=$(this).next('input').data('delete_url');

                            $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                        url: url,
                        dataType: "json",
                        data: {
                            id : val,
                            
                        },
                            success: function(data) {
                              if(data==1)
                              {
                                toastr.info("Gallery image deleted successfully","Deleted");
                              }
                            
                            }

                        });
                        }

                    if (typeof $(this).parents('div.uploaded-image').data('index')!== 'undefined') 
                    {
                    
              
                    let index = parseInt($(this).parents('div.uploaded-image').data('index'));
                  $(this).parents().find(".uploaded-image[data-index]").each(function (i, cont) {
                        if (i > index)
                         {
                            $(cont).attr("data-index", i - 1);
                        }
                    });
                    dataTransfer.items.remove(index);
                    $input = $(this).parents('div.image-uploader').find('input[type="file"]');
                    //console.log($input);
                    $input.prop("files", dataTransfer.files);

                   
                }

                }


                     
               
                else{

                     

                if ($container.data("index")) {
               
                    let index = parseInt($container.data("index"));
                    $container.find(".uploaded-image[data-index]").each(function (i, cont) {
                        if (i > index) {
                            $(cont).attr("data-index", i - 1);
                        }
                    });
                    dataTransfer.items.remove(index);
                    $input = $(this).parents('div.image-uploader').find('input[type="file"]');
                    //console.log($input);
                    $input.prop("files", dataTransfer.files);

                }




                }



           
                $container.remove();
                if (!$container.find(".uploaded-image").length) {
                    $container.removeClass("has-files");
                }
            });
            return $container;
        };
        let fileDragHover = function (e) {
            prevent(e);
            if (e.type === "dragover") {
                $(this).addClass("drag-over");
            } else {
                $(this).removeClass("drag-over");
            }
        };
        let fileSelectHandler = function (e) {
            prevent(e);
            let $container = $(this);
            $container.removeClass("drag-over");
            let files = e.target.files || e.originalEvent.dataTransfer.files;
            setPreview($container, files);
        };
        let setPreview = function ($container, files) {
            $container.addClass("has-files");
            let $uploadedContainer = $container.find(".uploaded"),
                $input = $container.find('input[type="file"]');
            $(files).each(function (i, file) {
                dataTransfer.items.add(file);
                $uploadedContainer.append(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1,0));
            });
            $input.prop("files", dataTransfer.files);
        };
        let random = function () {
            return Date.now() + Math.floor(Math.random() * 100 + 1);
        };
        this.init();
        return this;
    };
})(jQuery);
