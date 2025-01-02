@props(['label', 'datas' => null])
<!-- toast notification -->
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="myToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle-fill p-2"></i>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<!-- Wala na nako gi component -->
<div class="container mt-2 table-container">   
    <div class="mb-1 d-flex justify-content-between">
        {{-- <h5 class="p-1 text-secondary">{{ $label }}</h5> --}}
        <div class="d-flex align-items-center gap-2">
            <input type="month" id="reportMonth" class="form-control w-50" placeholder="Select month">
            <a href="#" class="btn btn-primary" id="generateReportLink">Generate Report</a>
        </div>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">  
    </div>
    <table id="responses-table" class="table table-hover table-borderless">
        <thead class="rounded-top">
            <tr>
                <th scope="col" class="p-3 rounded-start bg-primary text-white">Date</th>
                <th scope="col" class="p-3 bg-primary text-white">Patient</th>
                <th scope="col" class="p-3 bg-primary text-white">Case</th>
                <th scope="col" class="p-3 bg-primary text-white d-none d-sm-table-cell" style="display:none">Responders</th>
                <th scope="col" class="p-3 rounded-end bg-primary text-white">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($datas as $data)
                <tr>
                    <td class="p-3 rounded-start">
                        <!-- Carbon is used since date's data type is not 'timestamp' -->
                        {{ \Carbon\Carbon::parse($data->date)->format('M d, Y') }}
                    </td>
                    <td class="p-3">{{ $data->patientName }}</td>
                    <td class="p-3">{{ $data->case->description }}</td>
                    <td class="p-3 d-none d-sm-table-cell">{{ $data->responders }}</td>
                    <td class="p-3 rounded-end">
                        <a class="btn btn-sm btn-secondary -?formattext-white" href="{{ route('response_records.edit', ['id' => $data->responseID]) }}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <nav class="pagination-container">
        <ul class="pagination justify-content-end" id="pagination"></ul>
    </nav>
</div>

<script src="{{ asset('js/searchbox-table.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
 {{-- for pagination --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($datas); 
        paginateTable('responses-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "responses-table");
        });
    });
</script>
 {{-- for searchbox --}}
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchTable("searchInput", "responses-table");
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

        const url = `response-records/monthly-report?month=${month}`;
        window.location.href = url; 
    });
</script>
