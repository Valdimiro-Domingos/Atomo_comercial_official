@if (session()->has('alert_error'))
    <script>
        toastr.error("{{ session('alert_error') }}", "Erro!")
    </script>
@endif
@if (session()->has('alert_success'))
    <script>
        toastr.success("{{ session('alert_success') }}", "Successo!")
    </script>
@endif
@if (session()->has('alert_warning'))
    <script>
        toastr.warning("{{ session('alert_warning') }}", "Aviso!")
    </script>
@endif
@if (session()->has('alert_info'))
    <script>
        toastr.info("{{ session('alert_info') }}", "Informação!")
    </script>
@endif

@foreach ($errors->all() as $message)
    <script>
        toastr.error("{{ $message }}", "Erro!")
    </script>
@endforeach
