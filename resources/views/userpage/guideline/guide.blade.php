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
                        <i class="bi bi-file-earmark-richtext p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">GUIDES</span>
            </div>
            <hr class="mt-4">
            <div class="guide-btn flex justify-end my-3">
                @can('create', \App\Models\User::class)
                    <a href="javascript:void(0)" id="createGuideBtn" class="btn-submit p-2 font-medium">
                        <i class="bi bi-plus-lg mr-2"></i> Create Guide
                    </a>
                    <input type="text" class="guidelineId" value="{{ $guidelineId }}" hidden>
                    @include('userpage.guideline.guideModal')
                @endcan
            </div>
            <div class="guide-container">
                @foreach ($guide as $guide)
                    <div class="guide-widget">
                        @can('view', \App\Models\User::class)
                            @can('alter', \App\Models\User::class)
                                <a href="javascript:void(0)" class="absolute top-2 right-0" id="removeGuideBtn">
                                    <i class="bi bi-x-lg cursor-pointer p-2.5"></i>
                                </a>
                                <a href="javascript:void(0)" class="absolute left-2 top-3" id="updateGuideBtn">
                                    <i class="btn-edit bi bi-pencil p-2"></i>
                                </a>
                            @endcan
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
                        @endcan
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
            </div>
            @auth
                @include('userpage.changePasswordModal')
            @endauth
        </div>
    </div>

    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @can('view', \App\Models\User::class)
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
        @include('partials.toastr')
        <script>
            $(document).ready(function() {
                let guideId, guideWidget, guideItem, defaultFormData, guidelineId = $('.guidelineId').val();

                let validator = $("#guideForm").validate({
                    rules: {
                        label: {
                            required: true
                        },
                        content: {
                            required: true
                        }
                    },
                    messages: {
                        label: {
                            required: 'Please Enter Guide Label.'
                        },
                        content: {
                            required: 'Please Enter Guide Content.'
                        }
                    },
                    errorElement: 'span',
                    submitHandler: guideFormHandler
                });

                $('#createGuideBtn').click(function() {
                    $('#createGuideForm').trigger("reset");
                    $('#operation').val('create');
                    $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                    $('.modal-title').text('Create Guide Form');
                    $('#submitGuideBtn').removeClass('btn-edit').addClass('btn-submit').text('Create');
                    $('#guideModal').modal('show');
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
                    $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                    $('.modal-title').text('Update Guide Form');
                    $('#submitGuideBtn').removeClass('btn-submit').addClass('btn-edit').text('Update');
                    $('#label').val(guideItem.find('p').text());
                    $('#content').val(guideWidget.find('#guideContent').val());
                    $('#operation').val('update');
                    $('#guideModal').modal('show');
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
                                data: {
                                    guideId: guideId
                                },
                                url: "{{ route('guide.remove', ':guideId') }}"
                                    .replace(':guideId', guideId),
                                type: "PATCH",
                                success: function(response) {
                                    if (response.status == 'warning') {
                                        toastr.warning(response.message, 'Error');
                                    } else {
                                        toastr.success(
                                            'Guide removed successfully, Please wait...',
                                            'Success', {
                                                onHidden: function() {
                                                    location.reload();
                                                }
                                            });
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
                });

                function guideFormHandler(form) {
                    let operation = $('#operation').val(),
                        url = "",
                        type = "",
                        formData = $(form).serialize();

                    url = operation == 'create' ? "{{ route('guide.create', 'guidelineId') }}".replace(
                        'guidelineId', guidelineId) : "{{ route('guide.update', 'guideId') }}".replace(
                        'guideId', guideId);

                    type = operation == 'create' ? "POST" : "PUT";

                    confirmModal(`Do you want to ${operation} this guide?`).then((result) => {
                        if (result.isConfirmed) {
                            if (operation == 'update' && defaultFormData == formData) {
                                $('#guideModal').modal('hide');
                                toastr.warning('No changes were made.', 'Warning');
                                return;
                            }
                            $.ajax({
                                data: formData,
                                url: url,
                                type: type,
                                success: function(response) {
                                    if (response.status == 'warning') {
                                        toastr.warning(response.message, 'Warning');
                                    } else {
                                        toastr.success(
                                            `Guide successfully ${operation}d, Please wait...`,
                                            'Success', {
                                                onHidden: function() {
                                                    location.reload();
                                                }
                                            });
                                        $('#guideForm')[0].reset();
                                        $('#guideModal').modal('hide');
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
    @endcan
</body>

</html>
