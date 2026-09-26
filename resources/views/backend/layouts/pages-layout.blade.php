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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        /* Global interaction polish: hover feedback across the app */
        .sidemenu-item:not(.active) a {
            transition: background-color .2s ease, transform .15s ease;
        }
        .sidemenu-item:not(.active):hover {
            background-color: rgba(115, 100, 219, .08);
            border-radius: 12px;
        }
        .dark .sidemenu-item:not(.active):hover {
            background-color: rgba(115, 100, 219, .18);
        }
        .sidemenu-item:not(.active):hover .sidemenu-title {
            color: var(--color-brands);
        }
        .sidemenu-item:not(.active):hover img {
            filter: invert(44%) sepia(39%) saturate(1171%) hue-rotate(210deg) brightness(89%) contrast(91%);
        }

        button:not(:disabled), .btn:not(:disabled), [type="submit"]:not(:disabled), [type="button"]:not(:disabled) {
            transition: filter .15s ease, transform .1s ease, box-shadow .15s ease;
        }
        button:not(:disabled):hover, .btn:not(:disabled):hover,
        [type="submit"]:not(:disabled):hover, [type="button"]:not(:disabled):hover {
            filter: brightness(.94);
        }
        button:not(:disabled):active, .btn:not(:disabled):active,
        [type="submit"]:not(:disabled):active, [type="button"]:not(:disabled):active {
            transform: translateY(1px);
        }

        table tbody tr {
            transition: background-color .15s ease;
        }
        table tbody tr:hover {
            background-color: rgba(115, 100, 219, .05);
        }
        .dark table tbody tr:hover {
            background-color: rgba(115, 100, 219, .14);
        }

        a:not(.sidemenu-title a) {
            transition: color .15s ease, opacity .15s ease;
        }

        #sidebar-btn {
            transition: background-color .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        #sidebar-btn:hover {
            background-color: rgba(115, 100, 219, .1);
            border-color: var(--color-brands);
            box-shadow: 0 4px 14px rgba(115, 100, 219, .25);
        }
        .dark #sidebar-btn:hover {
            background-color: rgba(115, 100, 219, .25);
        }
        #sidebar-btn img {
            transition: filter .2s ease;
        }
        #sidebar-btn:hover img {
            filter: invert(44%) sepia(39%) saturate(1171%) hue-rotate(210deg) brightness(89%) contrast(91%);
        }
        #sidebar-btn:active {
            filter: brightness(.92);
        }

        /* Select2 — match the theme's rounded inputs */
        .select2-container--default .select2-selection--single {
            height: 42px;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            border-color: var(--neutral-border, #E4E7EC);
            background-color: transparent;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: inherit;
            line-height: 1.4;
            padding-left: 16px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 10px;
        }

        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--color-brands);
        }

        .select2-dropdown {
            border-radius: 0.5rem;
            border-color: var(--color-brands);
            overflow: hidden;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--color-brands);
        }

        .select2-search--dropdown .select2-search__field {
            border-radius: 0.375rem;
            border-color: var(--neutral-border, #E4E7EC);
            outline: none;
        }

        .dark .select2-selection--single,
        .dark .select2-dropdown,
        .dark .select2-search__field {
            background-color: #1B1D28 !important;
            color: #E4E7EC !important;
            border-color: var(--dark-neutral-border, #313442) !important;
        }

        .dark .select2-results__option {
            color: #E4E7EC;
        }
    </style>
    @yield('stylesheets')
</head>

<body
    class="w-screen relative overflow-x-hidden min-h-screen bg-gray-100 scrollbar-hide ecommerce-dashboard-page dark:bg-[#000]">
    @include('backend.layouts.partials.toast')
    <div class="wrapper mx-auto text-gray-900 font-normal grid scrollbar-hide grid-cols-[257px,1fr] grid-rows-[auto,1fr]"
        id="layout">
        <script>
            // Restore sidebar collapsed state immediately, before the rest of
            // the layout paints, so navigating between pages doesn't flash
            // back to expanded.
            (function () {
                try {
                    if (localStorage.getItem('sidebarMinimized') === '1') {
                        var layoutEl = document.getElementById('layout');
                        layoutEl.classList.remove('grid-cols-[257px,1fr]');
                        layoutEl.classList.add('minimize');
                    }
                } catch (e) {}
            })();
        </script>
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
    <script src="{{ asset('/backend/assets/scripts/app.js?v=5.2') }}"></script>

    <!-- Add these in your HTML head if not already included -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="{{ asset('/backend/assets/scripts/plugins/select2.min.js') }}"></script>
    <script>
        // Upgrade every <select class="select2-input"> to a searchable Select2
        // dropdown. Runs after jQuery + select2 are both loaded above.
        jQuery(function ($) {
            $('.select2-input').each(function () {
                var $el = $(this);
                var $modalBox = $el.closest('.modal-box');
                $el.select2({
                    width: '100%',
                    dropdownParent: $modalBox.length ? $modalBox : $(document.body),
                });
            });
        });
    </script>

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
