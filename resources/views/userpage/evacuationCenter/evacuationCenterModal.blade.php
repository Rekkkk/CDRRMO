<div class="modal fade" id="evacuationCenterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-center bg-green-600">
                <h1 class="modal-title fs-5 text-center text-white font-extrabold"></h1>
            </div>
            <div class="modal-body">
                <form id="evacuationCenterForm">
                    @csrf
                    <div class="bg-slate-50 pt-3 pb-2 rounded">
                        <div class="flex-auto">
                            <div class="flex flex-wrap">
                                <div class="field-container hidden">
                                    <input type="text" id="operation">
                                </div>
                                <div class="field-container">
                                    <label>Name</label>
                                    <input type="text" name="name" class="placeholder-opacity-100"
                                        autocomplete="off" placeholder="Enter Name">
                                </div>
                                <div class="field-container">
                                    <label>Barangay</label>
                                    <select name="barangay_name" class="form-select">
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
                                <div class="field-container">
                                    <label>Latitude</label>
                                    <input type="text" name="latitude" autocomplete="off"
                                        placeholder="Enter Latitude">
                                </div>
                                <div class="field-container">
                                    <label>Longitude</label>
                                    <input type="text" name="longitude" autocomplete="off"
                                        placeholder="Enter Longitude">
                                </div>
                                <div class="field-container" id="status-container">
                                    <label>Status</label>
                                    <input type="text" name="status" autocomplete="off" placeholder="Enter status">
                                </div>
                                <div class="w-full px-4">
                                    <button id="saveEvacuationCenterBtn"
                                        class="btn-submit p-2 float-right mb-3">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
