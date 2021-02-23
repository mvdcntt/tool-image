let CSRF = $('meta[name="csrf-token"]').attr('content');
let uploadImages = [];
let uploadIndex = 0;
let ALLOW_MIME = ['image/png'];
function selectFolder(element) {
    clearInput();

    let input = $(element)
        .closest('#app')
        .find('#dirLoader');
    input.click();
    input
        .unbind()
        .on('change', async function (e) {
            let files = e.target.files;
            await Array.prototype.forEach.call(files, function (file) {
                let mimeType = file.type;
                let fileName = file.name.split('.').shift();
                if (ALLOW_MIME.indexOf(mimeType) !== -1) {
                    uploadImages.push(file);
                }
            });

            if (!uploadImages.length) {
                let input = $('#dirLoader');
                input
                    .closest('.form-group')
                    .find('.form-text')
                    .empty()
                    .text('No png images was found in folder!');

                return;
            }
            let file = uploadImages[uploadIndex];

            processUploadSingleFile(file);
    })
}

function processUploadSingleFile(file) {
    $('#loading').show();
    if (typeof file != "undefined") {
        let direction = $('[name="direction"]:checked').val();
        let data = new FormData();
        data.append('image', file);
        data.append('_token', CSRF);
        data.append('direction', direction);

        $.ajax({
            type: 'post',
            url: '/tool-image',
            data: data,
            processData: false,
            contentType: false,
            success: function (res) {
                $('#loading').hide();
                uploadIndex ++;
                let file = uploadImages[uploadIndex];
                processUploadSingleFile(file);
            }, error: function (xhr, statusText, errorThrown) {
                $('#loading').hide();
            }
        });
    } else {
        $('#loading').hide();
    }

}

function clearInput() {
    let input = $('#dirLoader');
    input.val('');
    input
        .closest('.form-group')
        .find('.form-text')
        .empty();
}
