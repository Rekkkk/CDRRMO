@auth
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Caguidelines') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="guideline_description" class="flex items-center justify-center">Guidelines Description</label>
                        <input type="text" name="guidelines_description" class="form-control" autocomplete="off" placeholder="ex. typhooon guidlines">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Publish Guidelines</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth