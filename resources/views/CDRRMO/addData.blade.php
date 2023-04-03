<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/addData.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            
            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <div class="main-content">

                <div class="dashboard-logo pb-4">
                    <i class="bi bi-person-plus text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                    <span class="text-2xl font-bold tracking-wider mx-2">ADD RESIDENT</span>
                    <hr class="mt-4">
                </div>

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
                                
                                <form action="#" id="Typhoon" class="mb-5">
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

                                    <div class="mb-3 text-center">
                                        <label class="form-label mb-2">Female</label>
                                        <input type="number" class="form-control p-2">
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-center mb-2">Evacuation Assigned</p>
                                        <select class="form-select p-2">
                                            <option value="">Choose Evacuation Center</option>
                                            <option>Evacuation 1</option>
                                            <option>Evacuation 2</option>
                                            <option>Evacuation 3</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>
                                </form>

                                <form action="#" id="Road Accident" class="mb-3">
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

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>

                                </form>

                                <form action="#" id="Earthquake" class="mb-3">
                                        
                                    <div class="mb-3 text-center">
                                        <label class="form-label mb-2">Magnitude</label>
                                        <input type="number" min="0.1" max="30" step="0.1" class="form-control p-2">
                                    </div>

                                    <div class="mb-5 text-center">
                                        <label class="form-label mb-2">Month</label>
                                        <input type="text" class="form-control p-2">
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success float-end p-2">Add Data</button>
                                        <button type="submit" class="btn btn-danger clear-both p-2">Cancel</button>
                                    </div>

                                </form>

                                <form action="#" id="Flooding" class="mb-3">
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

                                    <div class="mb-3">
                                        <p class="text-center mb-2">Evacuation Assigned</p>
                                        <select class="form-select p-2">
                                            <option value="">Choose Evacuation Center</option>
                                            <option>Evacuation 1</option>
                                            <option>Evacuation 2</option>
                                            <option>Evacuation 3</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
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

        <script src="{{ asset('assets/js/form.js') }}"></script>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    </body>
</html>