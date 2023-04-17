@auth
<div class="modal fade" id="edit{{ $evacuationList->evacuation_id }}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Cupdateevacuation', $evacuationList->evacuation_id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="evacuation_name" class="flex items-center justify-center">Evacuation Name</label>
                        <input type="text" name="evacuation_name" value="{{ $evacuationList->evacuation_name }}" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="evacuation_contact" class="flex items-center justify-center">Evacuation Contact</label>
                        <input type="text" name="evacuation_contact" value="{{ $evacuationList->evacuation_contact }}" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="evacuation_location" class="flex items-center justify-center">Evacuation Location</label>
                        <input type="text" name="evacuation_location" value="{{ $evacuationList->evacuation_location }}" class="form-control" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Update Evacuation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth