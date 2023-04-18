<!DOCTYPE html>
<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="dark"
>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
  @vite('resources/js/app.js')
</head>
<body 
  class="
    antialiased
    overflow-x-hidden
    w-screen
    min-h-screen
    dark:bg-[#0f131a]
    dark:text-slate-300
  "
  >
    <div id="app">
      <div class="navbar bg-base-100">
        <div class="flex-1">
          <a class="btn btn-ghost normal-case text-xl">Registro</a>
        </div>
      </div>
      <div
        class="
          w-full
          h-full
        "
      >
        @yield('content')
      </div>
    </div>
  </body>
</html>