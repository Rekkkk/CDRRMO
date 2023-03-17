<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="shortcut icon" href="{{ URL('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
        <link rel="stylesheet" href="{{ URL('assets/css/theme.css') }}">
        <title>{{ config('app.name')}}</title>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            <header class="header-section w-full bg-slate-50">
                <div class="container-fluid relative w-full h-full">
                    <div class="w-full h-full relative">
                        <img class="w-24 float-right h-full" src="{{ URL('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="float-right h-full text-lg font-semibold">Cabuyao City Disaster Risk<br>Reduction and Management Office</span>
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
                @include('partials.dashboard.createPost')
                <div class="content-item rounded-t-lg w-full">
                    <div class="content-header text-center text-white rounded-t-lg">
                        <div class="text-2xl p-2 w-full h-full">
                            @include('partials.dashboard.postBtn')
                            <span>CDRRMO Announcement</span><br>
                            <span>December 10, 2021</span>
                        </div>
                    </div>
                    <div class="pt-2 bg-white rounded-b-lg p-3">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam porro quasi natus quibusdam non odio, ut fugit nulla itaque quod illo quaerat rerum neque dolorem labore corporis molestiae dolorum, repellendus minus doloremque dolores provident. Facere tempore reprehenderit tenetur eos nam necessitatibus deserunt temporibus ea totam, culpa voluptatibus laudantium soluta modi? Nostrum voluptates quae dolor repellendus alias fuga est nisi nemo rerum officia! Repellendus soluta velit officia sint omnis aut ex, odit id quo quidem suscipit inventore alias illum, explicabo maiores saepe accusantium et quia animi ab? Dolor sequi distinctio, officia illum dolorem est iure consequatur quam incidunt veniam nulla qui exercitationem rem vero maiores! Quidem velit voluptate ab delectus debitis neque qui? Dolorum, saepe quo minima officiis ea iure aut tempore labore culpa laudantium fugit distinctio optio perferendis odio ipsum iste asperiores ad iusto deserunt nostrum ratione ipsam magnam? Dolorem, quos? Labore qui, quae reiciendis mollitia facilis explicabo temporibus voluptatibus.</p>
                    </div>
                </div>

                <div class="content-item rounded-t-lg w-full ">
                    <div class="content-header text-center text-white w-full rounded-t-lg">
                        <div class="text-2xl p-2 w-full h-full">
                            @include('partials.dashboard.postBtn')
                            <span>CDRRMO Announcement</span><br>
                            <span>December 10, 2021</span>
                        </div>
                    </div>
                    <div class="pt-2 bg-white rounded-b-lg p-4">
                        <img class="w-full rounded" src="{{ URL('assets/img/Announcement-Test.jpg') }}" alt="picture">
                        <p class="pt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam porro quasi natus quibusdam non odio, ut fugit nulla itaque quod illo quaerat rerum neque dolorem labore corporis molestiae dolorum, repellendus minus doloremque dolores provident. Facere tempore reprehenderit tenetur eos nam necessitatibus deserunt temporibus ea totam, culpa voluptatibus laudantium soluta modi? Nostrum voluptates quae dolor repellendus alias fuga est nisi nemo rerum officia! Repellendus soluta velit officia sint omnis aut ex, odit id quo quidem suscipit inventore alias illum, explicabo maiores saepe accusantium et quia animi ab? Dolor sequi distinctio, officia illum dolorem est iure consequatur quam incidunt veniam nulla qui exercitationem rem vero maiores! Quidem velit voluptate ab delectus debitis neque qui? Dolorum, saepe quo minima officiis ea iure aut tempore labore culpa laudantium fugit distinctio optio perferendis odio ipsum iste asperiores ad iusto deserunt nostrum ratione ipsam magnam? Dolorem, quos? Labore qui, quae reiciendis mollitia facilis explicabo temporibus voluptatibus.</p>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ URL('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>