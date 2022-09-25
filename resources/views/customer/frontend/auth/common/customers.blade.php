<script>
    $(function() {
        $('#submit-auth-loading').hide();
        $("#form-auth").submit(function(event) {
            $('#submit-auth').hide();
            $('#submit-auth-loading').show();
        });
    })
</script>