@extends('layouts.auth')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card hvr-float-shadow">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logokailila.png') }}" alt="Company Logo" class="logo">
                </div>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="fullname" placeholder="Full Name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="date" class="form-control" name="birthdate" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="/login">Login</a></p>
            </div>
        </div>
    </div>
@endsection