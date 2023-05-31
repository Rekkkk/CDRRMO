<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-400">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <div class="main-content pt-8 pr-8 pl-28">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-book text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">Quiz Maker</span>
                <hr class="mt-4">
            </div>

            <div class="content-item">
                <div id="quiz-container">
                    <form action="" id="quiz-form">
                        <div class="flex justify-center align-center">
                            <a href="javascript:void(0)" id="addQuestion"
                                class="font-bold text-xl bg-red-700 mx-2 py-2 px-5 text-white rounded shadow-lg hover:bg-red-900 transition duration-200">
                                +
                            </a>
                        </div>
                        <div id="submit_container"></div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var quiz_container = document.getElementById('quiz-form');
            var add_quiz_btn = document.getElementById('addQuestion');
            var question_number = 1;

            add_quiz_btn.onclick = function() {
                // Containers
                var main_container = document.createElement('div');
                var sub_container = document.createElement('div');
                var child_container = document.createElement('div');

                main_container.setAttribute('class', 'bg-slate-50 p-4 pb-2 mb-2 rounded');
                sub_container.setAttribute('class', 'flex-auto');
                child_container.setAttribute('class', 'flex flex-wrap');
                child_container.setAttribute('id', 'child_container');

                quiz_container.appendChild(main_container);
                main_container.appendChild(sub_container);
                sub_container.appendChild(child_container);

                //Container for input field
                var new_question = document.createElement('div');
                // Label for input field
                var label = document.createElement('label');
                // Input field
                var input = document.createElement('input');
                // Span Error Message for input field
                var error = document.createElement('span');

                label.setAttribute('for', 'Question ' + question_number);
                label.textContent = 'Question ' + question_number;
                input.setAttribute('type', 'text');
                input.setAttribute('name', 'question_' + question_number);
                input.setAttribute('class',
                    'border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150'
                );
                input.setAttribute('autocomplete', 'off');
                error.setAttribute('class', 'text-red-500 text-xs italic error-text first_name_error');

                child_container.appendChild(new_question);
                child_container.appendChild(label);
                child_container.appendChild(input);
                child_container.appendChild(error);

                question_number++;

                //Checking question fields if have an item
                checkQuestionFields();

            }

            function checkQuestionFields() {
                var questionInputs = quiz_container.querySelectorAll('input');
                var emptyQuestionFields = 0;

                questionInputs.forEach(function(input) {
                    if (questionInputs.value === '') {
                        emptyQuestionFields++;
                    }
                });

                if (emptyQuestionFields === 0) {

                    var submitButton = document.createElement('button');
                    submitButton.setAttribute('type', 'submit');
                    submitButton.setAttribute('class',
                        'bg-slate-700 m-2 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200'
                    );
                    submitButton.setAttribute('id', 'submit_quiz_btn');
                    submitButton.textContent = 'Submit Quiz';

                    submit_container.innerHTML = '';
                    submit_container.appendChild(submitButton);

                } else {
                    submit_container.innerHTML = '';
                }
            }
        })
    </script>
</body>

</html>
