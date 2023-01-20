<script>
    function formImageSubmit(id_form, btnSubmit, url, modal) {
        $('body').on('submit', id_form, function(e) {
            e.preventDefault();
            $(btnSubmit).addClass('m-loader m-loader--light m-loader--right');
            $(btnSubmit).attr("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $(id_form).trigger("reset");
                    $(modal).modal('hide');
                    $('.datatable').dataTable().fnDraw(false);
                    $(btnSubmit).removeClass('m-loader m-loader--light m-loader--right');
                    $(btnSubmit).attr("disabled", false);
                },
                error: function(data) {
                    const res = data.responseJSON;
                    toastr.error(res.message, "GAGAL");
                    $(btnSubmit).removeClass('m-loader m-loader--light m-loader--right');
                    $(btnSubmit).attr("disabled", false);
                }
            });
        });
    }
</script>
