@extends('layouts.empty')

@section('main-content')
    <section class="text-center pb-5">
        <!-- Background image -->
        <div class="p-5 bg-image"
            style="
        background-image: url('https://images.unsplash.com/photo-1579792727435-27b17f6ae234?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
        height: 300px;
        ">
        </div>
        <!-- Background image -->


        <div class="card mx-4 mx-md-5 shadow-5-strong"
            style="
        margin-top: -100px;
        background: hsla(0, 0%, 100%, 0.7);
        backdrop-filter: blur(30px);
        ">
            <div class="card-body py-5 px-md-5">

                <a href="/" class="text-decoration-none text-white position-absolute top-0 start-0 m-3">
                    <h2><i class="bi bi-arrow-left-circle text-dark"></i></h2>
                </a>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-5">Register Now</h2>
                        <form action='/register' method='post' enctype="multipart/form-data">
                            @csrf
                            <!-- 2 column grid layout with text inputs for the first and last names -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="floatingInput" placeholder="example" name="name"
                                            value="{{ old('name') }}">
                                        <label for="floatingInput">Name</label>
                                        @error('name')
                                            <div class="invalid-feedback text-start">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="floatingInput" placeholder="example" name="username"
                                            value="{{ old('username') }}">
                                        <label for="floatingInput">Username</label>
                                        @error('username')
                                            <div class="invalid-feedback text-start">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- NIS / NIP input -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('nis_nip') is-invalid @enderror"
                                    id="floatingInput" placeholder="example" name="nis_nip" value="{{ old('nis_nip') }}">
                                <label for="floatingInput">NIS / NIP</label>
                                @error('nis_nip')
                                    <div class="invalid-feedback text-start">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email input -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="floatingInput" placeholder="example" name="email" value="{{ old('email') }}">
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback text-start">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password input -->
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="floatingInput" placeholder="example" name="password">
                                <label for="floatingInput">Password</label>
                                @error('password')
                                    <div class="invalid-feedback text-start">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Photo input -->
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    id="floatingInput" name="photo">
                                <label for="floatingInput">Profile Photo</label>
                                @error('photo')
                                    <div class="invalid-feedback text-start">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                Register
                            </button>

                            <p>already register? <a href="/login">sign in now!</a></p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
