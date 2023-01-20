var DropzoneDemo = {
    init: function () {
        (Dropzone.options.mDropzoneOne = {
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 5,
            addRemoveLinks: !0,
            accept: function (e, o) {
                "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o();
            },
            headers: {
                "x-csrf-token": document.head.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            init: function () {
                this.on('success', function (file, resp) {
                    // console.log(file);
                    // console.log(resp);
                    // console.log(resp.message);
                    toastr.success(resp.message, "Berhasil");
                    $('.datatable').dataTable().fnDraw(false);
                });
                this.on('error', function (e, resp) {
                    // console.log('erors and stuff');
                    // console.log(e);
                    // console.log(resp);
                    let message = resp.message === undefined ? resp : resp.message;
                    console.log(message);
                    toastr.error(message, "GAGAL");
                });
            },
        }),
            (Dropzone.options.mDropzoneTwo = {
                paramName: "file",
                maxFiles: 10,
                maxFilesize: 10,
                addRemoveLinks: !0,
                accept: function (e, o) {
                    "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o();
                },
                headers: {
                    "x-csrf-token": document.head.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            }),
            (Dropzone.options.mDropzoneThree = {
                paramName: "file",
                maxFiles: 10,
                maxFilesize: 10,
                addRemoveLinks: !0,
                acceptedFiles: "image/*,application/pdf,.psd",
                accept: function (e, o) {
                    "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o();
                },
                headers: {
                    "x-csrf-token": document.head.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });
    },

};
DropzoneDemo.init();
