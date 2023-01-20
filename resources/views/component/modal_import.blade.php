<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-import"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)">
                <div class="modal-body text-center">
                    <h5 class="text-center"><i class="flaticon-file-1 fa-3x"></i></h5>
                    <h6 class="text-center">Pilih File yang ingin di import</h6>
                    <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        </button>
                        <span class="text-center">[Hanya format xls, xlsx dan csv yang didukung]</span>
                        <p class="mb-0">Ukuran maksimal file 5 MB</p>
                    </div>
                    <h5>Download Template Import</h5>
                    <p><a href="{{ $import['template'] }}" class="tooltip-test" data-toggle="m-tooltip"
                            title="Download Template Excel">Unduh
                            Template</a> untuk mendapatkan template import.</p>
                    <div class="m-dropzone dropzone" action="{{ $import['upload'] }}" id="m-dropzone-one">
                        <div class="m-dropzone__msg dz-message needsclick">
                            <h3 class="m-dropzone__msg-title">Seret file Excel untuk upload.</h3>
                            <span class="m-dropzone__msg-desc">This is just a demo dropzone. Selected files are
                                <strong>not</strong> actually uploaded.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    @include('package.dropzone.dropzone_js')
@endpush
