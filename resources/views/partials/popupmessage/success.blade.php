<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ url('assets/css/success.css') }}">
</head>
<body>
    <div class="popup center absolute top-2/4 left-2/4 text-center box-border">
        <div class="icon inline-block">
            <i class="bi bi-check2"></i>
        </div>
        <div class="title">
            Success!!
        </div>
        <div class="description">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, eius.
        </div>
        <div class="dismiss-btn">
            <button id="dismiss-popup-btn" class="mt-4">
                Dismiss
            </button>
        </div>
    </div>
    
    <div class="center absolute top-2/4 left-2/4">
        <button id="open-popup-btn">
            Open Popup
        </button>
    </div>
    
    <script src="{{ url('assets/js/messagePop.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>


