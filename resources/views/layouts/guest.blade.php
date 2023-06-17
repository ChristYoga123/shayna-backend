<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset("auth-assets/modules/bootstrap/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ asset("auth-assets/modules/fontawesome/css/all.min.css") }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset("auth-assets/modules/bootstrap-social/bootstrap-social.css") }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset("auth-assets/css/style.css") }}">
  <link rel="stylesheet" href="{{ asset("auth-assets/css/components.css") }}">
  <script src="{{ asset("sweetalert2/dist/sweetalert2.all.min.js") }}"></script>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ asset("images/logo.png") }}" alt="logo" width="100" class="shadow-light">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ route("admin.login") }}" class="needs-validation">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Masukkan email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Masukkan password
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset("auth-assets/modules/jquery.min.js") }}"></script>
  <script src="{{ asset("auth-assets/modules/popper.js") }}"></script>
  <script src="{{ asset("auth-assets/modules/tooltip.js") }}"></script>
  <script src="{{ asset("auth-assets/modules/bootstrap/js/bootstrap.min.js") }}"></script>
  <script src="{{ asset("auth-assets/modules/nicescroll/jquery.nicescroll.min.js") }}"></script>
  <script src="{{ asset("auth-assets/modules/moment.min.js") }}"></script>
  <script src="{{ asset("auth-assets/js/stisla.js") }}"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ asset("auth-assets/js/scripts.js") }}"></script>
  <script src="{{ asset("auth-assets/js/custom.js") }}"></script>
  @if (session("error"))
  <script>
    Swal.fire(
      "Gagal",
      `{{ session("error") }}`,
      "error"
    );
  </script>  
  @endif
</body>
</html>