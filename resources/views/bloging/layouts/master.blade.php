<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bloging | @if(isset($title)) {{ $title }}  @else {{ 'Dashboard' }} @endif</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="{{ asset('posting/images/icons/favicon.png') }}" />

  {{-- addon-css --}}
  @stack('addon-css')
  {{-- addon-css --}}
</head>

<body class="animsition">

  <!-- Header -->
  @include('bloging.layouts.header')

  <!-- Headline -->
  @yield('content')

  @include('bloging.layouts.footer')

  <!-- Back to top -->
  <div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
      <span class="fas fa-angle-up"></span>
    </span>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.6/jstz.min.js"></script>
  @stack('addon-script')

  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      if (!navigator.geolocation) {
        console.log("Geolacation is not supported by your browser");
        ipLookup();
      } else {
        navigator.geolocation.getCurrentPosition(success, error)
      }

      function success(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        reserveGeocodingWithGoogle(longitude, latitude);
      }

      function error() {
        console.log("Unable to retrieve yout location");
      }

      function ipLookup() {
        fetch('https://extreme-ip-lookup.com/json/').then(res => res.json()).then(response => {
          fallbackProcess(response);
        });
      }

      function reserveGeocodingWithGoogle(latitude, longitude) {
        fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyCZPqNRASzLFUjKDunzp0UczWOIrmMehKE`).then(res => json()).then(response => {
          processUserData(response);
        }).catch(status => { ipLookup() })
      }

      function processUserData(response) {
        let address = document.querySelector('.address');
        let address2 = document.querySelector('.address2');
        address.innerHTML = response.results[0].formatted_address;
        address2.innerHTML = response.results[0].formatted_address;
      }

      function fallbackProcess(response) {
        let address = document.querySelector('.address2');
        address.innerHTML = `${response.city}, ${response.country}`;
        let address2 = document.querySelector('.address2');
        address2.innerHTML = `${response.city}, ${response.country}`;
      }
    });
  </script>
</body>

</html>