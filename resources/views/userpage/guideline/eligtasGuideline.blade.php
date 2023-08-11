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
            <div class="label-container">
                <div class="icon-container">
                    <div class="icon-content">
                        <i class="bi bi-book"></i>
                    </div>
                </div>
                <span>E-LIGTAS GUIDELINES</span>
            </div>
            <hr>
            <div class="content-item">
                <div class="guideline-container">
                    @foreach ($guideline as $guidelineItem)
                        <div class="guideline-widget">
                            @auth
                                @if (auth()->user()->is_disable == 0)
                                    <button id="updateGuidelineBtn">
                                        <i class="btn-update bi bi-pencil-square"></i>
                                    </button>
                                    <button id="removeGuidelineBtn">
                                        <i class="btn-remove bi bi-x-lg"></i>
                                    </button>
                                @endif
                                <a class="guidelines-item"
                                    href="{{ route('guide.display', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="guideline-content">
                                        <img src="{{ asset('assets/img/cdrrmo-logo.png') }}" alt="logo">
                                        <div class="guideline-type">
                                            <p>{{ $guidelineItem->type }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endauth
                            @guest
                                <a class="guidelines-item"
                                    href="{{ route('resident.guide', Crypt::encryptString($guidelineItem->id)) }}">
                                    <div class="guideline-content">
                                        <img src="{{ asset('assets/img/cdrrmo-logo.png') }}" alt="logo">
                                        <div class="guideline-type">
                                            <p>{{ $guidelineItem->type }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endguest
                        </div>
                    @endforeach
                    @if (auth()->check() && auth()->user()->is_disable == 0)
                        <div class="guideline-btn">
                            <div class="btn-container">
                                <button id="createGuidelineBtn">
                                    <i class="btn-submit bi bi-plus-lg"></i>
                                </button>
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
    @include('partials.script')
    @auth
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
        @include('partials.toastr')
        @if (auth()->check() && auth()->user()->is_disable == 0)
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    let guidelineId, defaultFormData;

                    let validator = $("#guidelineForm").validate({
                        rules: {
                            type: 'required'
                        },
                        messages: {
                            type: 'Please Enter Guideline Type.'
                        },
                        errorElement: 'span',
                        submitHandler: createGuidelineForm
                    });

                    $(document).on('click', '#createGuidelineBtn', function() {
                        $('#guidelineForm')[0].reset();
                        $('#guideline_operation').val('create');
                        $('.modal-label-container').removeClass('bg-warning').addClass('bg-success');
                        $('.modal-label').text('Create Guideline');
                        $('#submitGuidelineBtn').removeClass('btn-update').addClass('btn-submit').text('Create');
                        $('#guidelineModal').modal('show');
                    });

                    $(document).on('click', '#updateGuidelineBtn', function() {
                        $('.modal-label-container').removeClass('bg-success').addClass('bg-warning');
                        $('.modal-label').text('Update Guideline');
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
                                        showSuccessMessage(
                                            'Guideline removed successfully, Please wait...'
                                        );
                                    },
                                    error: function() {
                                        showErrorMessage();
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
                                    showWarningMessage('No changes were made.');
                                    return;
                                }
                                $.ajax({
                                    data: formData,
                                    url: url,
                                    type: type,
                                    success: function(response) {
                                        if (response.status == 'warning') {
                                            showWarningMessage(response.message);
                                        } else {
                                            showSuccessMessage(
                                                `Guideline successfully ${operation}d, Please wait...`
                                            );
                                            $('#guidelineForm')[0].reset();
                                            $('#guidelineModal').modal('hide');
                                        }
                                    },
                                    error: function() {
                                        showErrorMessage();
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
