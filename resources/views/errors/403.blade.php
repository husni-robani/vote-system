<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 403</title>

    <!-- script ---->
    @routes
    @vite(['resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen">
<div class="min-h-screen pt-16 pb-12 flex flex-col bg-white">
    <main class="flex-grow flex flex-col justify-center max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex-shrink-0 flex justify-center">
            <a href="/" class="inline-flex">
                <span class="sr-only">Workflow</span>
                <svg width="100" height="100" viewBox="0 0 166 165" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_336_50)">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M83.2525 0.164787C128.772 0.164787 165.67 37.0631 165.67 82.5824C165.67 128.102 128.772 165 83.2525 165C37.7333 165 0.834961 128.102 0.834961 82.5824C0.834961 37.0631 37.7333 0.164787 83.2525 0.164787ZM83.2525 15.923C120.068 15.923 149.912 45.7664 149.912 82.5824C149.912 119.398 120.068 149.242 83.2525 149.242C46.4366 149.242 16.5932 119.398 16.5932 82.5824C16.5932 45.7664 46.4366 15.923 83.2525 15.923Z" fill="#9EBFE2"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M115.313 33.9642C131.08 44.3818 141.481 62.2664 141.481 82.5823C141.481 114.742 115.412 140.81 83.2529 140.81C51.0936 140.81 25.0249 114.742 25.0249 82.5823C25.0249 62.2664 35.426 44.3818 51.1925 33.9642L59.7062 47.3653C48.3573 54.9642 40.8903 67.9038 40.8903 82.5823C40.8903 105.981 59.8546 124.945 83.2529 124.945C106.651 124.945 125.616 105.981 125.616 82.5823C125.616 67.9038 118.149 54.9642 106.8 47.3653L115.313 33.9642Z" fill="#9EBFE2"/>
                        <path d="M91.1895 22.6648H75.3159V97.7389H91.1895V22.6648Z" fill="#9EBFE2"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_336_50">
                            <rect width="164.835" height="164.835" fill="white" transform="translate(0.834961 0.164795)"/>
                        </clipPath>
                    </defs>
                </svg>
            </a>
        </div>
        <div class="py-16">
            <div class="text-center">
                <p class="text-sm font-semibold text-accent uppercase tracking-wide">{{$exception->getStatusCode()}} error</p>
                <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">{{$exception->getMessage()}}</h1>
                <div class="mt-6">
                    <a href="{{route('election.menu')}}" class="text-base font-medium text-accent hover:text-accent_old">Go to election lists<span aria-hidden="true"> &rarr;</span></a>
                </div>
            </div>
        </div>
    </main>
    <footer class="flex-shrink-0 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex justify-center space-x-4">
            <a href="mailto:hima.teknikinformatika@widyatama.ac.id" class="text-sm font-medium text-gray-500 hover:text-gray-600">Contact Support</a>
        </nav>
    </footer>
</div>
</body>
</html>