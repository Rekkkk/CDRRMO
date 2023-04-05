<div class="modal fade" id="edit{{ $disasterList->disaster_number }}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {!! Form::model($disasterList, ['method' => 'get', 'route' => ['Cupdatedisaster', $disasterList->disaster_number]])!!}
                <div class="mb-3">
                    {!! Form::label('disaster_label', 'Disaster Label', ['class' => 'flex items-center justify-center']) !!}
                    {!! Form::text('disaster_label', $disasterList->disaster_label, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                {{ Form::button('Update Disaster', ['class' => 'bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200', 'type' => 'submit']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>