@extends('admin.layouts.main')

@section('main-content')
    <div class="container mt-4" style="margin-bottom: 6rem">
        {{-- breadcrumb --}}
        <nav class="my-4" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/users" class="text-decoration-none">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a id="name">{{ $user->name }}</a></li>
            </ol>
        </nav>

        {{-- card --}}
        <div class="row">

            <!-- Cover Image -->
            <div class="col-md-3">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @if ($user->photo)
                            <!-- Menampilkan foto pengguna jika ada -->
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" class="img-fluid">
                        @else
                            <!-- Menampilkan gambar default jika tidak ada foto pengguna -->
                            <img src="{{ asset('template/img/undraw_profile.svg') }}" alt="Default Photo" class="img-fluid">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Information -->
            <div class="col-md-9">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 fw-bold">Detail Buku</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 100px;">Nama</td>
                                <td>: {{ $user->name }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 100px;">NIS/NIP</td>
                                <td>: {{ $user->nis_nip }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 100px;">Email</td>
                                <td>: {{ $user->email }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- proses --}}
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 fw-bold">Aksi</h6>
                    </div>
                    <div class="card-body d-flex align-items-start gap-2">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $user->id }}"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $user->id }})"><i
                                class="bi bi-x-circle"></i> Delete</button>
                        <form id="delete-form-{{ $user->id }}" action="/admin/users/{{ $user->id }}" method="post"
                            style="display: none;">
                            @csrf
                            @method('delete')
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert for delete confirmation
        function confirmDelete(bookId) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + bookId).submit();
                }
            });
        }

        // Check if there are any success or error messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Ok'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'Ok'
            });
        @endif
    </script>
@endsection
