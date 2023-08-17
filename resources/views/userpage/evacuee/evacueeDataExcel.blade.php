<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evacuee Data</title>
</head>

<body>
    <p>CITY OF CABUYAO</p>
    <p>CITY SOCIAL WELFARE AND DEVELOPMENT OFFICE (CSWDO)</p>
    <p>MONITORING OF EVACUEES AFFECTED OF {{ strtoupper($onGoingDisaster) }}</p>
    <p>AS OF {{ date('F d, Y h:i A') }}</p>
    <p>INSIDE ECS</p>
    <table class="table">
        <thead>
            <tr>
                <th>BARANGAY</th>
                <th>TIME AND DATE</th>
                <th>NAME OF EVACUATION</th>
                <th>FAMILY / <br> FAMILIES</th>
                <th>NO. OF <br> INDIVIDUALS</th>
                <th>MALE</th>
                <th>FEMALE</th>
                <th>SENIOR <br> CITIZEN</th>
                <th>MINORS</th>
                <th>INFANTS</th>
                <th>PWD</th>
                <th>PREGNANT</th>
                <th>LACTATING</th>
                <th>REMARKS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evacueeData as $evacuee)
                <tr>
                    <td data-column="Barangay">{{ $evacuee->barangay }}</td>
                    <td data-column="Time and Date">As of {{ $evacuee->date_entry }}</td>
                    <td data-column="Name of Evacuation">{{ $evacuee->evacuation_assigned }}</td>
                    <td data-column="Family/Families">{{ $evacuee->families }}</td>
                    <td data-column="No. of Individuals">{{ $evacuee->individuals }}</td>
                    <td data-column="Male">{{ $evacuee->male }}</td>
                    <td data-column="Female">{{ $evacuee->female }}</td>
                    <td data-column="Senior Citizen">{{ $evacuee->senior_citizen }}</td>
                    <td data-column="Minors">{{ $evacuee->minors }}</td>
                    <td data-column="Infants">{{ $evacuee->infants }}</td>
                    <td data-column="Pwd">{{ $evacuee->pwd }}</td>
                    <td data-column="Pregnant">{{ $evacuee->pregnant }}</td>
                    <td data-column="Lactating">{{ $evacuee->lactating }}</td>
                    <td data-column="Remarks">{{ $evacuee->remarks }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td></td>
                <td>{{ $totalEvacuationCenter }} Active Evacuation Sites</td>
                <td>{{ $totalFamilies }}</td>
                <td>{{ $totalIndividuals }}</td>
                <td>{{ $totalMale }}</td>
                <td>{{ $totalFemale }}</td>
                <td>{{ $totalSeniorCitizen }}</td>
                <td>{{ $totalMinors }}</td>
                <td>{{ $totalInfants }}</td>
                <td>{{ $totalPwd }}</td>
                <td>{{ $totalPregnant }}</td>
                <td>{{ $totalLactating }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
