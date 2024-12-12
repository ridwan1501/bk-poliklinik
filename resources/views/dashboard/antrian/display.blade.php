<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> {{ config("app.name") }} - Appointment</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Appointment" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('layouts.head-css')
        <link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body class="d-flex flex-column">
        <div class="d-flex justify-content-between" style="padding-left: 2rem; padding-right: 2rem">
            <h2 class="">Klinik Kesehatan</h2>
            <h5 class=""></h5>
        </div>
        <div class="row pt-8 p-3">
            <div class="col-md-8">
                <iframe style="width: 100%; height: 40vh; border-radius: 20px" src="https://www.youtube.com/embed/5DiyB--3MZY?si=f3zvCFhEo-t65c08" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body bg-light-warning text-center">
                        <h2>Antrian Dipanggil</h2>
                        <h1 style="font-size: 60px" class="p-5" id="ant-sekarang">000</h1>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Antrian Sebelumnya</h2>
                        <h1 style="font-size: 60px" class="p-5" id="ant-lama">000</h1>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.vendor-scripts')
    </body>
</html>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script>
    "use strict";
    $(document).ready(function() {
        setInterval(function() {
            function playAudioSequence(files) {
                if (files.length === 0) return;

                let audio = new Audio(files[0]);
                audio.play();
                audio.onended = function() {
                    files.shift();
                    playAudioSequence(files);
                };
            }

            function playAudioForNumber(number) {
                let audioFiles = ['/audio/antrian.wav']; // Add antrian.wav at the beginning
                let numStr = number.toString().padStart(3, '0');
                let hundreds = parseInt(numStr[0]);
                let tens = parseInt(numStr[1]);
                let units = parseInt(numStr[2]);

                if (hundreds > 0) {
                    audioFiles.push(`/audio/${hundreds}00.wav`);
                }

                if (tens > 1) {
                    audioFiles.push(`/audio/${tens}0.wav`);
                    if (units > 0) {
                        audioFiles.push(`/audio/${units}.wav`);
                    }
                } else if (tens === 1) {
                    audioFiles.push(`/audio/${tens}${units}.wav`);
                } else if (units > 0) {
                    audioFiles.push(`/audio/${units}.wav`);
                }

                playAudioSequence(audioFiles);
            }

            $.ajax({
                url: "{{ route('backoffice.antrian.data-display') }}",
                type: "POST",
                success: function(response) {
                    $("#ant-sekarang").html(response.dipanggil.toString().padStart(3, '0'));
                    $("#ant-lama").html(response.sebelumnya.toString().padStart(3, '0'));

                    if (response.dipanggil) {
                        playAudioForNumber(response.dipanggil);
                        Swal.fire({
                            // html: 'Antrian ' + response.dipanggil + ' dipanggil',
                            html: `
                                <h1>Antrian</h1>
                                <h1 class="p-5" style="font-size: 75px">${response.dipanggil.toString().padStart(3, '0')}</h1>
                            `,
                            timer: 3500,
                            showConfirmButton: false,
                        })
                        .then((result) => {
                            if (!response.id) return;
                            $.ajax({
                                url: `${HOST_URL}/antrian/selesai-display/${response.id}`,
                                type: "POST",
                                data: {
                                    id: response.dipanggil
                                },
                                success: function(response) {
                                    console.log('sukses selesai')
                                }
                            });
                        }).catch((err) => {
                            console.log('error')
                        });
                    }
                }
            });
        }, 5000);
    });
</script>
