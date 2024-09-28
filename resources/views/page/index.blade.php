@extends('layouts.index')

@section('additional_style')
    <style>

    </style>
@endsection

@section('content')

    @section('topnavbar')
        @include('partials.topnavbar')
    @endsection

    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row py-30 gutters-tiny">
                
                @foreach ($users as $user)
                    <div class="col-md-3 col-xl-2 col-sm-3" class="">
                        {{-- <a class="block block-link-pop block-rounded block-bordered text-center" data-toggle="modal" data-id="{{ $user->id }}" data-target="#modal-user-{{ $user->id }}"  href="javascript:void(0)"> --}}
                        <a class="user-card block block-link-pop block-rounded block-bordered text-center" data-toggle="modal" data-id="{{ $user->id }}"  href="javascript:void(0)">
                            {{-- <div class="block-header">
                                <h3 class="block-title font-w600">
                                    <i class="fa fa-check"></i> Developer
                                </h3>
                            </div> --}}
                            {{-- <div class="block-content bg-body-light">
                                <div class="h1 font-w700 text-primary mb-10">$19</div>
                                <div class="h5 text-muted">per month</div>
                            </div> --}}
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
        <!-- END Page Content -->
    </main>
@endsection

@section('modal')
    @include('page.modal.modal')
@endsection

@section('additional_script')
    <script>

        $(document).ready(function(){

            $('.user-card').on('click', function(e){
                e.preventDefault()
                
                let getUserUrl = "{{ route('user.show', '') }}/" + $(this).attr('data-id');

                // prepare modal
                let divFoto = $('#modal-user').find('.divFoto');
                let divDesc = divFoto.siblings('.divDesc');
                let divDescClass = divDesc.attr('class').split(' ');
                let itemUser = $('#modal-user').find('.row');
                let items = itemUser.attr('class').split(' ');

                // Menggunakan fadeOut pada divFoto
                divFoto.show();

                // Mengubah ukuran kolom divDesc
                divDesc.removeClass('col-xl-12 col-md-12 col-sm-12').addClass('col-xl-6 col-md-6 col-sm-6');
                $('.'.concat(divDescClass[0])).css("text-align", "");
                $('.'.concat(items[0])).attr("style", "align-items: center");

                
                $.ajax({
                    url: getUserUrl,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        
                        // Mendapatkan data user dalam response JSON
                        $('#modal-user').find('.divFoto img').attr('src', response.foto );

                        $('#modal-user').find('.divDesc').html(
                            '<p>' + response.nama + '</p>' +
                            '<p>' + response.tgl_lahir + '</p>' +
                            '<p>' + response.pekerjaan + '</p>'
                        );

                        // Menampilkan modal setelah data dimasukkan
                        $('#modal-user').modal('show');

                        setTimeout(() => {
                            let divFoto = $('#modal-user').find('.divFoto');
                            let divDesc = divFoto.siblings('.divDesc');
                            let divDescClass = divDesc.attr('class').split(' ');
                            let itemUser = $('#modal-user').find('.row');
                            let items = itemUser.attr('class').split(' ');

                            // Menggunakan fadeOut pada divFoto
                            divFoto.fadeOut();

                            // Mengubah ukuran kolom divDesc
                            divDesc.removeClass('col-xl-6 col-md-6 col-sm-6').addClass('col-xl-12 col-md-12 col-sm-12');

                            // Mengatur style text-align pada divDesc
                            $('.'.concat(divDescClass[0])).attr("style", "text-align:center");
                        }, 5000);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 403) {
                            Swal.fire({
                                title: "Access Denied!",
                                text: "You have already accessed this user",
                                icon: "error",
                            });
                        } else if(xhr.status === 500){
                            Swal.fire({
                                title: "Error!",
                                text: "Internal Server Error",
                                icon: "error",
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: error,
                                icon: "error",
                            });
                        }
                    }
                });
                
            });

            $('#modal-user').on('hidden.bs.modal', function () {
                $('#modal-user').find('.divFoto img').attr('src', '' );
            });
        });

    </script>
@endsection