<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
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
            <div class="swiper guide-section">
                <div class="swiper-wrapper">
                    @foreach ($guide as $guide)
                        <div class="swiper-slide">
                            <div class="guide-content">
                                <div class="guide-header">
                                    <img src="{{ asset("guide_photo/$guide->guide_photo") }}">
                                </div>
                                <div class="guide-details">
                                    <h1>{{ $guide->label }}</h1>
                                    <p>{{ $guide->content }}</p>
                                </div>
                                @auth
                                    @if (auth()->user()->is_disable == 0)
                                        <div class="guide-btn-container">
                                            <div class="guide-update-btn">
                                                <button class="btn-update" id="updateGuideBtn">
                                                    <i class="bi bi-pencil-square"></i> Update
                                                </button>
                                            </div>
                                            <div class="guide-remove-btn">
                                                <button class="btn-remove" id="removeGuideBtn">
                                                    <i class="bi bi-trash3-fill"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="text" id="guideContent" value="{{ $guide->content }}" hidden>
                                    <input type="text" id="guideId" value="{{ $guide->id }}" hidden>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @include('userpage.changePasswordModal')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
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
                    var swiper = new Swiper(".guide-section", {
                        grabCursor: true,
                        centeredSlides: true,
                        slidesPerView: 1,
                        spaceBetween: 50,
                        freeMode: true,
                        breakpoints: {
                            1200: {
                                slidesPerView: 3
                            }
                        }
                    });

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

                    $(document).on('click', '#updateGuideBtn', function() {
                        guideWidget = $(this).closest('.swiper-slide');
                        guideContent = guideWidget.find('.guide-content');
                        guideId = guideWidget.find('#guideId').val();
                        modalLabelContainer.addClass('bg-warning');
                        modalLabel.text('Update Guide');
                        formButton.addClass('btn-update').removeClass('btn-submit').text('Update');
                        $('#label').val(guideContent.find('h1').text());
                        $('#content').val(guideWidget.find('#guideContent').val());
                        operation = "update";
                        modal.modal('show');
                        defaultFormData = $('#guideForm').serialize();
                    });

                    $(document).on('click', '#removeGuideBtn', function() {
                        guideWidget = $(this).closest('.swiper-slide');
                        guideItem = guideWidget.find('.guide-item');
                        guideId = guideWidget.find('#guideId').val();

                        confirmModal('Do you want to remove this guide?').then((result) => {
                            if (!result.isConfirmed) return;

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: guideId,
                                url: "{{ route('guide.remove', 'guideId') }}".replace(
                                    'guideId',
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
                        });
                    });

                    function guideFormHandler(form) {
                        let formData = $(form).serialize();

                        confirmModal(`Do you want to ${operation} this guide?`).then((result) => {
                            if (!result.isConfirmed) return;

                            return operation == 'update' && defaultFormData == formData ? showWarningMessage(
                                    'No changes were made.') :
                                $.ajax({
                                    data: formData,
                                    url: "{{ route('guide.update', 'guideId') }}".replace('guideId', guideId),
                                    type: "PUT",
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
