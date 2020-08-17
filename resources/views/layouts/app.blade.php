 <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
 <html>

 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
     <title>{{ $title }}</title>
     <link rel="icon" href="{{ asset('img/icon.ico') }}" type="image/x-icon">

     <link rel="stylesheet" type="text/css" href="{{ asset('css/shop.css') }}" />
     <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
     <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
     <script src="{{ asset('js/popper.min.js') }}"></script>
     <script src="{{ asset('js/bootstrap.min.js') }}"></script>
     <script src="{{ asset('js/sockjs-0.3.2.min.js') }}"></script>
     <script src="{{ asset('js/stomp.js') }}"></script>
     <script src="{{ asset('js/websocket-util.js') }}"></script>
     <script src="{{ asset('js/ajax.js?v=1') }}"></script>
     <script src="{{ asset('js/util.js?v=1') }}"></script>
     <script src="{{ asset('js/strings.js?v=1') }}"></script>

     @if (isset($additional_style_paths) && !is_null($additional_style_paths))
         @foreach ($additional_style_paths as $stylePath)
             <link rel="stylesheet" href="{{ asset('css/pages/'.$stylePath.'.css?version=1') }}" />
         @endforeach
     @endif
     @if (isset($additional_script_paths) && !is_null($additional_script_paths))
         @foreach ($additional_script_paths as $scriptPath)
             <script src="{{ asset('js/pages/'.$scriptPath.'.js?v=1') }}"></script>
         @endforeach
     @endif



     <style>
         .page-li {
             position: relative;
         }

         .container {
             display: grid;
             grid-template-columns: 20% 80%
         }

         /**
  active menu when using vertical aligment
 **/
         .active {
             font-weight: bold;
         }

         .centered-align {
             text-align: center;
             width: 100%;
         }

         .menu-spoiler {
             text-align: left;
             font-size: 0.7em;
             background-color: gray;
             z-index: 1;
             position: absolute;
         }

         .menu-spoiler>a {
             color: white;
         }

         #header-wrapper {
             height: 100%;
         }

     </style>
 </head>

 <body>
     <div id="progress-bar-wrapper" onclick="hide('progress-bar-wrapper');" class="box-shadow"
         style="display: none; height: 50px; padding: 10px; background-color: white; margin: auto; position: fixed; width: 100%">
         <div class="progress">
             <div id="progress-bar" class="progress-bar progress-bar-striped bg-info" role="progressbar"
                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
         </div>
     </div>
     <input id="token-value" value="{{ $page_token }}" type="hidden" />
     <input id="request-id" value="{{ $request_id }}" type="hidden" />
     <input id="registered-request-id" value="{{ $registered_request_id }}" type="hidden" />
     <div id="loading-div"></div>
     <div class="container">
         <div>
             @include('include/head')
         </div>
         <div>
             @yield('content')
         </div>
         <div></div>
         <div>
             @include('include/foot')
         </div>

     </div>
     <script type="text/javascript">
        document.body.style.backgroundColor = '{{ $profile->general_color }}';
        const websocketUrl = '{{$context_path}}/realtime-app';

        function initProgressWebsocket() {
             hide('progress-bar-wrapper');

             addWebsocketRequest('/wsResp/progress/${requestId}', function(
                 response) {

                 show('progress-bar-wrapper');
                 _byId('progress-bar').style.width = response.percentage + "%";
                 _byId('progress-bar').setAttribute("aria-valuenow",
                     Math.floor(response.percentage));

                 if (response.percentage >= 100) {
                     hide('progress-bar-wrapper');
                 }
             });
         }

         document.body.onload = function() {
             initProgressWebsocket();
             connectToWebsocket();

             _byId("page-header").style.color = '{{$profile->font_color}}';
             
         }

     </script>
 </body>

 </html>
