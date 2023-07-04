<div class="modal fade" id="edit{{ $guide->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-yellow-500">
                <h1 class="modal-title fs-5 text-center text-white">Update Guide Form</h1>
            </div>
            <div class="modal-body">
                <form action="{{ route('guide.update', $guide->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="flex items-center justify-center">Guide
                            Desctription</label>
                        <input type="text" name="label" value="{{ $guide->label }}" class="form-control"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="flex items-center justify-center">Guide Content</label>
                        <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5">{{ $guide->content }}</textarea>
                    </div>
                    <div class="modal-footer text-white">
                        <button type="submit" class="btn-edit bg-yellow-500 p-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
