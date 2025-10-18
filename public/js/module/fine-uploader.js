$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var galleryUploader = new qq.FineUploader({
    element: document.getElementById("fine-uploader-gallery-product"),
    template: 'qq-template-gallery',
    request: {
        endpoint: "/jmarkt-admin/product/multiple-other-image-uploader",
        params: {
          uuid: $('#uuid').val()
        },
    },
    multiple: true,
    thumbnails: {
        placeholders: {
            waitingPath: "{{ asset('js/fine-uploader/placeholders/waiting-generic.png') }}",
            notAvailablePath: "{{ asset('js/fine-uploader/placeholders/not_available-generic.png') }}"
        }
    },
    validation: {
        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png','pdf'],
        itemLimit: 10,
        sizeLimit: 5217152,
    },
    deleteFile: {
        enabled: true,
        method: "POST",
        forceConfirm: true,
        endpoint: "{{route('admin.removeFile')}}",
        customHeaders: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    text: {
        uploadButton: 'Click or Drop for upload images',
        waitingForResponse: 'Processing...',
        retryButton: 'Retry',
        cancelButton: 'Cancel',
        failUpload: 'Upload failed',
        deleteButton: 'Delete',
        deletingStatusText: 'Deleting...',
        formatProgress: '{percent}% of {total_size}'
    },
    debug: true,
    callbacks: {
        onComplete:function(id, fileName, responseJSON){
            if (responseJSON.success) {
                var li = $('.qq-upload-list li')[id];
                $(li).append('<input type="hidden" id="product_additional_images" name="product_additional_images[]" value="'+responseJSON.name+'"></input>');
                $('#product_additional_images_error').text('');
            }
        },
        onDelete: function(id, responseJSON) {
        
        },
    },
});

var galleryUploader = new qq.FineUploader({
    element: document.getElementById("fine-uploader-gallery-main"),
    template: 'qq-template-gallery',
    request: {
        endpoint: "/jmarkt-admin/product/multiple-other-image-uploader",
        params: {
           uuid: $('#uuid').val()
        },
    },
    multiple: true,
    thumbnails: {
        placeholders: {
            waitingPath: "{{asset('js/fine-uploader/placeholders/waiting-generic.png')}}",
            notAvailablePath: "{{asset('js/fine-uploader/placeholders/not_available-generic.png')}}"
        }
    },
    validation: {
        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png','pdf'],
        itemLimit: 10,
        sizeLimit: 5217152,
    },
    deleteFile: {
        enabled: true,
        method: "POST",
        forceConfirm: true,
        endpoint: "{{route('admin.removeFile')}}",
        customHeaders: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    text: {
        uploadButton: 'Click or Drop for upload images',
        waitingForResponse: 'Processing...',
        retryButton: 'Retry',
        cancelButton: 'Cancel',
        failUpload: 'Upload failed',
        deleteButton: 'Delete',
        deletingStatusText: 'Deleting...',
        formatProgress: '{percent}% of {total_size}'
    },
    debug: true,
    callbacks: {
        onComplete:function(id, fileName, responseJSON){
            if (responseJSON.success) {
                var li = $('.qq-upload-list li')[id];
                $(li).append('<input type="hidden" id="main_v_product_additional_images" name="main_v_product_additional_images[]" value="'+responseJSON.name+'"></input>');
                $('#main_v_product_additional_images_error').text('');
            }
        },
        onDelete: function(id, responseJSON) {
         
        },
    },
});