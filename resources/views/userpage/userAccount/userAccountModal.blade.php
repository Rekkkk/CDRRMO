<div class="modal fade" id="userAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-label-container">
                <h1 class="modal-label"></h1>
            </div>
            <div class="modal-body">
                <form id="accountForm">
                    @csrf
                    <div class="form-content">
                        <input type="text" id="accountId" hidden>
                        <input type="text" id="account_operation" hidden>
                        @if (auth()->user()->position == 'President' || auth()->user()->position == 'Focal')
                            <div class="field-container" id="organization-container">
                                <label>Organization</label>
                                <select type="text" name="organization" class="form-select" id="organization"
                                    placeholder="Enter Organization">
                                    <option value="" hidden selected disabled>Select Organization</option>
                                    <option value="CDRRMO">CDRRMO</option>
                                    <option value="CSWD">CSWD</option>
                                </select>
                            </div>
                            <div class="field-container" id="position-container">
                                <label>Position</label>
                                <select type="text" name="position" class="form-select" id="position"
                                    placeholder="Enter Position">
                                    <option value="" hidden selected disabled>Select Position</option>
                                    <option value="President">President</option>
                                    <option value="Focal">Focal</option>
                                </select>
                            </div>
                            <div class="field-container" id="suspend-container">
                                <label>Suspend Time</label>
                                <input type="text" name="suspend_time" class="form-control cursor-pointer"
                                    id="suspend" placeholder="Select Suspend Time" autocomplete="off">
                            </div>
                        @else
                            <input type="hidden" name="organization" class="form-control" id="organization">
                            <input type="hidden" name="position" class="form-control" id="position">
                        @endif
                        <div class="field-container" id="email-container">
                            <label>Email Address</label>
                            <input type="text" name="email" class="form-control" id="email"
                                placeholder="Enter Email Address">
                        </div>
                        <div class="form-button-container">
                            <button id="saveProfileDetails" class="btn-submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
