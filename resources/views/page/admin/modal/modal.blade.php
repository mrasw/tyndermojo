{{-- @foreach ($users as $user)
    <div class="modal fade" id="modal-user-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-md" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div id="modal-header" class="block-header bg-primary-dark">
                        <h3 class="block-title" id="events-title" contenteditable="true">
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
                                <img class="foto" src="{{ $user->getFoto() }}" alt="">
                            </div>
                            <div class="divDesc col-xl-6 col-md-6 col-sm-6" style="padding-top: 5%; padding-bottom: 5%">
                                <p>{{ $user->nama }}</p>
                                <p>{{ $user->tgl_lahir }}</p>
                                <p>{{ $user->pekerjaan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-danger" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach --}}


{{-- @foreach ($users as $user) --}}
    {{-- <div class="modal fade" id="modal-user-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true"> --}}
        <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout modal-md" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div id="modal-header" class="block-header bg-primary-dark">
                            <h3 class="block-title" id="events-title" >
                                {{-- Terms &amp; Conditions --}}
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form action="{{ route('user.update') }}" id="update-target-user" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="number" name="id" id="target-id" type="hidden" style="display: none">
                                <div class="row" style="display:flex">
                                    <div class="divFoto col-xl-6 col-md-6 col-sm-6" style="text-align: center; padding:5%">
                                        <img id="img-preview" class="foto" src="" alt="" style="height: 128px">
                                        <!-- Hidden file input -->
                                        <input type="file" id="img-upload" class="custom-file-input" name="foto" accept="image/*" style="display: none;">
                                    </div>
                                    <div class="divDesc col-xl-6 col-md-6 col-sm-6" style="padding-top: 5%; padding-bottom: 5%">
                                        {{-- <p contenteditable="true" class="nama"></p> --}}
                                        <input name="nama" class="mb-10 form-control target-nama" style="border: none" type="" value="">
                                        
                                        
                                        <input name="tgl_lahir" class="mb-10 form-control target-tgl-lahir" style="border: none" type="text" value= "">
                                        
                                        {{-- <p contenteditable="true" class="pekerjaan"></p> --}}
                                        <input name="pekerjaan" class="form-control target-pekerjaan" style="border: none" type="" value="">
                                        {{-- <p>{{ $user->nama }}</p>
                                        <p>{{ $user->tgl_lahir }}</p>
                                        <p>{{ $user->pekerjaan }}</p> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="block-content">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-alt-danger" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close"></i> Close
                        </button>
                        <button type="button" id="update-user" class="btn btn-alt-success" >
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- @endforeach --}}

<div class="modal fade" id="modal-create-user" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div id="modal-header" class="block-header bg-primary-dark">
                    <h3 class="block-title" id="events-title" >
                        {{-- Terms &amp; Conditions --}}
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="{{ route('user.create') }}" id="create-target-user" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row" style="display:inline; align-items:center;">
                            <div class="divFoto col-xl-12 col-md-12 col-sm-12" style="text-align: center; padding:5%">
                                {{-- <img id="create-img-preview" class="foto" src="" alt="" style="height: 128px">
                                <!-- Hidden file input -->
                                <input type="file" id="create-img-upload" class="custom-file-input" name="foto" accept="image/*" style=""> --}}
                                <div id="dz-upload" class="dropzone" style="">
                                    <div class="dz-default dz-message">
                                        <span>Click or drop to upload image</span>
                                    </div>
                                </div>
                                {{-- <div id="preview-container"></div> --}}
                            </div>
                            <div class="divDesc col-xl-12 col-md-12 col-sm-12 row" style="padding-top: 5%; padding-bottom: 5%">
                                {{-- <p contenteditable="true" class="nama"></p> --}}
                                <div class="form-group col-xl-6 col-md-6 col-sm-6">
                                    <label  for="">Nama</label>
                                    <input name="create-nama" class="mb-10 form-control target-nama col-xl-12 col-md-12 col-sm-12" type="" value="" required>
                                </div>
                                
                                <div class="form-group col-xl-6 col-md-6 col-sm-6">
                                    <label  for="">Tanggal Lahir</label>
                                    <input name="create-tgl_lahir" class="mb-10 form-control target-tgl-lahir col-xl-12 col-md-12 col-sm-12" type="text" value= "" required>
                                </div>
                                
                                <div class="form-group col-xl-6 col-md-6 col-sm-6">
                                    <label  for="">Kelamin</label>
                                    <select name="create-kelamin" class="mb-10 form-control col-xl-12 col-md-12 col-sm-12" id="">
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                
                                {{-- <p contenteditable="true" class="pekerjaan"></p> --}}
                                <div class="form-group col-xl-6 col-md-6 col-sm-6">
                                    <label  for="">Pekerjaan</label>
                                    <input name="create-pekerjaan" class="mb-10 form-control target-pekerjaan col-xl-12 col-md-12 col-sm-12" type="" value="" required>
                                </div>
                                
                                <div class="form-group col-xl-6 col-md-6 col-sm-6">
                                    <label  for="">Nomor Hp</label>
                                    <input name="create-no_hp" class="mb-10 form-control target-no_hp col-xl-12 col-md-12 col-sm-12" type="number" value="" required>
                                </div>
                                {{-- <p>{{ $user->nama }}</p>
                                <p>{{ $user->tgl_lahir }}</p>
                                <p>{{ $user->pekerjaan }}</p> --}}
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="block-content">
                </div> --}}
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-alt-danger" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i> Close
                </button>
                <button type="button" id="create-user" class="btn btn-alt-success" >
                    <i class="fa fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
    