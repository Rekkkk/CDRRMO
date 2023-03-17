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
        <link rel="stylesheet" href="{{ URL('assets/css/addData.css') }}">
        <title>{{ config('app.name')}}</title>
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
                <div class="content-item text-white m-4">
                    <div class="content-details">
                        <div class="content-body">
                            <h1 class="text-center fs-5 p-4">ADD RESIDENT</h1>
                            <div class="container form-list">
                                <div class="dropdown">
                                    <p class="text-center mb-2">Disaster Type</p>
                                    <div class="mb-3">
                                        <select id="disaster" class="form-select p-2" >
                                            <option value="">Choose Disaster Type</option>
                                            <option value="Typhoon">Typhoon</option>
                                            <option value="Road Accident">Road Accident</option>
                                            <option value="Earthquake">Earthquake</option>
                                            <option value="Flooding">Flooding</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <form id="Typhoon" class="mb-5">
                                    <div class="mb-4">
                                        <p class="text-center mb-2">Age Range</p>
                                        <select class="form-select p-2">
                                            <option value="">Choose Age Range</option>
                                            <option>1-18 years old</option>
                                            <option>19-59 years old</option>
                                            <option>60 Above</option>
                                        </select>
                                    </div>
                                        
                                    <div class="mb-3 text-center">
                                    <label class="form-label mb-2">Male</label>
                                    <input type="number" class="form-control p-2">
                                    </div>

                                    <div class="mb-5 text-center">
                                    <label class="form-label mb-2">Female</label>
                                    <input type="number" class="form-control p-2">
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>
                                </form>

                                <form id="Road Accident" class="mb-3">
                                    <div class="mb-4">
                                        <p class="text-center mb-2">Location</p>
                                        <select class="form-select p-2">
                                            <option value="">Choose Location</option>
                                            <option>Gulod</option>
                                            <option>Mamatid</option>
                                            <option>Banay Banay</option>
                                        </select>
                                    </div>
                                        
                                    <div class="mb-3 text-center">
                                    <label class="form-label mb-2">Casualties</label>
                                    <input type="number" class="form-control p-2">
                                    </div>

                                    <div class="mb-5 text-center">
                                    <label class="form-label mb-2">Injured</label>
                                    <input type="number" class="form-control p-2">
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>

                                </form>

                                <form id="Earthquake" class="mb-3">
                                        
                                    <div class="mb-3 text-center">
                                    <label class="form-label mb-2">Magnitude</label>
                                    <input type="number" min="0.1" max="30" step="0.1" class="form-control p-2">
                                    </div>

                                    <div class="mb-5 text-center">
                                    <label class="form-label mb-2">Month</label>
                                    <input type="text" class="form-control p-2">
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>

                                </form>

                                <form id="Flooding" class="mb-3">
                                    <div class="mb-4">
                                        <p class="text-center mb-2">Location</p>
                                        <select class="form-select p-2">
                                            <option value="">Choose Location</option>
                                            <option>Gulod</option>
                                            <option>Mamatid</option>
                                            <option>Banay Banay</option>
                                        </select>
                                    </div>
                                        
                                    <div class="mb-3 text-center">
                                    <label class="form-label mb-2">Month</label>
                                    <input type="number" class="form-control p-2">
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ URL('assets/js/form.js') }}"></script>
        <script src="{{ URL('assets/js/landingPage.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>