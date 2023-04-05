<div class="modal fade" id="edit{{ $baranggayList->baranggay_id }}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {!! Form::model($baranggayList, ['method' => 'get', 'route' => ['Cupdatebaranggay', $baranggayList->baranggay_id]])!!}
                <div class="mb-3">
                    {!! Form::label('baranggay_label', 'Baranggay Label', ['class' => 'flex items-center justify-center']) !!}
                    {!! Form::text('baranggay_label', $baranggayList->baranggay_label, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                {{ Form::button('Update Baranggay', ['class' => 'bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200', 'type' => 'submit']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>