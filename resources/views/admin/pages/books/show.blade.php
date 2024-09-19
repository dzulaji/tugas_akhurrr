@extends('admin.layouts.main')

@section('main-content')
    <div class="container mt-4" style="margin-bottom: 6rem">
        {{-- breadcrumb --}}
        <nav class="my-4" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/books" class="text-decoration-none">Koleksi Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Title</li>
            </ol>
        </nav>

        {{-- card --}}
        <div class="row">

            <!-- Cover Image -->
            <div class="col-md-3">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @if ($book->cover)
                            <img class="card-img-top" src="{{ asset('storage/' . $book->cover) }}" alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('img/bookCoverDefault.png') }}" alt="Card image cap">
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
                                <td class="fw-medium" style="width: 150px;">Judul</td>
                                <td>: {{ $book->title }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Kode</td>
                                <td>: {{ $book->code }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Kategori</td>
                                <td>: {{ $book->category->name }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Penerbit</td>
                                <td>: {{ $book->publisher }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Tahun</td>
                                <td>: {{ $book->year }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Penulis</td>
                                <td>: {{ $book->author }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Jumlah Halaman</td>
                                <td>: {{ $book->pages }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Bahasa</td>
                                <td>: {{ $book->language }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">ISBN/ISSN</td>
                                <td>: {{ $book->isbn_issn }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Tipe Isi</td>
                                <td>: {{ $book->content_type }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Tipe Media</td>
                                <td>: {{ $book->media_type }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Tipe Pembawa</td>
                                <td>: {{ $book->carrier_type }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Edisi</td>
                                <td>: {{ $book->edition }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Subjek</td>
                                <td>: {{ $book->subject }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Stock</td>
                                <td>: {{ $book->stock }}</td>
                            </tr>
                            <tr class="d-flex gap-4">
                                <td class="fw-medium" style="width: 150px;">Deskripsi</td>
                                <td>: {{ $book->description }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- proses --}}
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 fw-bold">Aksi</h6>
                    </div>
                    <div class="card-body d-flex align-items-start gap-2">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $book->id }}"><i class="bi bi-pencil-square"></i>
                            Edit</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $book->id }})"><i
                                class="bi bi-x-circle"></i> Delete</button>
                        <form id="delete-form-{{ $book->id }}" action="/admin/books/{{ $book->id }}"
                            method="post" style="display: none;">
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

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $book->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/books/{{ $book->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <small>(minimal 3 karakter)</small></label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $book->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode <small>(minimal 5 karakter)</small></label>
                        <input type="text" class="form-control" id="code" name="code"
                            value="{{ $book->code }}">
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover Buku</label>
                        <input class="form-control" type="file" id="cover" name="cover">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category_id">
                            @foreach ($categories as $category)
                                @if ($category->name === $book->category->name)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="publisher" name="publisher"
                            value="{{ $book->publisher }}">
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="year" name="year"
                            value="{{ $book->year }}">
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author"
                            value="{{ $book->author }}">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            value="{{ $book->stock }}">
                    </div>
                    <div class="mb-3">
                        <label for="description">Deskripsi <small>(minimal 10 karakter)</small></label>
                        <textarea class="form-control" id="description" name="description">{{ $book->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>
