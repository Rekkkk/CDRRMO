@auth
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="shortcut icon" href="{{ asset('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            <header class="header-section h-20 w-full bg-slate-50">
                <div class="container-fluid bg-red-900 relative w-full h-full">
                    <div class="w-full h-full relative">
                        <img class="w-22 float-right h-full" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="float-right h-full text-xl text-white py-2.5">Cabuyao City Disaster Risk<br>Reduction and Management Office</span>
                    </div>
                </div>
            </header>
            <div class="page-wrap">
                <div class="sidebar drop-shadow-2xl fixed left-0 top-0 h-full w-20">
                    <div class="sidebar-heading flex justify-center items-center cursor-pointer text-white ">
                        <span class="links_name">E-LIGTAS</span>
                        <i class="bi bi-list absolute text-white text-center cursor-pointer text-3xl" id="btn-sidebar"></i>
                    </div>
                    <div class="h-full items-center text-center">
                        <x-nav-item />
                    </div>
                </div>
            </div>

            <x-messages />

            <div class="main-content">
                <div class="content-item rounded-t-lg w-full">
                    <div class="content-header text-center text-white rounded-t-lg">
                        <div class="text-2xl p-2 w-full h-full">
                            <span class="text-xl">Update Annoucement Post</span><br>
                            <span class="text-xl">{{ $announcements->created_at}}</span><br>
                        </div>
                    </div>
                    <div class="pt-2 bg-white rounded-b-lg p-3">
                        <form action="{{ route('CUpdateAnnouncement', ['announcement_id' => $announcements->announcement_id]) }}" method="POST">
                            @method('GET')
                            @csrf
                            <div class="modal-body">
                                <div class="mb-6 pt-3">
                                    <label class="pb-2">Caption</label>
                                    <input type="text" name="announcement_description" class="form-control" placeholder="Caption Here..." value="{{ $announcements->announcement_description}}"><br>
                                </div>

                                <div class="mb-6">
                                    <label class="pb-2">Announcement</label>
                                    <textarea class="form-control" name="announcement_content" rows="4"  placeholder="Content Here...">{{ $announcements->announcement_content }}</textarea>
                                </div>
                                <div class="mb-6">
                                    <i class="bi bi-camera-reels text-lime-600"></i>
                                    <label>Video: </label>
                                    <input type="file" name="announcement_video"><br>
                                </div>
                                <div class="mb-6">
                                    <i class="bi bi-images text-lime-600"></i>
                                    <label>Image: </label>
                                    <input type="file" name="announcement_image"><br>
                                </div>
                            </div>
                            <div class="items-center justify-center">
                                <a href="{{ route('Cdashboard') }}"> 
                                    <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200 mr-2">Cancel</button>
                                </a>
                                <button type="submit" class="bg-green-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" >Post Announcement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
       
    </body>
</html>
@endauth