<div class="modal fade " id="evacueeInfoFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-center bg-green-600">
                <h1 class="modal-title fs-5 text-center text-white font-extrabold"></h1>
            </div>
            <div class="modal-body">
                <form id="evacueeInfoForm">
                    @csrf
                    <div class="bg-slate-50 pt-3 pb-2 rounded">
                        <div class="flex-auto">
                            <div class="flex flex-wrap">
                                <div class="input-container hidden">
                                    <input type="text" id="operation" class="placeholder-opacity-100">
                                </div>
                                <div class="relative w-full mb-3 lg:w-3/12 px-4">
                                    <label>House Hold #</label>
                                    <input type="number" name="houseHoldNumber" class="placeholder-opacity-100"
                                        autocomplete="off" placeholder="HH#">
                                </div>
                                <div class="relative w-full mb-3 lg:w-9/12 px-4">
                                    <label>Full Name</label>
                                    <input type="text" name="fullName" class="placeholder-opacity-100"
                                        autocomplete="off" placeholder="Enter Full Name"
                                        value="{{ !empty(old('fullName')) ? old('fullName') : null }}">
                                </div>
                                <div class="relative w-full mb-3 lg:w-6/12 px-4">
                                    <label>Sex</label>
                                    <select name="sex">
                                        <option value="">Select Sex</option>
                                        <option value="Male">
                                            Male
                                        </option>
                                        <option value="Female">
                                            Female
                                        </option>
                                    </select>
                                </div>
                                <div class="relative w-full mb-3 lg:w-6/12 px-4">
                                    <label>Age</label>
                                    <input type="number" name="age" class="placeholder-opacity-100"
                                        autocomplete="off" placeholder="Enter Age">
                                </div>
                                <div class="flex w-full" id="dateFormFieldsContainer">
                                    <div class="relative w-full mb-3 lg:w-6/12 px-4">
                                        <label>Date Entry</label>
                                        <input type="text" name="dateEntry" id="dateEntry"
                                            class="placeholder-opacity-100" autocomplete="off"
                                            placeholder="Select Date Entry">
                                    </div>
                                    <div class="relative w-full mb-3 lg:w-6/12 px-4">
                                        <label>Date Out</label>
                                        <input type="text" name="dateOut" id="dateOut"
                                            class="placeholder-opacity-100" autocomplete="off"
                                            placeholder="Select Date Out">
                                    </div>
                                </div>
                                <div class="relative w-full mb-3 lg:w-6/12 px-4">
                                    <label>Barangay</label>
                                    <select name="barangay">
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
                                <div class="relative w-full mb-3 lg:w-6/12 px-4">
                                    <label>Disaster</label>
                                    <select name="disasterType" id="disasterType">
                                        <option value="">Select Disaster</option>
                                        @if ($disasterList != null)
                                            @foreach ($disasterList as $disaster)
                                                <option value="{{ $disaster->type }}">
                                                    {{ $disaster->type }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="input-container hidden" id="typhoonSelectContainer">
                                    <select name="typhoon" id="typhoon">
                                        <option value="">Select Typhoon</option>
                                        @foreach ($typhoonList as $typhoon)
                                            <option value="{{ $typhoon->id }}">
                                                {{ $typhoon->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full px-4 hidden" id="flashfloodSelectContainer">
                                    <div class="relative w-full mb-3">
                                        <select name="flashflood" id="flashflood">
                                            <option value="">Select Flashflood</option>
                                            @foreach ($flashfloodList as $flashflood)
                                                <option value="{{ $flashflood->id }}">
                                                    {{ $flashflood->location }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-container hidden">
                                    <input type="text" name="disasterInfo" class="placeholder-opacity-100">
                                </div>
                                <div class="input-container">
                                    <label>Evacuation Assigned</label>
                                    <select name="evacuationAssigned">
                                        <option value="">Select Evacuation Assigned</option>
                                        @foreach ($evacuationList as $evacuationCenter)
                                            <option value="{{ $evacuationCenter->name }}">
                                                {{ $evacuationCenter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full px-4">
                                    <div class="flex justify-around flex-wrap items-center mb-3">
                                        <div class="check-box">
                                            <input type="checkbox" id="fourps" name="fourps">
                                            <label>4ps</label>
                                        </div>
                                        <div class="check-box">
                                            <input type="checkbox" id="pwd" name="pwd">
                                            <label>PWD</label>
                                        </div>
                                        <div class="check-box">
                                            <input type="checkbox" id="pregnant" name="pregnant">
                                            <label>Pregnant</label>
                                        </div>
                                        <div class="check-box">
                                            <input type="checkbox" id="lactating" name="lactating">
                                            <label>Lactating</label>
                                        </div>
                                        <div class="check-box">
                                            <input type="checkbox" id="student" name="student">
                                            <label>Student</label>
                                        </div>
                                        <div class="check-box">
                                            <input type="checkbox" id="working" name="working">
                                            <label>Working</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative w-full px-4">
                                    <button id="saveEvacueeInfoBtn"
                                        class="bg-green-600 hover:bg-green-700 text-white p-2 rounded shadow-lg transition duration-200 float-right mb-3">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
