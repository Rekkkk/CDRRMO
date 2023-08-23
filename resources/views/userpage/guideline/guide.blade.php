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
                        <i class="bi bi-file-earmark-richtext"></i>
                    </div>
                </div>
                <span>GUIDES</span>
            </div>
            <hr>
            <div class="guide-btn">
                @if (auth()->check() && auth()->user()->is_disable == 0)
                    <a href="javascript:void(0)" class="btn-submit" id="createGuideBtn">
                        <i class="bi bi-plus-lg mr-2"></i> Create Guide
                    </a>
                    <input type="text" class="guidelineId" value="{{ $guidelineId }}" hidden>
                    @include('userpage.guideline.guideModal')
                @endif
            </div>
            {{-- <div class="guide-container">
                @foreach ($guide as $guide)
                    <div class="guide-widget">
                        @auth
                            @if (auth()->user()->is_disable == 0)
                                <a href="javascript:void(0)" class="absolute top-3 right-2" id="removeGuideBtn">
                                    <i class="btn-remove bi bi-x-lg cursor-pointer p-2"></i>
                                </a>
                                <a href="javascript:void(0)" class="absolute left-2 top-3" id="updateGuideBtn">
                                    <i class="btn-update bi bi-pencil p-2"></i>
                                </a>
                            @endif
                            <a class="guide-item cursor-pointer guideContentBtn">
                                <div class="guide-content">
                                    <img class="w-full" src="{{ asset('assets/img/cdrrmo-logo.png') }}" alt="logo">
                                    <div class="guide-type">
                                        <p class="uppercase">{{ $guide->label }}</p>
                                    </div>
                                    <input type="text" id="guideContent" value="{{ $guide->content }}" hidden>
                                    <input type="text" id="guideId" value="{{ $guide->id }}" hidden>
                                </div>
                            </a>
                            @include('userpage.guideline.guideContent')
                        @endauth
                        @guest
                            <a class="guide-item" href="">
                                <div class="guide-content">
                                    <img class="w-full" src="{{ asset('assets/img/cdrrmo-logo.png') }}" alt="logo">
                                    <div class="guide-type">
                                        <p class="uppercase">{{ $guide->label }}</p>
                                    </div>
                                </div>
                            </a>
                        @endguest
                    </div>
                @endforeach
            </div> --}}
            @include('userpage.changePasswordModal')
        </div>
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
        @if (auth()->user()->is_disable == 0)
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(() => {
                    let guideId, validator, guideWidget, guideItem, defaultFormData, guidelineId = $('.guidelineId').val(),
                        operation, modal = $('#guideModal'),
                        modalLabel = $('.modal-label'),
                        modalLabelContainer = $('.modal-label-container'),
                        formButton = $('#submitGuideBtn');

                    validator = $("#guideForm").validate({
                        rules: {
                            label: 'required',
                            content: 'required'
                        },
                        messages: {
                            label: 'Please Enter Guide Label.',
                            content: 'Please Enter Guide Content.'
                        },
                        errorElement: 'span',
                        submitHandler: guideFormHandler
                    });

                    $(document).on('click', '#createGuideBtn', () => {
                        operation = "create";
                        modalLabelContainer.removeClass('bg-warning');
                        modalLabel.text('Create Guide');
                        formButton.addClass('btn-submit').removeClass('btn-update').text('Create');
                        modal.modal('show');
                    });

                    $(document).on('click', '.guideContentBtn', function() {
                        $('#guideContentModal').modal('show');
                        $('.modal-title').text($(this).find('.guide-type p').text().toUpperCase());
                        $('#guideContentSection').text($(this).find('#guideContent').val());
                    });

                    $(document).on('click', '#updateGuideBtn', function() {
                        guideWidget = $(this).closest('.guide-widget');
                        guideItem = guideWidget.find('.guide-item');
                        guideId = guideWidget.find('#guideId').val();
                        modalLabelContainer.addClass('bg-warning');
                        modalLabel.text('Update Guide');
                        formButton.addClass('btn-update').removeClass('btn-submit').text('Update');
                        $('#label').val(guideItem.find('p').text());
                        $('#content').val(guideWidget.find('#guideContent').val());
                        operation = "update";
                        modal.modal('show');
                        defaultFormData = $('#guideForm').serialize();
                    });

                    $(document).on('click', '#removeGuideBtn', function() {
                        guideWidget = $(this).closest('.guide-widget');
                        guideItem = guideWidget.find('.guide-item');
                        guideId = guideWidget.find('#guideId').val();

                        confirmModal('Do you want to remove this guide?').then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: guideId,
                                    url: "{{ route('guide.remove', 'guideId') }}".replace('guideId',
                                        guideId),
                                    type: "PATCH",
                                    success(response) {
                                        return response.status == 'warning' ? showWarningMessage(
                                            response.message) : showSuccessMessage(
                                            'Guide removed successfully, Please wait...', true);
                                    },
                                    error() {
                                        showErrorMessage();
                                    }
                                });
                            }
                        });
                    });

                    function guideFormHandler(form) {
                        let formData = $(form).serialize();
                        let url = operation == 'create' ? "{{ route('guide.create', 'guidelineId') }}".replace(
                            'guidelineId', guidelineId) : "{{ route('guide.update', 'guideId') }}".replace(
                            'guideId', guideId);
                        let type = operation == 'create' ? "POST" : "PUT";

                        confirmModal(`Do you want to ${operation} this guide?`).then((result) => {
                            if (!result.isConfirmed) return;

                            return operation == 'update' && defaultFormData == formData ? showWarningMessage(
                                    'No changes were made.') :
                                $.ajax({
                                    data: formData,
                                    url: url,
                                    type: type,
                                    success(response) {
                                        return response.status == 'warning' ? showWarningMessage(response
                                            .message) : (showSuccessMessage(
                                                `Guide successfully ${operation}d, Please wait...`, true),
                                            modal.modal('hide'))
                                    },
                                    error() {
                                        showErrorMessage();
                                    }
                                });
                        });
                    }

                    modal.on('hidden.bs.modal', () => {
                        validator.resetForm();
                        $('#guideForm')[0].reset();
                    });
                });
            </script>
        @endif
    @endauth
</body>

</html>
