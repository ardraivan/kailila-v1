@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Coming Soon</li>
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="jumbotron text-center" style="background-color: #F7F7F7;">
                    <h1 class="display-4">Coming Soon!</h1>
                    <p class="lead">We are working on this page and it will be available soon.</p>
                    <hr class="my-4">
                    <p>Meanwhile, here's a sneak peek of what's to come:</p>
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card text-center" style="border-color: #C01E5E; height: 100%;">
                                <div class="card-body">
                                    <i class="fas fa-users fa-4x text-muted"></i>
                                    <p class="card-text" style="font-weight: bold; margin-top: 10px;">Manage therapist data
                                        and sessions to provide top-notch care for
                                        your clients.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card text-center" style="border-color: #C01E5E; height: 100%;">
                                <div class="card-body">
                                    <i class="fas fa-user-friends fa-4x text-muted"></i>
                                    <p class="card-text" style="font-weight: bold; margin-top: 10px;">Manage client data and
                                        track progress to ensure the best outcomes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
