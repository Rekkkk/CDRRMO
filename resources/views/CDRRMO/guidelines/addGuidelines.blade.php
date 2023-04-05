<div class="modal fade" id="add" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'Caguide'])!!}
                    @method('GET')
                    @csrf
                    <div class="mb-3">
                        {!! Form::label('guideline_description', 'Guidelines Description', ['class' => 'flex items-center justify-center']) !!}
                        {!! Form::text('guidelines_description', '', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter Guideline Description']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('guideline_content', 'Guidelines Content', ['class' => 'flex items-center justify-center']) !!}
                        {!! Form::textArea('guidelines_content', '', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter Guideline Content']) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                        {{ Form::button('Publish Guidelines', ['class' => 'bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200', 'type' => 'submit']) }}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>