<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .error {
            color: #dc3545;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .user-data {
            margin-top: 20px;
        }
        .user-data h3 {
            color: #007bff;
            margin-bottom: 10px;
        }
        .user-data p {
            margin: 0;
            padding: 5px 0;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Details</h1>

        <!-- Display error message if available -->
        @if (isset($error))
            <div class="error">
                <strong>Error:</strong> {{ $error }}
            </div>
        @else
            <!-- Display user data -->
            @if (isset($data))
                <div class="user-data">
                    <h3>{{ $data['name'] }}</h3>
                    <p><strong>Email:</strong> {{ $data['email'] }}</p>
                    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
                    <p><strong>Website:</strong> <a href="http://{{ $data['website'] }}" target="_blank">{{ $data['website'] }}</a></p>
                    <p><strong>Address:</strong> 
                        {{ $data['address']['suite'] }}, 
                        {{ $data['address']['street'] }}, 
                        {{ $data['address']['city'] }} - 
                        {{ $data['address']['zipcode'] }}
                    </p>
                    <p><strong>Company:</strong> {{ $data['company']['name'] }}</p>
                </div>
            @else
                <p>No user data available.</p>
            @endif
        @endif
    </div>
</body>
</html>