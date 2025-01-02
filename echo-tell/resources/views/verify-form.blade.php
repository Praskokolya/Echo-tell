<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6c63ff, #5a67d8);
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 1rem;
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.5);
        }

        .btn-custom {
            background: linear-gradient(135deg, #6c63ff, #5a67d8);
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            padding: 12px;
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #5a67d8, #434db4);
            box-shadow: 0 4px 15px rgba(90, 103, 216, 0.4);
        }

        .alert {
            border-radius: 10px;
        }

        .redirect-link {
            text-align: center;
            margin-top: 20px;
        }

        .redirect-link a {
            color: #6c63ff;
            font-weight: 600;
            text-decoration: none;
        }

        .redirect-link a:hover {
            text-decoration: underline;
        }

        .redirect-link .fa-arrow-left {
            margin-left: 5px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(1);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <h2 class="title">Verify Your Email</h2>
        <p class="subtitle">Please enter the code sent to {{ session('user_array')['email'] }}.</p>

        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{route('pass.code')}}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="code" class="form-label">Verification Code</label>
                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                    placeholder="Enter your code" required>
                @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-custom w-100">Verify</button>
        </form>

        <div class="redirect-link">
            <p><a href="{{ route('registration') }}">Back to Registration <i class="fa fa-arrow-left"></i></a></p>
        </div>
    </div>
</body>

</html>
