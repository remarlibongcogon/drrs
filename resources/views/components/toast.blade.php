@if(session('success'))
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="myToast">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill p-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif