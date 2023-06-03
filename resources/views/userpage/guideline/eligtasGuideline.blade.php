<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-400">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="main-content pt-8 pr-8 pl-28">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-book text-2xl p-2 bg-slate-900 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">E-LIGTAS Guideline</span>
                <hr class="mt-4">
            </div>

            @if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
                <div class="guidelines-btn py-2 flex justify-end">
                    <a class="bg-slate-700 mx-2 p-2 text-white rounded shadow-lg hover:bg-slate-900"
                        id="createGuidelineBtn" href="javascript:void(0)">
                        <i class="bi bi-file-earmark-plus-fill mr-2"></i></i>Publish Guideline
                    </a>
                    @include('userpage.guideline.addGuideline')
                </div>
            @endif

            <div class="content-item text-center mt-4" id="guidelineWidget">
                <div class="row gap-4 justify-center items-center">
                    @forelse ($guideline as $guidelineItem)
                        <div class="col-lg-2 mb-4 relative">
                            @if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
                                <a href="{{ route('remove.guideline.cdrrmo', Crypt::encryptString($guidelineItem->id)) }}"
                                    class="absolute right-0">
                                    <i
                                        class="bi bi-x-lg cursor-pointer p-2.5 bg-red-700 text-white rounded-full shadow-lg hover:bg-red-900"></i>
                                </a>
                                <a href="#edit{{ $guidelineItem->id }}" data-bs-toggle="modal"
                                    class="absolute left-4 top-3">
                                    <i
                                        class="bi bi-pencil cursor-pointer p-2 bg-slate-700 text-white rounded shadow-lg hover:bg-slate-900"></i>
                                </a>
                                @include('userpage.guideline.updateGuideline')

                                <a class="guidelines-item"
                                    href="{{ route('guide.cdrrmo', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="relative bg-slate-50 drop-shadow-xl -z-50 overflow-hidden">
                                        <img class="w-full" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}"
                                            alt="logo">
                                        <p class="absolute w-full h-3/6 top-2/4 text-white bg-slate-900">
                                            {{ $guidelineItem->type }}</p>
                                    </div>
                                </a>
                            @endif
                            @guest
                                <a class="guidelines-item"
                                    href="{{ route('guide.resident', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="relative bg-slate-50 drop-shadow-xl overflow-hidden">
                                        <img class="w-full" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                        <p class="absolute w-full h-3/6 top-2/4 text-white bg-slate-900">
                                            {{ $guidelineItem->type }}</p>
                                    </div>
                                </a>
                            @endguest
                        </div>
                    @empty
                        <div class="empty-record bg-slate-900 p-5 rounded text-white">
                            <div class="image-container flex justify-center items-center">
                                <img src="{{ asset('assets/img/emptyRecord.svg') }}" alt="image"
                                    style="width:300px;">
                            </div>
                            <h1 class="fs-2 text-red-700 font-bold mt-10">{{ config('app.name') }}</h1>
                            <span class="font-semibold">No Record Found!</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#createGuidelineBtn').click(function() {
                    $('#create_guideline_id').val('');
                    $('#createGuidelineForm').trigger("reset");
                    $('#createGuidelineModal').modal('show');
                });

                $('#submitGuidelineBtn').click(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'question',
                        title: 'Would you like to publish this guideline?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes, publish it.',
                        confirmButtonColor: '#334155',
                        denyButtonText: 'Double Check'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                data: $('#createGuidelineForm').serialize(),
                                url: "{{ route('add.guideline.cdrrmo') }}",
                                type: "POST",
                                dataType: 'json',
                                beforeSend: function(data) {
                                    $(document).find('span.error-text').text('');
                                },
                                success: function(data) {
                                    if (data.condition == 0) {
                                        $.each(data.error, function(prefix, val) {
                                            $('span.' + prefix + '_error').text(val[
                                                0]);
                                        });
                                        Swal.fire({
                                            icon: 'error',
                                            confirmButtonText: 'Understood',
                                            confirmButtonColor: '#334155',
                                            title: "{{ config('app.name') }}",
                                            text: 'Failed to Publish E-LIGTAS Guideline.'
                                        });
                                    } else {
                                        $('#createGuidelineForm')[0].reset();
                                        $('#createGuidelineModal').modal('hide');
                                        Swal.fire({
                                            title: "{{ config('app.name') }}",
                                            text: 'E-LIGTAS Guideline Successfully Published.',
                                            icon: 'success'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        });
                                    }
                                },
                                error: function(data) {
                                    Swal.fire({
                                        icon: 'error',
                                        confirmButtonText: 'Understood',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Something went wrong, try again later.'
                                    });
                                }
                            });
                        }
                    })
                });
            });
        </script>
    @endif
</body>

</html>
