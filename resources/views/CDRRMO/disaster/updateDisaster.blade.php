@auth
    <div class="modal fade" id="edit{{ $disasterList->disaster_id }}" tabindex="-1" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red-900">
                    <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Cupdatedisaster', $disasterList->disaster_id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="disaster_type" class="flex items-center justify-center">Disaster Label</label>
                            <input type="text" name="disaster_type" value="{{ $disasterList->disaster_type }}"
                                class="form-control" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Update
                                Disaster</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth
