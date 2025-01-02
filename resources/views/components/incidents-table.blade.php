@props(['label', 'datas' => null])
<div class="container mt-2 table-container">   
    <div class="mb-1 d-flex justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <input type="month" id="reportMonth" class="form-control w-50" placeholder="Select month">
            <a href="#" class="btn btn-primary" id="generateReportLink">Generate Report</a>
        </div>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">  
    </div>
    <div class="table-responsive">
        <table id="assistance-table" class="table table-hover table-borderless">
            <thead class="rounded-top">
                <tr>
                    <th scope="col" class="p-3 rounded-start bg-primary text-white">Date</th>
                    <th scope="col" class="p-3 bg-primary text-white">Reporter Name</th>
                    <th scope="col" class="p-3 bg-primary text-white d-none d-sm-table-cell">Reporter Contact No.</th>
                    <th scope="col" class="p-3 bg-primary text-white">Case</th>
                    <th scope="col" class="p-3 bg-primary text-white">Reference Code</th>
                    <th scope="col" class="p-3 bg-primary text-white">Status</th>
                    <th scope="col" class="p-3 rounded-end bg-primary text-white">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($datas as $data)
                    <tr data-case="{{ $data->incidentCase->id }}" data-reportid="{{ $data->reportID }}">
                        <td class="p-3 rounded-start">
                            {{ \Carbon\Carbon::parse($data->date)->format('M d, Y') }}
                        </td>
                        <td class="p-3">{{ $data->reporterFullName }}</td>
                        <td class="p-3 d-none d-sm-table-cell">{{ $data->reporterContactNumber }}</td>
                        <td class="p-3">{{ $data->incidentCase->description }}</td>
                        <td class="p-3">{{ $data->referenceCode }}</td>
                        <td class="p-3">{{ $data->isConfirmed == 1 ? 'Confirmed' : 'Pending' }}</td>
                        <td class="p-3 rounded-end">
                            <a class="btn btn-sm btn-secondary text-white" href="{{ route('incident_report.show', ['case' => $data->incidentCase->id, 'id' => $data->reportID]) }}">
                                <i class="bi bi-pencil-square"></i>
                                <span class="d-none d-sm-inline">View</span>
                            </a>
                            @if(Auth::check() && Auth::user()->role == 1)
                                <a class="btn btn-sm btn-danger text-white my-2" href="" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $data->reportID }}').submit();">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span class="d-none d-sm-inline">Delete</span>
                                </a>
                                <form id="delete-form-{{ $data->reportID }}" action="{{ route('incident_report.delete', ['case' => $data->incidentCase->id, 'id' => $data->reportID]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form> 
                            @endif     
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="pagination-container">
        <ul class="pagination justify-content-end" id="pagination"></ul>
    </nav>
</div>

@section('js')
<script src="{{ asset('js/searchbox-table.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
{{-- for pagination --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($datas); 
        paginateTable('assistance-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "assistance-table");
        });
    });
</script>
{{-- for searchbox --}}
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchTable("searchInput", "assistance-table");
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($datas); 
        paginateTable('assistance-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "assistance-table");
        });
    });
</script>

<script>
    document.getElementById('generateReportLink').addEventListener('click', function (event) {
        event.preventDefault();

        const month = document.getElementById('reportMonth').value;
        if (!month) {
            const toastContainer = document.querySelector('.toast-container');
            const toastBody = toastContainer.querySelector('.toast-body');
            toastBody.innerHTML = '<i class="bi bi-check-circle-fill p-2"></i>Please select a month first.';
            
            const toast = new bootstrap.Toast(document.getElementById('myToast'));
            toast.show();
            return;
        }
        const url = `incident-reports/monthly-report?month=${month}`;
        window.location.href = url; 
    });
</script>
@endsection

