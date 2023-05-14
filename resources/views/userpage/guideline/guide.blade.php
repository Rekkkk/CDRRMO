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

        <h1 class="text-center bg-slate-700 w-full mt-2 text-white mb-2 text-4xl p-3 font-bold">"E-LIGTAS Guide"</h1>

        <div class="guide-btn w-full py-2 flex justify-end">
            @guest
                <button type="button"
                    class="bg-slate-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200">
                    <i class="bi bi-pencil mr-2"></i> Take Quiz
                </button>
            @endguest
            @if (Auth::check() && Auth::user()->user_role == '1')
                <button type="button"
                    class="bg-slate-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200">
                    <i class="bi bi-pencil mr-2"></i> Edit Quiz
                </button>
                <a href="javascript:void(0)" id="createGuideBtn"
                    class="bg-red-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-red-900 transition duration-200">
                    <i class="bi bi-bag-plus-fill mr-2"></i> Add Guide
                </a>
                <input type="hidden" class="guideline_id" value="{{ $guidelineId }}">
                @include('userpage.guideline.addGuide')
            @endif
        </div>

        <div class="main-content pt-8 pr-8 pl-28">
            @foreach ($guide as $guide)
                <div class="guide-container w-full">
                    <div class="guide-content relative mx-2.5 my-2 mb-2">
                        <div class="label relative bg-slate-900 text-white cursor-pointer p-3">
                            {{ $guide->guide_description }}

                        </div>
                        <div class="content relative h-0 overflow-hidden bg-neutral-200">
                            <p class="mb-2">
                                {{ $guide->guide_content }}
                            </p>
                            @if (Auth::check() && Auth::user()->user_role == '1')
                                <div class="action-btn w-full py-2 flex justify-start">
                                    <a href="#edit{{ $guide->guide_id }}" data-bs-toggle="modal">
                                        <button type="submit"
                                            class="bg-slate-700 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200">
                                            <i class="bi bi-pencil text-sm mr-2"></i>Edit
                                        </button>
                                    </a>
                                    <a href="{{ route('remove.guide.cdrrmo', $guide->guide_id) }}">
                                        <button type="submit"
                                            class="bg-red-700 ml-2 p-2 py-2 text-white rounded shadow-lg hover:bg-red-900 transition duration-200">
                                            <i class="bi bi-trash mr-2"></i>Delete
                                        </button>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @include('userpage.guideline.updateGuide')
            @endforeach
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            const accordion = document.getElementsByClassName('guide-content');

            for (i = 0; i < accordion.length; i++) {
                accordion[i].addEventListener('click', function() {
                    this.classList.toggle('active')
                })
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#createGuideBtn').click(function() {

                $('#create_guide_id').val('');
                $('#guideline_id').val('');
                $('#createGuideForm').trigger("reset");
                $('#createGuideModal').modal('show');
            });

            $('#submitGuideBtn').click(function(e) {
                var guideline_id = $('.guideline_id').val();
                e.preventDefault();

                Swal.fire({
                    title: 'Do you want to add this guide?',
                    showDenyButton: true,
                    confirmButtonText: 'Add Guide',
                    denyButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#createGuideForm').serialize(),
                            url: "{{ route('add.guide.cdrrmo', ':guideline_id') }}".replace(
                                ':guideline_id', guideline_id),
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
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Failed to Add E-LIGTAS Guide.',
                                        'error'
                                    );
                                } else {
                                    Swal.fire({
                                        title: "{{ config('app.name') }}",
                                        text: 'E-LIGTAS Guide Successfully Posted.',
                                        icon: 'success'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $('#createGuideForm')[0].reset();
                                            $('#createGuideModal').modal(
                                                'hide');
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(data) {
                                Swal.fire(
                                    "{{ config('app.name') }}",
                                    'Failed to Post E-LIGTAS Guide',
                                    'error'
                                );
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire(
                            "{{ config('app.name') }}",
                            'E-LIGTAS Guide is not already posted!',
                            'info'
                        )
                    }
                })
            });
        });
    </script>
</body>

</html>
