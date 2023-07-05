<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="m-auto">
                        <i class="bi bi-info-circle text-2xl p-2 bg-slate-600 text-white rounded"></i>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-wider">ABOUT</span>
                </div>
            </div>
            <hr class="my-4">
            <div class="about-content">
                <div class="location-section drop-shadow-lg bg-slate-600 p-6 text-white">
                    <div class="text-center">
                        <span class="text-2xl font-bold">Location</span>
                    </div>
                    <div class="mt-8">
                        <i class="bi bi-geo-alt-fill mr-4 text-lg"></i>
                        Address:
                        @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                            <i class="bi bi-pencil float-right cursor-pointer btn-edit px-2 py-1"
                                id="editAddressModal"></i>

                            <div class="modal fade" id="editAddressForm" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-red-900">
                                            <h1 class="modal-title fs-5 text-center text-white">
                                                {{ config('app.name') }}
                                            </h1>
                                        </div>
                                        <div class="modal-body">
                                            <label for="address" class="text-black">Address</label>
                                            <input type="text" id="address" value="" class="form-control"
                                                placeholder="Enter Address" autocomplete="off">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="bg-slate-700 text-white p-2 rounded drop-shadow-lg hover:bg-slate-800"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" id="editAddressBtn"
                                                class="bg-red-600 text-white p-2 rounded drop-shadow-lg hover:bg-red-700">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <hr class="mt-3 clear-both">
                        <a
                            href="https://www.google.com/maps/place/Retail+Plaza+City+of+Cabuyao/@14.2772989,121.1214,17z/data=!3m1!4b1!4m6!3m5!1s0x3397d8604aa8f17d:0x4e0371b3a9d5540e!8m2!3d14.2772937!4d121.1235887!16s%2Fg%2F11bxg2qw2w">
                            <p class="my-3" value="" id="addressData">2nd Floor, Cabuyao Retail Plaza 4025
                                Cabuyao, Philippines
                            </p>
                        </a>
                    </div>
                </div>

                <div class="right-side flex flex-1 flex-col">
                    <div class="social-section drop-shadow-2xl bg-slate-600 mb-4 text-white">
                        <div class="text-center py-4">
                            <span class="text-lg font-bold">Social</span>
                        </div>
                        <hr>
                        <a href="https://www.facebook.com/CabuyaoCDRRMO">
                            <p class="p-4">
                                <i class="bi bi-facebook mr-4"></i>CDRRMO CABUYAO
                            </p>
                        </a>
                        <hr>
                        <a href="#">
                            <p class="p-4">
                                <i class="bi bi-twitter mr-4"></i> Example 2
                            </p>
                        </a>
                        <hr>
                        <a href="#">
                            <p class="p-4">
                                <i class="bi bi-youtube mr-4"></i> Example 3
                            </p>
                        </a>
                        <hr>
                        <a href="#">
                            <p class="p-4">
                                <i class="bi bi-instagram mr-4"></i> Example 4
                            </p>
                        </a>
                    </div>

                    <div class="telephone-section drop-shadow-2xl flex-1 bg-slate-600 text-white">
                        <div class="text-center py-4 font-bold">
                            <span class="text-lg">Contact</span>
                        </div>
                        <hr>
                        <p class="p-4">
                            <i class="bi bi-telephone-outbound-fill mr-4 text-lg"></i> +49 5081 159
                        </p>
                        <hr>
                        <a href="https://www.facebook.com/messages/t/242799609519367">
                            <p class="p-4">
                                <i class="bi bi-messenger mr-4 text-lg"></i> CDRRMO CABUYAO
                            </p>
                        </a>
                        <hr>
                        <p class="p-4">
                            <i class="bi bi-envelope-at mr-4 text-lg"></i> cdrrmocabuyao@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
