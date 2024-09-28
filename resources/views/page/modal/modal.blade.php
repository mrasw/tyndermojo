{{-- @foreach ($users as $user) --}}
    {{-- <div class="modal fade" id="modal-user-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true"> --}}
    <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-md" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div id="modal-header" class="block-header bg-primary-dark">
                        <h3 class="block-title" id="events-title" contenteditable="true">
                            {{-- Terms &amp; Conditions --}}
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row" style="display:flex">
                            <div class="divFoto col-xl-6 col-md-6 col-sm-6" style="text-align: center; padding:5%">
                                <img class="foto" src="{{ $user->getFoto() }}" alt="" style="height: 128px">
                            </div>
                            <div class="divDesc col-xl-6 col-md-6 col-sm-6" style="padding-top: 5%; padding-bottom: 5%">
                                <p>{{ $user->nama }}</p>
                                <p>{{ $user->tgl_lahir }}</p>
                                <p>{{ $user->pekerjaan }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="block-content">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-alt-danger" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
{{-- @endforeach --}}
