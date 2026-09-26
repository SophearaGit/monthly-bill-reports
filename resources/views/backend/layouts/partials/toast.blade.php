@if (session('success') || session('error'))
    <div id="app-toast-container" class="app-toast-container">
        @if (session('success'))
            <div data-toast class="app-toast app-toast-success">
                <span class="app-toast-message">{{ session('success') }}</span>
                <button type="button" class="app-toast-close"
                    onclick="this.closest('[data-toast]').remove()">&times;</button>
            </div>
        @endif
        @if (session('error'))
            <div data-toast class="app-toast app-toast-error">
                <span class="app-toast-message">{{ session('error') }}</span>
                <button type="button" class="app-toast-close"
                    onclick="this.closest('[data-toast]').remove()">&times;</button>
            </div>
        @endif
    </div>
    <style>
        /* Plain CSS on purpose: this app's tailwind.min.css is a static,
           pre-purged build (a copied template asset, not rebuilt by this
           project's own Vite/Tailwind config), so brand-new utility
           classes like `fixed`, `bottom-5`, or one-off hex backgrounds
           silently produce no rule and the toast renders unstyled. */
        .app-toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column-reverse;
            gap: 12px;
            align-items: flex-end;
            pointer-events: none;
        }

        .app-toast {
            pointer-events: auto;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border-radius: 12px;
            border: 1px solid transparent;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            max-width: 360px;
        }

        .app-toast-success {
            border-color: var(--green-accent, #50D1B2);
            background-color: #E9FAF0;
            color: var(--green-accent, #50D1B2);
        }

        .dark .app-toast-success {
            background-color: #0F2A1D;
        }

        .app-toast-error {
            border-color: var(--red-accent, #E23738);
            background-color: #FDEDEC;
            color: var(--red-accent, #E23738);
        }

        .dark .app-toast-error {
            background-color: #3A1414;
        }

        .app-toast-message {
            flex: 1;
        }

        .app-toast-close {
            opacity: .6;
            line-height: 1;
            font-size: 16px;
            background: transparent;
            border: none;
            cursor: pointer;
            color: inherit;
        }

        .app-toast-close:hover {
            opacity: 1;
        }
    </style>
    <script>
        (function () {
            var toasts = document.querySelectorAll('[data-toast]');
            toasts.forEach(function (el, i) {
                el.style.opacity = '0';
                el.style.transform = 'translateX(24px)';
                el.style.transition = 'opacity .25s ease, transform .25s ease';
                requestAnimationFrame(function () {
                    setTimeout(function () {
                        el.style.opacity = '1';
                        el.style.transform = 'translateX(0)';
                    }, i * 80);
                });
                setTimeout(function () {
                    el.style.opacity = '0';
                    el.style.transform = 'translateX(24px)';
                    setTimeout(function () { el.remove(); }, 250);
                }, 4200 + i * 80);
            });
        })();
    </script>
@endif
