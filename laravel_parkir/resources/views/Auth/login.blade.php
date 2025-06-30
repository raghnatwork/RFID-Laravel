<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body>
    <div class="container flex justify-center align-items-end min-w-full min-h-full bg-black">

        <div class=" w-full md:max-w-lg sm:max-w-md max-w-xs flex  flex-col justify-center m-10 px-6 py-12 lg:px-8 ">

            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-30 w-auto bg-white" src="{{ asset('logo/parkir.svg')  }}" alt="Your Company">
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Monitoring Parkir</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf {{-- CSRF Token - PENTING! --}}
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-white">Email address</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email" value="{{ old('email') }}" required
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-white">Password</label>

                        </div>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" autocomplete="current-password"
                                required
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6 @error('password') input-error @enderror">

                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Login</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</body>

</html>
