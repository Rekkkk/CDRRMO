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
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-book p-2 bg-slate-600"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">E-LIGTAS GUIDELINES</span>
            </div>
            <hr class="mt-4">
            <div class="content-item text-center mt-3">
                <div class="guideline-container">
                    @foreach ($guideline as $guidelineItem)
                        <div class="guideline-widget">
                            @auth
                                @if (auth()->user()->status == 'Active')
                                    <a href="javascript:void(0)" class="absolute left-2 top-3" id="updateGuidelineBtn">
                                        <i class="btn-update bi bi-pencil-square p-2"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="absolute top-3 right-2" id="removeGuidelineBtn">
                                        <i class="btn-remove bi bi-x-lg cursor-pointer p-2"></i>
                                    </a>
                                @endif
                                <a class="guidelines-item"
                                    href="{{ route('guide.display', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="guideline-content">
                                        <img class="w-full" src="{{ asset('assets/img/cdrrmo-logo.png') }}" alt="logo">
                                        <div class="guideline-type">
                                            <p class="uppercase">{{ $guidelineItem->type }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endauth
                            @guest
                                <a class="guidelines-item"
                                    href="{{ route('resident.guide', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="guideline-content">
                                        <img class="w-full" src="{{ asset('assets/img/cdrrmo-logo.png') }}" alt="logo">
                                        <div class="guideline-type">
                                            <p class="uppercase">{{ $guidelineItem->type }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endguest
                        </div>
                    @endforeach
                    @if (auth()->check() && auth()->user()->status == 'Active')
                        <div class="guideline-btn">
                            <div class="btn-container">
                                <a id="createGuidelineBtn" href="javascript:void(0)"
                                    class="btn-submit">
                                    <i class="bi bi-plus text-2xl"></i>
                                </a>
                            </div>
                        </div>
                        @include('userpage.guideline.guidelineModal')
                    @endif
                </div>
            </div>
        </div>
        @auth
            @include('userpage.changePasswordModal')
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @auth
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
        @include('partials.toastr')
        @if (auth()->check() && auth()->user()->status == 'Active')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    let guidelineId, defaultFormData;

                    let validator = $("#guidelineForm").validate({
                        rules: {
                            type: {
                                required: true
                            }
                        },
                        messages: {
                            type: {
                                required: 'Please Enter Guideline Type.'
                            }
                        },
                        errorElement: 'span',
                        submitHandler: createGuidelineForm
                    });

                    $('#createGuidelineBtn').click(function() {
                        $('#guidelineForm')[0].reset();
                        $('#guideline_operation').val('create');
                        $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                        $('.modal-title').text('Create Guideline');
                        $('#submitGuidelineBtn').removeClass('btn-update').addClass('btn-submit').text('Create');
                        $('#guidelineModal').modal('show');
                    });

                    $(document).on('click', '#updateGuidelineBtn', function() {
                        $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                        $('.modal-title').text('Update Guideline');
                        $('#submitGuidelineBtn').removeClass('btn-submit').addClass('btn-update').text('Update');
                        let guidelineWidget = this.closest('.guideline-widget');
                        let guidelineItem = guidelineWidget.querySelector('.guidelines-item');
                        guidelineId = guidelineItem.getAttribute('href').split('/').pop();
                        let guidelineLabel = guidelineItem.querySelector('.guideline-type p').innerText
                            .toLowerCase();
                        $('#guidelineType').val(guidelineLabel);
                        $('#guideline_operation').val('update');
                        $('#guidelineModal').modal('show');
                        defaultFormData = $('#guidelineForm').serialize();
                    });

                    $(document).on('click', '#removeGuidelineBtn', function() {
                        guidelineWidget = this.closest('.guideline-widget');
                        guidelineItem = guidelineWidget.querySelector('.guidelines-item');
                        guidelineId = guidelineItem.getAttribute('href').split('/').pop();

                        confirmModal('Do you want to remove this guideline?').then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        guidelineId: guidelineId
                                    },
                                    url: "{{ route('guideline.remove', ':guidelineId') }}"
                                        .replace(':guidelineId', guidelineId),
                                    type: "PATCH",
                                    success: function() {
                                        toastr.success(
                                            'Guideline removed successfully, Please wait...',
                                            'Success', {
                                                onHidden: function() {
                                                    location.reload();
                                                }
                                            });
                                    },
                                    error: function() {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                });
                            }
                        });
                    });

                    function createGuidelineForm(form) {
                        let operation = $('#guideline_operation').val(),
                            url = "",
                            type = "",
                            formData = $(form).serialize();

                        url = operation == 'create' ? "{{ route('guideline.create') }}" :
                            "{{ route('guideline.update', 'guidelineId') }}".replace('guidelineId',
                                guidelineId);

                        type = operation == 'create' ? "POST" : "PUT";

                        confirmModal(`Do you want to ${operation} this guideline?`).then((result) => {
                            if (result.isConfirmed) {
                                if (operation == 'update' && defaultFormData == formData) {
                                    $('#guidelineModal').modal('hide');
                                    toastr.warning('No changes were made.', 'Warning');
                                    return;
                                }
                                $.ajax({
                                    data: formData,
                                    url: url,
                                    type: type,
                                    success: function(response) {
                                        if (response.status == 'warning') {
                                            toastr.warning(response.message, 'Error');
                                        } else {
                                            toastr.success(
                                                `Guideline successfully ${operation}d, Please wait...`,
                                                'Success', {
                                                    onHidden: function() {
                                                        location.reload();
                                                    }
                                                });
                                            $('#guidelineForm')[0].reset();
                                            $('#guidelineModal').modal('hide');
                                        }
                                    },
                                    error: function() {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                });
                            }
                        });
                    }
                });
            </script>
        @endif
    @endauth
</body>

</html>
