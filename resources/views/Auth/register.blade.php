@extends('layout')

@section('content')

<section class="h-100 h-custom" style="background-color: #8fc4b7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-8 col-xl-6">
        <div class="card rounded-3">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img3.webp"
            class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem;"
            alt="Sample photo">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">Registration Info</h3>

            <form class="px-md-2" method="POST" action="{{ route('register')}}">
                @csrf
                @if($errors->has('error'))
                  <div class="alert alert-danger">
                      {{ $errors->first('error') }}
                  </div>
                @endif

                <!-- Name Input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="form3Example1q" name="name" class="form-control" value="{{ old('name') }}" />
                  <label class="form-label" for="form3Example1q">Name</label>

                  <!-- Error Display -->
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <!-- Email Input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" id="form3Example1e" name="email" class="form-control" value="{{ old('email') }}" />
                  <label class="form-label" for="form3Example1e">Email</label>

                  <!-- Error Display -->
                  @error('email')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <!-- Password Input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="form3Example1p" name="password" class="form-control" />
                  <label class="form-label" for="form3Example1p">Password</label>

                  <!-- Error Display -->
                  @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="form3Example1p" name="password_confirmation" class="form-control" />
                  <label class="form-label" for="form3Example1p">Password_confirmation</label>

                  <!-- Error Display -->
                  @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg mb-1">Submit</button>
              
                <p class="mt-3 text-center">
                  Already have an account?
                  <a href="/login" class="text-success">Login here</a>
                </p>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
