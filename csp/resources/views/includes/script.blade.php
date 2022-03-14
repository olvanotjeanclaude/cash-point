<script src="{{ asset('js/vendors.js') }}"></script>
<script src="{{asset("js/index.js")}}"></script>

@if (session('error'))
    <script>
        Swal.fire({
            title: "Hatta!",
            text: "{{ session('error') }}",
            icon: "error",
            button: "Tamam",
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            title: "başarıyla kaydedildi!",
            text: "{{ session('success') }}",
            icon: "success",
            button: "Tamam",
        });
    </script>
@endif
