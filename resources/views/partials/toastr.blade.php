<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-left",
            "progressBar": true,
            "closeButton": true,
            "preventDuplicates": true
        }

        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}", 'Success!');
        @endif

        @if (Session::has('error'))
            toastr.warning("{{ Session::get('error') }}", 'Error!');
        @endif
    })
</script>
