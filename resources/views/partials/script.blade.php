<!--
    Codebase JS Core

    Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
    to handle those dependencies through webpack. Please check out assets/_es6/main/bootstrap.js for more info.

    If you like, you could also include them separately directly from the assets/js/core folder in the following
    order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

    assets/js/core/jquery.min.js
    assets/js/core/bootstrap.bundle.min.js
    assets/js/core/simplebar.min.js
    assets/js/core/jquery-scrollLock.min.js
    assets/js/core/jquery.appear.min.js
    assets/js/core/jquery.countTo.min.js
    assets/js/core/js.cookie.min.js
-->
<script src="{{ asset('js/codebase.core.min.js') }}"></script>

<!--
    Codebase JS

    Custom functionality including Blocks/Layout API as well as other vital and optional helpers
    webpack is putting everything together at assets/_es6/main/app.js
-->
<script src="{{ asset('js/codebase.app.min.js') }}"></script>

{{-- plugins --}}

<script src="{{ asset('js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>


{{-- sweetalert2 --}}
<script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>

<script>
    // Deteksi tombol F12 atau Ctrl+Shift+I untuk membuka dev tools
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I') || e.key === 'PrintScreen') {
            document.body.classList.add('blur'); // Tambahkan efek blur pada seluruh body
            alert('Developer tools detected! Konten di-blur.');
            e.preventDefault();
        }
    });

    // document.addEventListener('keyup', (e)=>{
    //     // navigator.clipboard.writeText('');
    //     // alert('ga boleh')
    //     console.log(e)
    //     e.view.navigator
    // });

    navigator.clipboard.addEventListener('clipboard-write', (event) => {
        // Kode yang akan dijalankan ketika pengguna mencoba menyalin sesuatu ke clipboard
        console.log('Seseorang mencoba menyalin konten!');
        // Di sini Anda bisa menambahkan tindakan lain, seperti menampilkan peringatan atau mencegah penyalinan
        event.clipboardData.clearData(); // Mencegah data disalin
    });

    $(document).on('contextmenu', function(event) {
        event.preventDefault();
    });

    $('.divFoto').css('pointer-events', 'none');
</script>