<div class="modal fade" id="evacuationCenterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-center text-white"></h1>
            </div>
            <div class="modal-body">
                <form id="evacuationCenterForm">
                    @csrf
                    <input type="text" id="operation" hidden>
                    <div class="mb-3">
                        <label for="name" class="flex items-center justify-center">Evacuation Center Name</label>
                        <input type="text" name="name" class="form-control" id="name" autocomplete="off"
                            placeholder="Enter Evacuation Center Name">
                    </div>
                    <div class="relative w-full mb-3">
                        <label for="barangay_name" class="flex items-center justify-center">Barangay Name</label>
                        <select name="barangay_name" class="form-control" id="barangay_name">
                            <option value="">Select Barangay</option>
                            <option value="Baclaran">Baclaran</option>
                            <option value="Banay-Banay">Banay-Banay</option>
                            <option value="Banlic">Banlic</option>
                            <option value="Bigaa">Bigaa</option>
                            <option value="Butong">Butong</option>
                            <option value="Casile">Casile</option>
                            <option value="Diezmo">Diezmo</option>
                            <option value="Gulod">Gulod</option>
                            <option value="Mamatid">Mamatid</option>
                            <option value="Marinig">Marinig</option>
                            <option value="Niugan">Niugan</option>
                            <option value="Pittland">Pittland</option>
                            <option value="Pulo">Pulo</option>
                            <option value="Sala">Sala</option>
                            <option value="San Isidro">San Isidro</option>
                            <option value="Barangay I Poblacion">Barangay I Poblacion</option>
                            <option value="Barangay II Poblacion">Barangay II Poblacion</option>
                            <option value="Barangay III Poblacion">Barangay III Poblacion</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="flex items-center justify-center">Latitude</label>
                        <input type="text" name="latitude" class="form-control" id="latitude" autocomplete="off"
                            placeholder="Enter Latitude">
                    </div>
                    <div class="mb-3">
                        <label for="Longitude" class="flex items-center justify-center">Longitude</label>
                        <input type="text" name="longitude" class="form-control" autocomplete="off" id="longitude"
                            placeholder="Enter Longitude">
                    </div>
                    <div class="mb-3" id="status-container">
                        <label for="status" class="flex items-center justify-center">Status</label>
                        <input type="text" name="status" class="form-control" id="status" autocomplete="off"
                            placeholder="Enter status">
                    </div>
                    <div class="modal-footer">
                        <button id="saveEvacuationCenterBtn" class="btn-submit p-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
