<script>
    function formSubmit(id_form, btnSubmit, url, modal) {
        $(id_form).on('submit', function(event) {
            event.preventDefault();
            $(btnSubmit).addClass('m-loader m-loader--light m-loader--right');
            $(btnSubmit).attr("disabled", true);
            $.ajax({
                url: url,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
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
