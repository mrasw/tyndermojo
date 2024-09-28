@extends('layouts.index')

@section('additional_style')

    {{-- plugins --}}
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzonejs/dist/dropzone.css') }}">
    {{-- end of plugins --}}

    <style>
        #img-preview {
            cursor: pointer; /* Mengubah kursor menjadi tangan */
        }

        #dz-upload {
            border: 2px dashed #007bff; /* Garis putus-putus berwarna biru */
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        #dz-upload .dz-message {
            font-size: 16px;
            color: #007bff;
        }

        .target-no_hp::-webkit-inner-spin-button, 
        .target-no_hp::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0; 
        }

    </style>
@endsection


@section('content')

    @section('topnavbar')
        @include('partials.topnavbar')
    @endsection

    <main id="main-container">
        <!-- Page Content -->
        <div class="content">

            <div class="js-filter" data-numbers="true" data-speed="400">

                <div class="p-10 bg-white push mb-0">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-category-link="all">
                                All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-category-link="laki-laki">Laki-laki</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-category-link="perempuan">Perempuan</a>
                        </li>
                        <li class="nav-item ml-auto">
                            <button class="btn btn-primary" id="create-new-user" data-toggle="modal" data-target="#modal-create-user">
                                {{-- add user --}}
                                <i class="fa fa-user-plus"></i> Tambah Data
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="row py-30 gutters-tiny">
                    
                    @foreach ($users as $user)
                        <div class=" col-md-3 col-xl-2 col-sm-3" class="" data-category="{{ $user->kelamin }}" >
                            {{-- <a class="block block-link-pop block-rounded block-bordered text-center" data-toggle="modal" data-id="{{ $user->id }}" data-target="#modal-update-user-{{ $user->id }}"  href="javascript:void(0)"> --}}
                            <a class="user-card block block-link-pop block-rounded block-bordered text-center" data-toggle="modal" data-id="{{ $user->id }}" href="javascript:void(0)">
                                <div class="block-content left">
                                    <p>{{ $user->nama }}</p>
                                    <p>{{ $user->tgl_lahir }}</p>
                                    <p>{{ $user->pekerjaan }}</p>
                                </div>
                            </a>
                            
                        </div>
                    @endforeach
    
                </div>
            </div>

        </div>
        <!-- END Page Content -->
    </main>
@endsection

@section('modal')
    @include('page.admin.modal.modal')
@endsection

@section('additional_script')

    {{-- js plugins --}}
    <script src="{{ asset('js/plugins/dropzonejs/dropzone.min.js') }}"></script>
    <script type="text/javascript">// Immediately after the js include
        Dropzone.autoDiscover = false;
    </script>
    {{-- end of js plugins --}}


    <script>

        jQuery(function () {
            // Inisialisasi filter
            initContentFilter();
        });

        function initContentFilter() {
            // Pilih elemen .js-filter
            const $filter = jQuery(".js-filter:not(.js-filter-enabled)");

            if (!$filter.length) return;

            $filter.each(function () {
                const $this = jQuery(this);
                const $navPills = $this.find(".nav-pills");
                const $links = $this.find("a[data-category-link]");
                const $items = $this.find("[data-category]");
                const speed = $this.data("speed") || 200;

                // Tambah class untuk menandai bahwa filter sudah diinisialisasi
                $this.addClass("js-filter-enabled");

                // Resize handler untuk navigasi pills
                handleResize($navPills);

                // Jika data-numbers true, tambahkan jumlah item ke masing-masing kategori
                if ($this.data("numbers")) {
                    $links.each(function () {
                        const $link = jQuery(this);
                        const category = $link.data("category-link");
                        const count = category === "all" ? $items.length : $items.filter(`[data-category="${category}"]`).length;
                        $link.append(` (${count})`);
                    });
                }

                // Event handler untuk filter berdasarkan kategori
                $links.on("click", function (e) {
                    e.preventDefault();
                    const $link = jQuery(this);
                    const category = $link.data("category-link");

                    // Jika link aktif, tidak melakukan apa-apa
                    if ($link.hasClass("active")) return;

                    // Aktifkan link yang dipilih dan nonaktifkan yang lainnya
                    $links.removeClass("active");
                    $link.addClass("active");

                    // Tampilkan atau sembunyikan item berdasarkan kategori
                    if (category === "all") {
                        $items.fadeIn(speed);
                    } else {
                        $items.hide().filter(`[data-category="${category}"]`).fadeIn(speed);
                    }
                });
            });
        }

        // Fungsi resize untuk menambah/menghapus flex-column di nav-pills
        function handleResize($navPills) {
            const toggleFlexColumn = () => {
                if (jQuery(window).width() < 768) {
                    $navPills.addClass("flex-column");
                } else {
                    $navPills.removeClass("flex-column");
                }
            };

            toggleFlexColumn(); // Inisialisasi saat pertama kali

            // Event handler untuk resize dengan debounce sederhana
            let resizeTimer;
            jQuery(window).on("resize", function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(toggleFlexColumn, 150);
            });
        }

        
        $(document).ready(function(){

            // Dropzone.autoDiscover = false;

            $('#create-new-user').on('click', function(e){

                var _dropZone = new Dropzone('#dz-upload', {
                    url: "{{ route('user.create') }}", // Tambahkan URL dummy untuk menghindari error
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    autoProcessQueue: false, // Tidak langsung upload
                    addRemoveLinks: true,
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    init: function() {

                        this.on('addedfile', function () {
                            if (this.files.length > 1) {
                                this.removeAllFiles();
                                // alert('Drop only one file');
                                Swal.fire({
                                    title: "Warning!",
                                    text: "Drop only one file",
                                    icon: "error",
                                });
                            }
                        });

                        var myDropzone = this;
                        $('#create-user').on('click', function(e) {
                            console.log('clicked create');
                            console.log(myDropzone);
                            console.log(myDropzone.files[0]);
                            var formData = new FormData($('#create-target-user')[0]);

                            formData.append('foto', myDropzone.files[0]); // 'file' adalah nama field yang dikirim
                            for (var pair of formData.entries()) {
                                console.log(pair[0] + ', ' + pair[1]); // Menampilkan data dari formData
                            }

                            $.ajax({
                                url: "{{ route('user.create') }}",
                                method: "POST",
                                // headers: {
                                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                // },
                                data: formData,
                                contentType: false, // Tidak perlu content type khusus
                                processData: false, // Jangan proses data, biarkan sebagai FormData
                                success: function(response) {
                                    // Success handling
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Form submitted successfully!",
                                        icon: "success",
                                    }).then(function() {
                                        location.reload(); // Reload page setelah SweetAlert OK
                                    });
                                    // myDropzone.processQueue(); // Upload file Dropzone setelah form submit sukses
                                },
                                error: function(response) {
                                    console.log('Error:', response);
                                }
                            });
                        });

                        
                    },
                    success: function (file, response) {
                        var imgName = response;
                        console.log(response);
                    
                        file.previewElement.classList.add("dz-success");
                        console.log("Successfully uploaded :" + imgName);
                    },
                    error: function (file, response) {
                        console.log(response);
                        console.log(file);
                    
                        file.previewElement.classList.add("dz-error");
                    }
                });
                        
                $('#modal-create-user').on('hidden.bs.modal', function(e){
                    _dropZone.destroy();
                    console.log('modal clossed');
                    
                });
                // });
            });


            String.prototype.filename=function(extension){
                var s= this.replace(/\\/g, '/');
                s= s.substring(s.lastIndexOf('/')+ 1);
                return s;
            }

            $('.target-tgl-lahir').datepicker({
                format: 'dd/mm/yyyy',
            });

            function updateUser(formData){
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: "{{ route('user.update') }}", // Ganti dengan URL endpoint update yang sesuai
                        method: 'POST',
                        data: formData,
                        processData: false, // Jangan proses data, biarkan FormData menangani ini
                        contentType: false, // Jangan tetapkan contentType secara otomatis
                        success: function(response) {
                            // Jika berhasil, resolve promise dengan respons dari server
                            resolve(response);
                        },
                        error: function(err) {
                            // Jika gagal, reject promise dengan error yang didapat
                            reject(err);
                        }
                    });
                });
            }

            function showUser(id, callback){
                let getUserUrl = "{{ route('user.show', '') }}/" + id;
                let userCard = $(this);

                $.ajax({
                    url: getUserUrl,
                    type: 'GET',
                    success: function(response) {

                        let dict = { 'response': response };

                        callback(dict);

                    },
                    error: function(xhr, status, error) {

                        let dict = { 'xhr': xhr, 'status': status, 'error': error };

                        // if (xhr.status === 403) {
                        //     Swal.fire({
                        //         title: "Access Denied!",
                        //         text: "You have already accessed this user",
                        //         icon: "error",
                        //     });
                        // } else if(xhr.status === 500){
                        //     Swal.fire({
                        //         title: "Error!",
                        //         text: "Internal Server Error",
                        //         icon: "error",
                        //     });
                        // } else {
                        //     Swal.fire({
                        //         title: "Error!",
                        //         text: error,
                        //         icon: "error",
                        //     });
                        // }

                        callback(dict);
                    }
                });

            };
            
            $('.user-card').on('click', function(e){
                e.preventDefault()

                showUser($(this).attr('data-id'), function(_targetUser) {

                    if (_targetUser.hasOwnProperty('response')) {

                        $('#modal-user').find('form #target-id').val(_targetUser['response'].id);
                        console.log(_targetUser['response'].foto);
                        $('#modal-user').find('.divFoto img').attr('src', _targetUser['response'].foto );
                        // $('#modal-user').find('.divFoto #img-upload').val(_targetUser['response'].foto );
                        
                        $('#modal-user').find('form .target-nama').val(_targetUser['response'].nama);                        
                        $('.target-tgl-lahir').datepicker("update", _targetUser['response'].tgl_lahir);
                        $('.target-tgl-lahir').datepicker("update",  moment( _targetUser['response'].tgl_lahir, 'YYYY-MM-DD').format('DD/MM/YYYY'));

                        $('#modal-user').find('form .target-pekerjaan').val(_targetUser['response'].pekerjaan);
                        $('#modal-user').modal('show');

                    } else {
                        // console.log("Key 'response' tidak ditemukan.");
                        if (_targetUser['xhr'].status === 403) {
                            Swal.fire({
                                title: "Access Denied!",
                                text: "You have already accessed this user",
                                icon: "error",
                            });
                        } else if(_targetUser['xhr'].status === 500){
                            Swal.fire({
                                title: "Error!",
                                text: "Internal Server Error",
                                icon: "error",
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: _targetUser['error'],
                                icon: "error",
                            });
                        }
                    }
                });
                
            });

            $('#modal-user').on('hidden.bs.modal', function () {
                $('#modal-user').find('.divFoto img').attr('src', '' );
            });

            $('#modal-user').on('shown.bs.modal', function(){
                $('.editable-date').on('click', function() {
                    let currentDate = $(this).text();
                    let input = $('<input>', {
                        type: 'date',
                        value: currentDate,
                        blur: function() {
                            let newDate = $(this).val() || currentDate;
                            $(this).replaceWith(`<p class="editable-date">${newDate}</p>`);
                        },
                        keydown: function(e) {
                            if (e.key === 'Enter') {
                                $(this).blur();
                            }
                        }
                    });
                $(this).replaceWith(input);
                    input.focus();
                });
                // console.log("{{ route('user.update') }}");

                $('#update-user').on('click', function(e){
                    let _targetId = $('#modal-user').find('form #target-id').val();
                    let _newFoto = $('#img-upload').data('file');
                    let _newNama = $('#modal-user').find('form .target-nama').val();
                    let _newTglLahir = $('#modal-user').find('form .target-tgl-lahir').val();
                    let _newPekerjaan = $('#modal-user').find('form .target-pekerjaan').val();

                    console.log('cek file name',_newFoto);
                    if(_newFoto){
                        console.log('masuk ke sini cuy');
                        
                    };
                    console.log(_newNama);
                    console.log(_newTglLahir);
                    console.log(_newPekerjaan);

                    showUser(_targetId, function(_targetUser) {

                        if (_targetUser.hasOwnProperty('response')) {

                            if( _newFoto || _newNama != _targetUser['response'].nama || moment( _newTglLahir, 'DD/MM/YYYY').format('YYYY-MM-DD') != _targetUser['response'].tgl_lahir || _newPekerjaan != _targetUser['response'].pekerjaan){

                                let formData = new FormData();
                                formData.append('id', _targetId);
                                formData.append('foto', _newFoto);
                                formData.append('nama', _newNama);
                                formData.append('tgl_lahir', moment( _newTglLahir, 'DD/MM/YYYY').format('YYYY-MM-DD'));
                                formData.append('pekerjaan', _newPekerjaan);
                                // Tambahkan CSRF token
                                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                formData.append('_token', csrfToken);

                                updateUser(formData)
                                .then(response => {
                                    console.log('update user sukses',response);
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Yeay Update Success",
                                        icon: "success",
                                    }).then(function() {
                                        location.reload(true);
                                    });
                                })
                                .catch(error => {
                                    console.error('update user error',error);
                                    Swal.fire({
                                        title: "Error!",
                                        text: error.response ? error.response.data.message : 'Failed to update user.',
                                        icon: "error",
                                    });
                                });

                                // $('#update-target-user').submit(function(e){
                                //     e.preventDefault()

                                //     updateUser(formData)
                                //     .then(response => {
                                //         // Tangani jika update berhasil
                                //         console.log('update user sukses',response);
                                //         // alert('User updated successfully!');
                                //         Swal.fire({
                                //             title: "Success!",
                                //             text: "Yeay",
                                //             icon: "success",
                                //         });
                                //     })
                                //     .catch(error => {
                                //         // Tangani jika update gagal
                                //         console.error('update user error',error);
                                //         // alert('Failed to update user.');
                                //         Swal.fire({
                                //             title: "Error!",
                                //             text: error,
                                //             icon: "error",
                                //         });
                                //     });
                                // });
                            } else (
                                $('#modal-user').modal('hide')
                            )

                        } else {
                            // console.log("Key 'response' tidak ditemukan.");
                            if (_targetUser['xhr'].status === 403) {
                                Swal.fire({
                                    title: "Access Denied!",
                                    text: "You have already accessed this user",
                                    icon: "error",
                                });
                            } else if(_targetUser['xhr'].status === 500){
                                Swal.fire({
                                    title: "Error!",
                                    text: "Internal Server Error",
                                    icon: "error",
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: _targetUser['error'],
                                    icon: "error",
                                });
                            }
                        }
                    });
                    
                    // $('#update-target-user').submit(function(e){
                    //     e.preventDefault()
                        
                    //     $.ajax({
                    //         url: "{{ route('user.update') }}",
                    //         data: $(this).serialize(),
                    //         type: "POST",
                    //         success: function(success){
                    //             console.log('sukses bang');
                                
                    //             Swal.fire({
                    //                 title: "Success!",
                    //                 text: "Yeay",
                    //                 icon: "success",
                    //             });
                    //         },
                    //         error: function(xhr, status, error){

                    //             if (xhr.status === 403) {
                    //                 Swal.fire({
                    //                     title: "Access Denied!",
                    //                     text: "You have already accessed this user",
                    //                     icon: "error",
                    //                 });
                    //             } else if(xhr.status === 500){
                    //                 Swal.fire({
                    //                     title: "Error!",
                    //                     text: "Internal Server Error",
                    //                     icon: "error",
                    //                 });
                    //             } else {
                    //                 Swal.fire({
                    //                     title: "Error!",
                    //                     text: error,
                    //                     icon: "error",
                    //                 });
                    //             }
                    //         },
                    //     });
                    // });
                });
            });

            // Ketika gambar diklik, trigger input file
            $('#img-preview').on('click', function() {
                $('#img-upload').click();
            });

            // Saat file dipilih, tampilkan preview gambar
            $('#img-upload').on('change', function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    // Set src img menjadi file yang diupload
                    $('#img-preview').css('height', '128px');
                    $('#img-preview').attr('src', e.target.result);
                    // $('#img-upload').val(e.target.result);
                    // console.log($('#img-preview').attr('src'));
                    
                };
                reader.readAsDataURL(this.files[0]);

                let file = this.files[0]; 
                $('#img-upload').data('file', file);
                console.log(file);
                
                console.log(this.files[0].name);
            });
        });
    </script>
@endsection