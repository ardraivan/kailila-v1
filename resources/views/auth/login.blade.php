@extends('layouts.auth')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card hvr-float-shadow">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logokailila.png') }}" alt="Company Logo" class="logo">
                </div>
                @if (session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    <!-- Tambahkan method POST dan action -->
                    @csrf
                    <!-- Tambahkan CSRF token -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <span class="input-group-text align-items-center" style="height: 38px;">
                                <button type="button" class="btn btn-link p-0 m-0" id="togglePassword">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <style>
        .input-group-text .btn {
            padding: 0;
            height: 100%;
        }

        .input-group-text .btn:focus,
        .input-group-text .btn:active {
            box-shadow: none;
        }
    </style>
@endsection

@section('scripts')
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementsByName('password')[0];

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Ubah ikon mata sesuai dengan tipe password
            togglePassword.innerHTML = type === 'password' ? '<i class="fa fa-eye"></i>' :
                '<i class="fa fa-eye-slash"></i>';
        });
    </script>
@endsection
