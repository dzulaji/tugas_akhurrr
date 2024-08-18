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
                            data-bs-target="#modalEdit{{ $user->id }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>

                        <!-- Check if the current user is not the user being displayed -->
                        @if (auth()->user()->id !== $user->id)
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $user->id }})">
                                <i class="bi bi-x-circle"></i> Delete
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="/admin/users/{{ $user->id }}"
                                method="post" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                        @endif
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

<!-- Modal Edit Pengguna -->
<div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/users/{{ $user->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <small>(minimal 3 karakter)</small></label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username <small>(minimal 5 karakter)</small></label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ $user->username }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="nis_nip" class="form-label">NIS/NIP <small>(minimal 10 karakter)</small></label>
                        <input type="text" class="form-control" id="nis_nip" name="nis_nip"
                            value="{{ $user->nis_nip }}">
                    </div>
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="old_password" name="old_password">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru <small>(minimal 5
                                karakter)</small></label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Pengguna</label>
                        <input class="form-control" type="file" id="photo" name="photo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
