@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                    {{ $tenant->name }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-dark-500 mt-1">
                    Room {{ $tenant->room->number ?? '—' }} &middot; {{ $tenant->phone }}
                </div>
            </div>
            <a href="{{ route('tenents.index') }}"
                class="cursor-pointer flex items-center gap-2 bg-neutral text-gray-1100 dark:text-gray-dark-1100 text-sm font-semibold rounded-lg px-4 py-2 dark:bg-dark-neutral-border">
                Back to Tenants
            </a>
        </div>

        <div class="td-grid">
            {{-- Social Links --}}
            <div class="td-card">
                <div class="td-card-title">Social Links</div>

                @forelse ($tenant->socialLinks as $link)
                    <div class="td-row">
                        <div class="td-row-main">
                            <span class="td-badge td-badge-brand">{{ ucfirst($link->platform) }}</span>
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="td-link">{{ $link->url }}</a>
                        </div>
                        <form method="POST"
                            action="{{ route('tenents.social-links.destroy', [$tenant, $link]) }}"
                            onsubmit="return confirm('Remove this social link?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="td-remove">Remove</button>
                        </form>
                    </div>
                @empty
                    <div class="td-empty">No social links yet.</div>
                @endforelse

                <form method="POST" action="{{ route('tenents.social-links.store', $tenant) }}" class="td-form">
                    @csrf
                    <div class="cs" data-name="platform">
                        <button type="button" class="cs-toggle">
                            <span class="cs-label">Facebook</span>
                            <span class="cs-arrow"></span>
                        </button>
                        <input type="hidden" name="platform" value="facebook">
                        <div class="cs-menu">
                            <div class="cs-option is-active" data-value="facebook">Facebook</div>
                            <div class="cs-option" data-value="telegram">Telegram</div>
                            <div class="cs-option" data-value="whatsapp">WhatsApp</div>
                            <div class="cs-option" data-value="instagram">Instagram</div>
                            <div class="cs-option" data-value="tiktok">TikTok</div>
                            <div class="cs-option" data-value="other">Other</div>
                        </div>
                    </div>
                    <input type="url" name="url" placeholder="https://..." class="td-input td-input-grow" required>
                    <button type="submit" class="td-add-btn">Add</button>
                </form>
                @error('url')
                    <div class="td-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Transportation --}}
            <div class="td-card">
                <div class="td-card-title">Transportation</div>

                @forelse ($tenant->transportations as $vehicle)
                    <div class="td-row">
                        <div class="td-row-main">
                            <span class="td-badge td-badge-neutral">{{ ucfirst($vehicle->type) }}</span>
                            @if ($vehicle->brand)
                                <span class="td-plate">{{ $vehicle->brand }}</span>
                            @endif
                            <span class="td-plate">{{ $vehicle->license_plate }}</span>
                        </div>
                        <form method="POST"
                            action="{{ route('tenents.transportations.destroy', [$tenant, $vehicle]) }}"
                            onsubmit="return confirm('Remove this vehicle?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="td-remove">Remove</button>
                        </form>
                    </div>
                @empty
                    <div class="td-empty">No transportation on file.</div>
                @endforelse

                <form method="POST" action="{{ route('tenents.transportations.store', $tenant) }}" class="td-form">
                    @csrf
                    <div class="cs" data-name="type">
                        <button type="button" class="cs-toggle">
                            <span class="cs-label">Motorbike</span>
                            <span class="cs-arrow"></span>
                        </button>
                        <input type="hidden" name="type" value="motorbike">
                        <div class="cs-menu">
                            <div class="cs-option is-active" data-value="motorbike">Motorbike</div>
                            <div class="cs-option" data-value="car">Car</div>
                            <div class="cs-option" data-value="bicycle">Bicycle</div>
                            <div class="cs-option" data-value="other">Other</div>
                        </div>
                    </div>
                    <input type="text" name="brand" placeholder="Brand (e.g. Honda)" class="td-input">
                    <input type="text" name="license_plate" placeholder="License plate" class="td-input td-input-grow"
                        required>
                    <button type="submit" class="td-add-btn">Add</button>
                </form>
                @error('license_plate')
                    <div class="td-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Documents --}}
            <div class="td-card td-card-wide">
                <div class="td-card-title">Documents</div>

                @forelse ($tenant->documents as $doc)
                    <div class="td-row">
                        <div class="td-row-main">
                            <span class="td-badge td-badge-brand">{{ $doc->label }}</span>
                            <a href="{{ asset('uploads/' . $doc->file_path) }}" target="_blank"
                                rel="noopener" class="td-link">{{ $doc->original_name ?? 'View file' }}</a>
                        </div>
                        <form method="POST" action="{{ route('tenents.documents.destroy', [$tenant, $doc]) }}"
                            onsubmit="return confirm('Delete this document?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="td-remove">Remove</button>
                        </form>
                    </div>
                @empty
                    <div class="td-empty">No documents uploaded yet.</div>
                @endforelse

                <form method="POST" action="{{ route('tenents.documents.store', $tenant) }}" class="td-form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="label" list="td-doc-labels" placeholder="e.g. ID card, Birth certificate"
                        class="td-input" required>
                    <datalist id="td-doc-labels">
                        <option value="ID Card">
                        <option value="KHID">
                        <option value="Passport">
                        <option value="Vehicle Registration">
                        <option value="Birth Certificate">
                    </datalist>
                    <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" class="td-input td-input-grow"
                        required>
                    <button type="submit" class="td-add-btn">Upload</button>
                </form>
                @error('label')
                    <div class="td-error">{{ $message }}</div>
                @enderror
                @error('file')
                    <div class="td-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <style>
        /* Plain CSS on purpose: tailwind.min.css here is a static,
           pre-purged build, so brand-new utility classes silently
           produce no rule. Custom classes below avoid that entirely. */
        .td-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .td-card-wide {
            grid-column: 1 / -1;
        }

        @media (max-width: 900px) {
            .td-grid {
                grid-template-columns: 1fr;
            }
        }

        .td-card {
            background: var(--neutral-bg, #fff);
            border: 1px solid rgba(128, 131, 163, .2);
            border-radius: 16px;
            padding: 20px;
        }

        .dark .td-card {
            background: #1B1B29;
            border-color: rgba(255, 255, 255, .08);
        }

        .td-card-title {
            font-size: 15px;
            font-weight: 600;
            color: #171725;
            margin-bottom: 14px;
        }

        .dark .td-card-title {
            color: #fff;
        }

        .td-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(128, 131, 163, .15);
        }

        .dark .td-row {
            border-color: rgba(255, 255, 255, .07);
        }

        .td-row-main {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .td-link {
            color: #171725;
            font-size: 13px;
            text-decoration: underline;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 320px;
        }

        .dark .td-link {
            color: #E0E0E0;
        }

        .td-plate {
            font-size: 13px;
            font-weight: 600;
            color: #171725;
        }

        .dark .td-plate {
            color: #E0E0E0;
        }

        .td-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            white-space: nowrap;
        }

        .td-badge-brand {
            background-color: rgba(115, 100, 219, .14);
            color: #7364DB;
        }

        .td-badge-neutral {
            background-color: rgba(128, 131, 163, .15);
            color: #8083A3;
        }

        .td-empty {
            font-size: 13px;
            color: #8083A3;
            padding: 10px 0;
        }

        .td-remove {
            font-size: 11px;
            font-weight: 600;
            color: #E23738;
            background: transparent;
            border: none;
            cursor: pointer;
            flex-shrink: 0;
        }

        .td-form {
            display: flex;
            gap: 8px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .td-input {
            border: 1px solid rgba(128, 131, 163, .3);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            background: transparent;
            color: inherit;
        }

        .dark .td-input {
            border-color: rgba(255, 255, 255, .15);
        }

        .td-input-grow {
            flex: 1;
            min-width: 160px;
        }

        .td-add-btn {
            background-color: #7364DB;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .td-error {
            color: #E23738;
            font-size: 12px;
            margin-top: 6px;
        }

        /* Custom dropdown ("cs" = custom select): a small self-built
           replacement for the plain native <select>, styled to match
           this page's brand purple. No external plugin, so its sizing
           and spacing stay fully under our control. */
        .cs {
            position: relative;
            width: 150px;
            flex: 0 0 150px;
        }

        .cs-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            width: 100%;
            border: 1px solid rgba(128, 131, 163, .3);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            background: transparent;
            color: inherit;
            cursor: pointer;
        }

        .dark .cs-toggle {
            border-color: rgba(255, 255, 255, .15);
        }

        .cs-arrow {
            flex-shrink: 0;
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid #8083A3;
            transition: transform .15s ease;
        }

        .cs.is-open .cs-arrow {
            transform: rotate(180deg);
        }

        .cs-menu {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            width: 100%;
            min-width: 150px;
            max-height: 220px;
            overflow-y: auto;
            background: var(--neutral-bg, #fff);
            border: 1px solid rgba(128, 131, 163, .2);
            border-radius: 8px;
            box-shadow: 0 20px 60px -6px rgba(0, 0, 0, .12);
            padding: 6px;
            z-index: 30;
        }

        .dark .cs-menu {
            background: #1B1B29;
            border-color: rgba(255, 255, 255, .1);
        }

        .cs.is-open .cs-menu {
            display: block;
        }

        .cs-option {
            padding: 8px 10px;
            font-size: 13px;
            border-radius: 6px;
            color: #171725;
            cursor: pointer;
            white-space: nowrap;
        }

        .dark .cs-option {
            color: #E0E0E0;
        }

        .cs-option:hover,
        .cs-option.is-active {
            background-color: #7364DB;
            color: #fff;
        }
    </style>

    <script>
        (function () {
            function closeAll() {
                document.querySelectorAll('.cs.is-open').forEach(function (el) {
                    el.classList.remove('is-open');
                });
            }

            document.querySelectorAll('.cs').forEach(function (cs) {
                var toggle = cs.querySelector('.cs-toggle');
                var label = cs.querySelector('.cs-label');
                var hidden = cs.querySelector('input[type=hidden]');
                var options = cs.querySelectorAll('.cs-option');

                toggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var willOpen = !cs.classList.contains('is-open');
                    closeAll();
                    if (willOpen) cs.classList.add('is-open');
                });

                options.forEach(function (opt) {
                    opt.addEventListener('click', function (e) {
                        e.stopPropagation();
                        hidden.value = opt.dataset.value;
                        label.textContent = opt.textContent.trim();
                        options.forEach(function (o) { o.classList.remove('is-active'); });
                        opt.classList.add('is-active');
                        cs.classList.remove('is-open');
                    });
                });
            });

            document.addEventListener('click', closeAll);
        })();
    </script>
@endsection
