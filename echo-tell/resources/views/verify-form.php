<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Enter Verification Code</h3>
                    <div class="mb-3">
                        <label for="verification_code" class="form-label">Verification Code</label>
                        <input 
                            type="text" 
                            name="verification_code" 
                            id="verification_code" 
                            class="form-control @error('verification_code') is-invalid @enderror" 
                            placeholder="Enter the code sent to your email" 
                            required
                        >
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
