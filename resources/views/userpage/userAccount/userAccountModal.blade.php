<div class="modal fade" id="userAccountModal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-center text-white"></h1>
            </div>
            <div class="modal-body">
                <form id="accountForm">
                    @csrf
                    <input type="text" id="accountId" hidden>
                    <input type="text" id="operation" hidden>
                    @if (auth()->user()->position == 'President')
                        <div class="mb-3">
                            <label for="organization" class="flex items-center justify-center">Organization</label>
                            <select type="text" name="organization" class="form-control" autocomplete="off"
                                id="organization" placeholder="Enter Organization">
                                <option value="">Select Organization</option>
                                <option value="CDRRMO">CDRRMO</option>
                                <option value="CSWD">CSWD</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="flex items-center justify-center">Position</label>
                            <select type="text" name="position" class="form-control" id="position"
                                autocomplete="off" placeholder="Enter Position">
                                <option value="">Select Position</option>
                                <option value="President">President</option>
                                <option value="Secretary">Secretary</option>
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="organization" class="form-control" id="organization">
                        <input type="hidden" name="position" class="form-control" id="position">
                    @endif
                    <div class="mb-3">
                        <label for="email" class="flex items-center justify-center">Email Address</label>
                        <input type="text" name="email" class="form-control" autocomplete="off" id="email"
                            placeholder="Enter Email Address">
                        <span class="text-danger italic text-sm error-text email_error"></span>
                    </div>

                    <div class="modal-footer">
                        <button id="saveProfileDetails"
                            class="btn-submit p-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
