<div class="modal fade " id="evacueeInfoFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-center bg-green-700">
                <h1 class="modal-title fs-5 text-center text-white font-extrabold"></h1>
            </div>
            <div class="modal-body">
                <form id="evacueeInfoForm">
                    @csrf
                    <div class="bg-slate-50 pt-3 pb-2 rounded">
                        <div class="flex-auto">
                            <div class="flex flex-wrap">
                                <div class="w-full px-4 hidden">
                                    <div class="relative w-full mb-3">
                                        <input type="text" id="operation"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100">
                                    </div>
                                </div>
                                <div class="w-full lg:w-3/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label>House Hold #</label>
                                        <input type="number" name="houseHoldNumber"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100"
                                            autocomplete="off" placeholder="HH#">
                                    </div>
                                </div>
                                <div class="w-full lg:w-9/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label>Full Name</label>
                                        <input type="text" name="fullName"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100"
                                            autocomplete="off" placeholder="Enter Full Name"
                                            value="{{ !empty(old('fullName')) ? old('fullName') : null }}">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label>Sex</label>
                                        <select name="sex"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                            <option value="">Select Sex</option>
                                            <option value="Male">
                                                Male
                                            </option>
                                            <option value="Female">
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label>Age</label>
                                        <input type="number" name="age"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100"
                                            autocomplete="off" placeholder="Enter Age">
                                    </div>
                                </div>
                                <div class="flex w-full" id="dateFormFieldsContainer">
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label>Date Entry</label>
                                            <input type="text" name="dateEntry" id="dateEntry"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100"
                                                autocomplete="off" placeholder="Select Date Entry">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label>Date Out</label>
                                            <input type="text" name="dateOut" id="dateOut"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100"
                                                autocomplete="off" placeholder="Select Date Out">
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label>Barangay</label>
                                        <select name="barangay"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
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
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label>Disaster</label>
                                        <select name="disasterType" id="disasterType"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                            <option value="">Select Disaster</option>
                                            @if ($disasterList != null)
                                                @foreach ($disasterList as $disaster)
                                                    <option value="{{ $disaster->type }}">
                                                        {{ $disaster->type }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full px-4 hidden" id="typhoonSelectContainer">
                                    <div class="relative w-full mb-3">
                                        <select name="typhoon" id="typhoon"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                            <option value="">Select Typhoon</option>
                                            @foreach ($typhoonList as $typhoon)
                                                <option value="{{ $typhoon->id }}">
                                                    {{ $typhoon->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full px-4 hidden" id="flashfloodSelectContainer">
                                    <div class="relative w-full mb-3">
                                        <select name="flashflood" id="flashflood"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                            <option value="">Select Flashflood</option>
                                            @foreach ($flashfloodList as $flashflood)
                                                <option value="{{ $flashflood->id }}">
                                                    {{ $flashflood->location }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full px-4 hidden">
                                    <div class="relative w-full mb-3">
                                        <input type="text" name="disasterInfo"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150 placeholder-opacity-100">
                                    </div>
                                </div>
                                <div class="w-full px-4">
                                    <div class="relative w-full mb-3">
                                        <label>Evacuation Assigned</label>
                                        <select name="evacuationAssigned"
                                            class="border-2 border-slate-400 px-3 my-2 h-11 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                            <option value="">Select Evacuation Assigned</option>
                                            @foreach ($evacuationList as $evacuationCenter)
                                                <option value="{{ $evacuationCenter->name }}">
                                                    {{ $evacuationCenter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full px-4">
                                    <div class=" d-flex justify-content-around flex-wrap items-center mb-3">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="fourps" name="fourps" class="w-5 h-5">
                                            <label>4ps</label>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="pwd" name="pwd" class="w-5 h-5">
                                            <label>PWD</label>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="pregnant" name="pregnant" class="w-5 h-5">
                                            <label>Pregnant</label>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="lactating" name="lactating" class="w-5 h-5">
                                            <label>Lactating</label>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="student" name="student" class="w-5 h-5">
                                            <label>Student</label>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="working" name="working" class="w-5 h-5">
                                            <label>Working</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-4 ">
                                    <div class="relative w-full ">
                                        <button id="saveEvacueeInfoBtn"
                                            class="bg-green-700 hover:bg-green-800 text-white p-2 py-2 rounded shadow-lg transition duration-200 float-right mb-3">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
