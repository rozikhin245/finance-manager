@if (Session::has('success'))
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif




@if ($errors->any())
    <script>
        Swal.fire({
            title: 'Terjadi Kesalahan!',
            html: `
                <ul style="text-align: left;">
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            `,
            icon: 'error',
        });
    </script>
@endif