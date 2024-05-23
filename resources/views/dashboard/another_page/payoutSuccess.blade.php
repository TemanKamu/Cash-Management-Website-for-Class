<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kelas-ku</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/logo/logo.jpg') }}" />
</head>

<body>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh; ">
        <div class="card" style="width: 31rem;">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between">
                    <span>Payout</span>
                    <div>

                        <span class="font-weight-bold">Status: </span>
                        <span>ACCEPTED</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ $data['kelas']->profile_kelas ? Storage::url($data['kelas']->profile_kelas) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                        class="me-2 border rounded img-fluid w-25" alt="image">
                </div>
                <div class="px-2 py-3 mt-5" style="background: #f5f5f5">
                    <p class="font-weight-bold ">Confirm your details</p>
                    <span>Silahkan dibaca secara detail agar tidak terjadi kesalahan</span>
                </div>
                <form action="{{ route('payout.success') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $data['user_id'] }}">
                    <input type="hidden" name="kelas_id" value="{{ $data['kelas_id'] }}">
                    <div class="border-top mt-4 d-flex justify-content-between align-items-center py-3 px-2">
                        <span class="font-weight-bold">Amount</span>
                        <span class="font-weight-thick">IDR {{ number_format($data['amount']) }}</span>
                        <input type="hidden" name="amount" value="{{ $data['amount'] }}" id="">
                    </div>
                    <div class="border-top d-flex justify-content-between py-3 px-2">
                        <span class="font-weight-bold">Destination</span>
                        <span class="font-weight-thick">{{ str_replace('ID_', '', $data['channel_code']) }}</span>
                        <input type="hidden" name="channel_code" value="{{ $data['channel_code'] }}" id="">
                    </div>
                    <div class="border-top d-flex justify-content-between py-3 px-2">
                        <span class="font-weight-bold">Acoount name</span>
                        <span class="font-weight-thick">{{ $data['account_name'] }}</span>
                        <input type="hidden" name="account_name" value="{{ $data['account_name'] }}" id="">
                    </div>
                    <div class="border-top d-flex justify-content-between py-3 px-2">
                        <span class="font-weight-bold">Account number</span>
                        <span class="font-weight-thick">{{ $data['account_number'] }}</span>
                        <input type="hidden" name="account_number" value="{{ $data['account_number'] }}"
                            id="">
                    </div>
                    <div class="border-top d-flex justify-content-between py-3 px-2">
                        <span class="font-weight-bold">Description</span>
                        <span class="font-weight-thick">{{ $data['description'] }}</span>
                        <input type="hidden" name="description" value="{{ $data['description'] }}" id="">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-primary" onclick="window.history.back()">Back</button>
                        <button class="btn btn-primary" type="submit">Confirm</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
