<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="m-auto">
                        <i class="bi bi-book text-2xl p-2 bg-slate-600 text-white rounded"></i>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-wider">E-LIGTAS GUIDELINES</span>
                </div>
            </div>
            <hr class="mt-4">
            <div class="content-item text-center pt-4">
                <div class="widget-container">
                    @foreach ($guideline as $guidelineItem)
                        <div class="guideline-widget">
                            @if (auth()->check())
                                <a href="{{ route('guideline.remove', Crypt::encryptString($guidelineItem->id)) }}"
                                    class="absolute top-2 right-0">
                                    <i class="bi bi-x-lg cursor-pointer p-2.5"></i>
                                </a>
                                <a href="#edit{{ $guidelineItem->id }}" data-bs-toggle="modal"
                                    class="absolute left-2 top-3">
                                    <i class="btn-edit bi bi-pencil p-2"></i>
                                </a>
                                @include('userpage.guideline.updateGuideline')
                                <a class="guidelines-item"
                                    href="{{ route('guide.display', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="relative bg-slate-50 drop-shadow-2xl -z-50 overflow-hidden rounded">
                                        <img class="w-full" src="{{ asset('assets/img/cdrrmo-logo.png') }}"
                                            alt="logo">
                                        <div
                                            class="absolute w-full h-3/6 top-2/4 text-white bg-slate-700 flex items-center justify-center">
                                            <p class="uppercase">{{ $guidelineItem->type }}</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a class="guidelines-item"
                                    href="{{ route('resident.guide', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="relative bg-slate-50 drop-shadow-2xl -z-50 overflow-hidden rounded">
                                        <img class="w-full" src="{{ asset('assets/img/cdrrmo-logo.png') }}"
                                            alt="logo">
                                        <div
                                            class="absolute w-full h-3/6 top-2/4 text-white bg-slate-700 flex items-center justify-center hover:scale-105">
                                            <p class="uppercase">{{ $guidelineItem->type }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endforeach
                    @if (
                        (auth()->check() && auth()->user()->position == 'President') ||
                            (auth()->check() && auth()->user()->position == 'Secretary'))
                        <div class="w-72">
                            <div class="flex text-slate-600 w-full h-full drop-shadow-2xl items-center justify-center">
                                <a id="createGuidelineBtn" href="javascript:void(0)"
                                    class="transition ease-in-out delay-150 hover:scale-105 duration-100">
                                    <i class="bi bi-plus-square-fill text-4xl "></i>
                                </a>
                            </div>
                        </div>
                        @include('userpage.guideline.addGuideline')
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
    @if (auth()->check())
        <script>
            $(document).ready(function() {
                $('#createGuidelineBtn').click(function() {
                    $('#guidelineForm')[0].reset();
                    $('#guidelineModal').modal('show');
                });

                $('#submitGuidelineBtn').click(function(e) {
                    e.preventDefault();

                    confirmModal('Do you want to create this guideline?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                data: $('#guidelineForm').serialize(),
                                url: "{{ route('guideline.add') }}",
                                type: "POST",
                                dataType: 'json',
                                beforeSend: function(response) {
                                    $(document).find('span.error-text').text('');
                                },
                                success: function(response) {
                                    if (response.status == 0) {
                                        $.each(response.error, function(prefix, val) {
                                            $('span.' + prefix + '_error').text(val[
                                                0]);
                                        });
                                        messageModal('Warning',
                                            'Failed to Create E-LIGTAS Guideline.',
                                            'warning', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'E-LIGTAS Guideline Successfully Created.',
                                            'success', '#3CB043').then(() => {
                                            $('#guidelineForm')[0].reset();
                                            $('#guidelineModal').modal('hide');
                                            location.reload();
                                        });
                                    }
                                },
                                error: function() {
                                    messageModal('Warning',
                                        'Something went wrong, Try again later.',
                                        'warning', '#FFDF00');
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endif
</body>

</html>
