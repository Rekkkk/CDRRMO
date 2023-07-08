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
                    <div class="text-2xl text-white">
                        <i class="bi bi-file-earmark-richtext p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">GUIDES</span>
            </div>
            <hr class="mt-3">
            <div class="guide-btn flex justify-end mt-2">
                @if (auth()->check())
                    <a href="javascript:void(0)" id="createGuideBtn" class="btn-submit p-2 font-medium">
                        <i class="bi bi-plus-lg mr-2"></i> Create Guide
                    </a>
                    <input type="text" class="guidelineId" value="{{ $guidelineId }}" hidden>
                    @include('userpage.guideline.addGuide')
                @endif
            </div>
            @foreach ($guide as $guide)
                <div class="guide-container">
                    <div class="guide-content relative mx-2.5 my-2">
                        <div class="label relative bg-slate-600 text-white cursor-pointer p-3 uppercase">
                            {{ $guide->label }}
                        </div>
                        <div class="content relative h-0 overflow-hidden drop-shadow-lg bg-slate-50">
                            <p class="mb-2">
                                {{ $guide->content }}
                            </p>
                            @if (auth()->check())
                                <div class="py-2 flex justify-start">
                                    <a href="#edit{{ $guide->id }}" data-bs-toggle="modal" class="btn-edit p-2">
                                        <i class="bi bi-pencil text-sm mr-2"></i>Edit
                                    </a>
                                    <a href="{{ route('guide.remove', $guide->id) }}" class="btn-cancel ml-2 p-2">
                                        <i class="bi bi-trash mr-2"></i>Remove
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            const accordion = document.getElementsByClassName('guide-content');

            for (i = 0; i < accordion.length; i++) {
                accordion[i].addEventListener('click', function() {
                    this.classList.toggle('active')
                })
            }

            $('#createGuideBtn').click(function() {
                $('#createGuideForm').trigger("reset");
                $('#createGuideModal').modal('show');
            });

            let validator = $("#createGuideForm").validate({
                rules: {
                    label: {
                        required: true
                    },
                    content: {
                        required: true
                    }
                },
                messages: {
                    content: {
                        required: 'Please Enter Guide Label.'
                    },
                    content: {
                        required: 'Please Enter Guide Content.'
                    }
                },
                errorElement: 'span',
                submitHandler: createGuideForm
            });

            function createGuideForm(form) {
                let guidelineId = $('.guidelineId').val();

                confirmModal(`Do you want to create this guide?`).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#createGuideForm').serialize(),
                            url: "{{ route('guide.add', ':guidelineId') }}"
                                .replace(
                                    ':guidelineId', guidelineId),
                            type: "POST",
                            dataType: 'json',
                            success: function(data) {
                                if (data.status == 0) {
                                    messageModal(
                                        'Error',
                                        'Failed to Post E-LIGTAS Guide.',
                                        'info',
                                        '#B91C1C'
                                    );
                                } else {
                                    messageModal(
                                        'Success',
                                        'E-LIGTAS Guide Successfully Posted.',
                                        'success',
                                        '#3CB043'
                                    ).then((result) => {
                                        $('#createGuideForm')[0].reset();
                                        $('#createGuideModal').modal(
                                            'hide');
                                        location.reload();
                                    });
                                }
                            },
                            error: function(data) {
                                messageModal(
                                    'Error',
                                    'Something went wrong, try again later.',
                                    'info',
                                    '#B91C1C'
                                );
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
