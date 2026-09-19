<!DOCTYPE html>
<html class="scroll-smooth overflow-x-hidden" lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('pageTitle')</title>
    <meta name="base_url" content="{{ url('') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <link rel="icon" href="{{ asset('/backend/assets/images/icons/icon-favicon.svg') }}" type="image/x-icon"
        sizes="16x16">
    <link rel="stylesheet" href="{{ asset('/backend/assets/styles/tailwind.min.css?v=5.0') }}">
    <link rel="stylesheet" href="{{ asset('/backend/assets/styles/style.min.css?v=5.0') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @yield('stylesheets')
</head>

<body
    class="w-screen relative overflow-x-hidden min-h-screen bg-gray-100 scrollbar-hide ecommerce-dashboard-page dark:bg-[#000]">
    <div class="wrapper mx-auto text-gray-900 font-normal grid scrollbar-hide grid-cols-[257px,1fr] grid-rows-[auto,1fr]"
        id="layout">
        @include('backend.layouts.partials.aside')
        @include('backend.layouts.partials.header')
        <main class="overflow-x-scroll scrollbar-hide flex flex-col justify-between pt-[42px] px-[23px] pb-[28px]">
            @include('backend.layouts.partials.bread-crumb')
            @yield('content')
            <footer class="mt-[37px]">
                <div class="w-full bg-neutral h-[1px] dark:bg-dark-neutral-border mb-[25px]"></div>
                <div
                    class="flex items-center justify-between text-desc text-gray-400 flex-wrap gap-5 dark:text-gray-dark-400">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p> <span>© 2022 -</span><span
                                class="text-color-brands">&nbsp;Frox</span><span>&nbsp;Dashboard</span></p>
                        <div class="bg-color-brands rounded-full hidden w-[2px] h-[2px] md:block"></div>
                        <p> <span>Made by</span><a class="text-color-brands" href="https://alithemes.com"
                                target="_blank">&nbsp;AliThemes</a></p>
                    </div>
                    <div class="flex items-center gap-[15px]"><a
                            class="transition-colors duration-300 hover:text-color-brands" href="#">About</a><a
                            class="transition-colors duration-300 hover:text-color-brands" href="#">Careers</a><a
                            class="transition-colors duration-300 hover:text-color-brands" href="#">Policy</a><a
                            class="transition-colors duration-300 hover:text-color-brands" href="#">Contact</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>
    <script type="text/javascript" src="{{ asset('/backend/assets/scripts/vendors/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/backend/assets/scripts/chart-utils.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/backend/assets/scripts/chart.min.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/chartjs-chart-geo@3"></script>
    <script src="{{ asset('/backend/assets/scripts/app.js?v=5.1') }}"></script>

    <!-- Add these in your HTML head if not already included -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function downloadModalPDF(invoiceId, invMonth, invRoomNum) {
            // Find your modal
            const originalModal = $(`#detail-modal-${invoiceId}`);

            const modalClone = originalModal.clone();

            modalClone.css({
                display: 'block',
                position: 'absolute',
                left: '-9999px', // keep it off-screen
                top: '0',
                width: originalModal.outerWidth(),
                background: '#fff', // to avoid transparency issues
                zIndex: '-1'
            });

            $('body').append(modalClone);

            // Wait a moment for fonts/icons to load
            setTimeout(() => {
                html2canvas(modalClone[0], {
                    scale: 2, // High resolution
                    useCORS: true, // Allow cross-origin images
                    logging: false,
                    backgroundColor: '#ffffff'
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const {
                        jsPDF
                    } = window.jspdf;
                    const pdf = new jsPDF('p', 'mm', 'a4');

                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    // Clean file name: remove spaces, special chars except dash and dot
                    const cleanRoomNum = String(invRoomNum).replace(/[^a-zA-Z0-9\-]/g, '');
                    const cleanMonth = String(invMonth).replace(/[^a-zA-Z0-9\-]/g, '');
                    const fileName = `INV-${cleanRoomNum}-${cleanMonth}.pdf`;
                    pdf.save(fileName);

                    // Remove cloned modal
                    modalClone.remove();
                }).catch(err => {
                    console.error('Could not generate PDF:', err);
                    modalClone.remove();
                });
            }, 300); // Small delay for styles/fonts
        }
    </script>
    @yield('scripts')
</body>

</html>
