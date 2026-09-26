@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Invoice Lists')

@section('content')
    <div class="inv-page">

        {{-- Search --}}
        <form method="GET" action="{{ route('invoices.index') }}" class="inv-search" id="inv-search-form">
            <div class="inv-search-inner">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4.5" width="18" height="16" rx="3" />
                    <line x1="16" y1="2.5" x2="16" y2="6.5" />
                    <line x1="8" y1="2.5" x2="8" y2="6.5" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                <input type="text" id="month-picker" name="month" class="inv-month-input"
                    value="{{ $selectedMonth ?? request('month', now()->format('Y-m')) }}" readonly>
            </div>
        </form>

        {{-- Bulk action toolbar (hidden until checkboxes selected) --}}
        <div class="bulk-toolbar" id="bulk-toolbar">
            <div class="bulk-toolbar-inner">
                <div class="bulk-info">
                    <div class="bulk-check-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <span id="bulk-count">0</span> invoice(s) selected
                </div>
                <div class="bulk-actions">
                    <button class="bulk-deselect" onclick="deselectAll()">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Clear
                    </button>
                    <button class="bulk-download" id="bulk-download-btn" onclick="downloadSelectedAsZip()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span id="bulk-download-label">Download ZIP</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="inv-card">
            <div class="inv-card-head">
                <h2 class="inv-card-title">Invoice Lists</h2>
                @if ($selectedMonth ?? request('month'))
                    <span
                        class="inv-month-badge">{{ \Carbon\Carbon::parse(($selectedMonth ?? request('month')) . '-01')->format('F Y') }}</span>
                @endif
            </div>

            <div class="inv-scroll">
                <table class="inv-tbl">
                    <thead>
                        <tr>
                            <th rowspan="2" class="th-base th-check">
                                <label class="cb-wrap">
                                    <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                                    <span class="cb-box"></span>
                                </label>
                            </th>
                            <th rowspan="2" class="th-base">#</th>
                            <th rowspan="2" class="th-base">ឈ្មោះអ្នកជួល</th>
                            <th rowspan="2" class="th-base">បន្ទប់</th>
                            <th rowspan="2" class="th-base">ថ្លៃបន្ទប់</th>
                            <th rowspan="2" class="th-base">ខែ</th>
                            <th colspan="4" class="th-elec">⚡ ថ្លៃអគ្គិសនី</th>
                            <th colspan="4" class="th-water">💧 ថ្លៃទឹក</th>
                            <th rowspan="2" class="th-base">សរុប</th>
                            <th rowspan="2" class="th-base">Status</th>
                            <th rowspan="2" class="th-base"></th>
                        </tr>
                        <tr>
                            <th class="th-sub">គីឡូថ្មី</th>
                            <th class="th-sub">គីឡូចាស់</th>
                            <th class="th-sub">ប្រើ</th>
                            <th class="th-sub">តម្លៃ</th>
                            <th class="th-sub">គីឡូថ្មី</th>
                            <th class="th-sub">គីឡូចាស់</th>
                            <th class="th-sub">ប្រើ</th>
                            <th class="th-sub">តម្លៃ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            @php
                                $exchangeRate = 4100;
                                $rentRiel = $invoice->room->rent_price * $exchangeRate;
                                $elecRiel = $invoice->electric_used_price * $exchangeRate;
                                $waterRiel = $invoice->water_used_price * $exchangeRate;
                                $totalRiel = $invoice->total_amount * $exchangeRate;
                                $monthParsed = \Carbon\Carbon::parse($invoice->month . '-01');
                            @endphp
                            <tr class="inv-tr" data-id="{{ $invoice->id }}">
                                {{-- Checkbox --}}
                                <td class="tc tc-check">
                                    <label class="cb-wrap">
                                        <input type="checkbox" class="row-cb" value="{{ $invoice->id }}"
                                            data-room="{{ $invoice->room->number }}" data-month="{{ $invoice->month }}"
                                            onchange="onRowCheckChange()">
                                        <span class="cb-box"></span>
                                    </label>
                                </td>
                                <td class="tc tc-muted">{{ $invoice->id }}</td>
                                <td class="tc tc-bold">{{ $invoice->tenant->name }}</td>
                                <td class="tc"><span class="room-pill">{{ $invoice->room->number }}</span></td>
                                <td class="tc">
                                    <span class="dual-top">៛{{ number_format($rentRiel) }}</span>
                                    <span class="dual-bot">${{ number_format($invoice->room->rent_price) }}</span>
                                </td>
                                <td class="tc">
                                    <span class="dual-top">{{ $monthParsed->format('M Y') }}</span>
                                    <span class="dual-bot">{{ $invoice->month }}</span>
                                </td>
                                {{-- electric --}}
                                <td class="tc">{{ number_format($invoice->electric_new) }}</td>
                                <td class="tc">{{ number_format($invoice->electric_old) }}</td>
                                <td class="tc">{{ number_format($invoice->electric_used) }}</td>
                                <td class="tc">
                                    <span class="dual-top">៛{{ number_format($elecRiel) }}</span>
                                    <span class="dual-bot">${{ number_format($invoice->electric_used_price, 2) }}</span>
                                </td>
                                {{-- water --}}
                                <td class="tc">{{ number_format($invoice->water_new) }}</td>
                                <td class="tc">{{ number_format($invoice->water_old) }}</td>
                                <td class="tc">{{ number_format($invoice->water_used) }}</td>
                                <td class="tc">
                                    <span class="dual-top">៛{{ number_format($waterRiel) }}</span>
                                    <span class="dual-bot">${{ number_format($invoice->water_used_price, 2) }}</span>
                                </td>
                                {{-- total --}}
                                <td class="tc">
                                    <span class="dual-top total-hi">៛{{ number_format($totalRiel) }}</span>
                                    <span class="dual-bot">${{ number_format($invoice->total_amount, 2) }}</span>
                                </td>
                                {{-- status --}}
                                <td class="tc">
                                    <label class="status-switch" title="Toggle paid / unpaid">
                                        <input type="checkbox" class="status-switch-input"
                                            data-invoice-id="{{ $invoice->id }}"
                                            {{ $invoice->status === 'paid' ? 'checked' : '' }}
                                            onchange="toggleInvoiceStatus(this)">
                                        <span class="status-switch-track">
                                            <span class="status-switch-thumb"></span>
                                        </span>
                                        <span class="status-switch-label">{{ $invoice->status === 'paid' ? 'Paid' : 'Unpaid' }}</span>
                                    </label>
                                </td>
                                {{-- action --}}
                                <td class="tc">
                                    <button class="btn-view" onclick="openModal({{ $invoice->id }})" title="View">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="tc-empty">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    <p>No invoices
                                        found{{ request('month') ? ' for ' . \Carbon\Carbon::parse(request('month') . '-01')->format('F Y') : '' }}
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="inv-pagination">
                {{ $invoices->withQueryString()->links('vendor.pagination.back.custom') }}
            </div>
        </div>
    </div>

    {{-- ── Modal shell ── --}}
    <div id="modal-overlay" class="modal-overlay" onclick="closeModal(event)">
        <div class="modal-wrap" id="modal-wrap">
            <div class="modal-topbar">
                <div class="modal-tabs">
                    <span class="mtab mtab-active" id="tab-print">🖨 Portrait</span>
                </div>
                <button class="modal-x" onclick="closeModalDirect()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div id="modal-body"></div>
            <div id="modal-print"></div>
        </div>
    </div>

    {{-- Hidden modal data --}}
    @foreach ($invoices as $invoice)
        @php
            $ex = 4100;
            $rentRiel = $invoice->room->rent_price * $ex;
            $elecRiel = $invoice->electric_used_price * $ex;
            $waterRiel = $invoice->water_used_price * $ex;
            $totalRiel = $invoice->total_amount * $ex;
            $monthParsed = \Carbon\Carbon::parse($invoice->month . '-01');
        @endphp
        <template id="modal-data-{{ $invoice->id }}">
            <div class="md-title-block">
                <p class="md-title">
                    វិក្កយបត្របន្ទប់ <strong>#{{ $invoice->room->number }}</strong>
                    &nbsp;—&nbsp;
                    <strong>{{ $monthParsed->locale('km')->translatedFormat('F Y') }}</strong>
                </p>
            </div>
            <div class="md-parties">
                <div class="md-party">
                    <img src="{{ asset('/default-images/user-icon/normalGirl.png') }}" class="md-avatar" alt="">
                    <div>
                        <p class="md-pname">{{ $invoice->tenant->name }}</p>
                        <p class="md-prole">អ្នកជួល</p>
                    </div>
                </div>
                <div class="md-party">
                    <img src="{{ asset('/default-images/user-icon/ata.png') }}" class="md-avatar" alt="">
                    <div>
                        <p class="md-pname">Ly Anita</p>
                        <p class="md-prole">អ្នកទទួល</p>
                    </div>
                </div>
            </div>
            <div class="md-lines">
                <div class="md-line">
                    <div class="md-line-left">
                        <div class="md-ico"><img src="{{ asset('/default-images/material-images/room.png') }}"
                                alt=""></div>
                        <div>
                            <p class="md-lbl">ថ្លៃបន្ទប់</p>
                            <p class="md-desc">តម្លៃ <strong>${{ number_format($invoice->room->rent_price) }}</strong>
                                &nbsp;($1 = ៛4150)</p>
                        </div>
                    </div>
                    <div class="md-amt">
                        <span>៛{{ number_format($rentRiel) }}</span>
                        <small>${{ number_format($invoice->room->rent_price) }}</small>
                    </div>
                </div>
                <div class="md-line">
                    <div class="md-line-left">
                        <div class="md-ico"><img src="{{ asset('/default-images/material-images/kwh.png') }}"
                                alt=""></div>
                        <div>
                            <p class="md-lbl">ថ្លៃភ្លើង (kWh)</p>
                            <p class="md-desc">
                                ថ្មី <strong>{{ number_format($invoice->electric_new) }}</strong>
                                − ចាស់ <strong>{{ number_format($invoice->electric_old) }}</strong>
                                = ប្រើ <strong>{{ number_format($invoice->electric_used) }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="md-amt">
                        <span>៛{{ number_format($elecRiel) }}</span>
                        <small>${{ number_format($invoice->electric_used_price, 2) }}</small>
                    </div>
                </div>
                <div class="md-line">
                    <div class="md-line-left">
                        <div class="md-ico"><img src="{{ asset('/default-images/material-images/m3.png') }}"
                                alt=""></div>
                        <div>
                            <p class="md-lbl">ថ្លៃទឹក (m³)</p>
                            <p class="md-desc">
                                ថ្មី <strong>{{ number_format($invoice->water_new) }}</strong>
                                − ចាស់ <strong>{{ number_format($invoice->water_old) }}</strong>
                                = ប្រើ <strong>{{ number_format($invoice->water_used) }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="md-amt">
                        <span>៛{{ number_format($waterRiel) }}</span>
                        <small>${{ number_format($invoice->water_used_price, 2) }}</small>
                    </div>
                </div>
                <div class="md-divider"></div>
                <div class="md-line md-total-line">
                    <div class="md-line-left">
                        <div class="md-ico"><img src="{{ asset('/default-images/material-images/calculater.png') }}"
                                alt=""></div>
                        <div>
                            <p class="md-lbl md-lbl-total">សរុបទាំងអស់</p>
                            <p class="md-desc">
                                ៛{{ number_format($rentRiel) }} + ៛{{ number_format($elecRiel) }} +
                                ៛{{ number_format($waterRiel) }}
                            </p>
                        </div>
                    </div>
                    <div class="md-amt md-amt-total">
                        <span>៛{{ number_format($totalRiel) }}</span>
                        <small>${{ number_format($invoice->total_amount, 2) }}</small>
                    </div>
                </div>
            </div>
        </template>

        <template id="print-data-{{ $invoice->id }}">
            <div class="pinv">
                <div class="pinv-head">
                    <div class="pinv-head-left">
                        <div class="pinv-logo">🏠</div>
                        <div>
                            <p class="pinv-biz">Ly Anita Properties</p>
                            <p class="pinv-biz-sub">វិក្កយបត្រជួលបន្ទប់</p>
                        </div>
                    </div>
                    <div class="pinv-head-right">
                        <p class="pinv-inv-no">INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</p>
                        <p class="pinv-inv-date">{{ $monthParsed->format('F Y') }}</p>
                    </div>
                </div>
                <div class="pinv-strip">
                    <div class="pinv-strip-item">
                        <span class="pinv-strip-lbl">បន្ទប់</span>
                        <span class="pinv-strip-val">#{{ $invoice->room->number }}</span>
                    </div>
                    <div class="pinv-strip-divider"></div>
                    <div class="pinv-strip-item">
                        <span class="pinv-strip-lbl">អ្នកជួល</span>
                        <span class="pinv-strip-val">{{ $invoice->tenant->name }}</span>
                    </div>
                    <div class="pinv-strip-divider"></div>
                    <div class="pinv-strip-item">
                        <span class="pinv-strip-lbl">ខែ</span>
                        <span class="pinv-strip-val">{{ $monthParsed->locale('km')->translatedFormat('F Y') }}</span>
                    </div>
                </div>
                <table class="pinv-tbl">
                    <thead>
                        <tr>
                            <th class="pinv-th">ថ្លៃបង់</th>
                            <th class="pinv-th pinv-th-center">ចាស់</th>
                            <th class="pinv-th pinv-th-center">ថ្មី</th>
                            <th class="pinv-th pinv-th-center">ប្រើ</th>
                            <th class="pinv-th pinv-th-right">តម្លៃ (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="pinv-tr">
                            <td class="pinv-td">
                                <div class="pinv-item-name">🏠 ថ្លៃបន្ទប់</div>
                                <div class="pinv-item-note">$1 = ៛4,150</div>
                            </td>
                            <td class="pinv-td pinv-td-center">—</td>
                            <td class="pinv-td pinv-td-center">—</td>
                            <td class="pinv-td pinv-td-center">—</td>
                            <td class="pinv-td pinv-td-right">${{ number_format($invoice->room->rent_price, 2) }}</td>
                        </tr>
                        <tr class="pinv-tr">
                            <td class="pinv-td">
                                <div class="pinv-item-name">⚡ ថ្លៃភ្លើង (kWh)</div>
                                <div class="pinv-item-note">Rate:
                                    ${{ number_format($invoice->electric_used > 0 ? $invoice->electric_used_price / $invoice->electric_used : 0, 2) }}/kWh
                                </div>
                            </td>
                            <td class="pinv-td pinv-td-center">{{ number_format($invoice->electric_old) }}</td>
                            <td class="pinv-td pinv-td-center">{{ number_format($invoice->electric_new) }}</td>
                            <td class="pinv-td pinv-td-center">{{ number_format($invoice->electric_used) }}</td>
                            <td class="pinv-td pinv-td-right">${{ number_format($invoice->electric_used_price, 2) }}</td>
                        </tr>
                        <tr class="pinv-tr">
                            <td class="pinv-td">
                                <div class="pinv-item-name">💧 ថ្លៃទឹក (m³)</div>
                                <div class="pinv-item-note">Rate:
                                    ${{ number_format($invoice->water_used > 0 ? $invoice->water_used_price / $invoice->water_used : 0, 2) }}/m³
                                </div>
                            </td>
                            <td class="pinv-td pinv-td-center">{{ number_format($invoice->water_old) }}</td>
                            <td class="pinv-td pinv-td-center">{{ number_format($invoice->water_new) }}</td>
                            <td class="pinv-td pinv-td-center">{{ number_format($invoice->water_used) }}</td>
                            <td class="pinv-td pinv-td-right">${{ number_format($invoice->water_used_price, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="pinv-total-row">
                            <td colspan="4" class="pinv-total-lbl">សរុបទាំងអស់</td>
                            <td class="pinv-total-val">${{ number_format($invoice->total_amount, 2) }}</td>
                        </tr>
                        <tr class="pinv-riel-row">
                            <td colspan="4" class="pinv-riel-lbl">ស្មើនឹង (៛)</td>
                            <td class="pinv-riel-val">៛{{ number_format($totalRiel) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="pinv-note">
                    <span class="pinv-note-icon">📌</span>
                    <span>សូមបង់ប្រាក់មុនថ្ងៃទី <strong>05</strong> នៃខែ។ អរគុណសម្រាប់ការជឿទុកចិត្ត។</span>
                </div>
                <div class="pinv-footer">
                    <div class="pinv-sig">
                        <div class="pinv-sig-line"></div>
                        <p>អ្នកជួល: {{ $invoice->tenant->name }}</p>
                    </div>
                    <div class="pinv-sig">
                        <div class="pinv-sig-line"></div>
                        <p>អ្នកទទួល: Ly Anita</p>
                    </div>
                </div>
                <div class="pinv-print-btn-wrap">
                    <button onclick="window.print()" class="pinv-print-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 6 2 18 2 18 9" />
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                            <rect x="6" y="14" width="12" height="8" />
                        </svg>
                        Print / Save PDF
                    </button>
                </div>
            </div>
        </template>
    @endforeach

    {{-- JSZip CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    {{-- Flatpickr month picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/index.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.css">
    <script>
        flatpickr('#month-picker', {
            altInputClass: 'inv-month-input',
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: 'Y-m',
                    altFormat: 'F Y',
                    theme: 'light',
                }),
            ],
            defaultDate: '{{ $selectedMonth ?? request('month', now()->format('Y-m')) }}',
            onChange: function () {
                document.getElementById('inv-search-form').submit();
            },
        });
    </script>

    <script>
        // ── Modal ──────────────────────────────────────────────
        let currentInvoiceId = null;

        function openModal(id) {
            currentInvoiceId = id;
            const ptpl = document.getElementById('print-data-' + id);
            if (!ptpl) return;
            document.getElementById('modal-body').innerHTML = '';
            document.getElementById('modal-body').style.display = 'none';
            document.getElementById('modal-print').innerHTML = ptpl.innerHTML;
            document.getElementById('modal-print').style.display = 'block';
            document.getElementById('modal-overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalDirect() {
            document.getElementById('modal-overlay').classList.remove('active');
            document.body.style.overflow = '';
            currentInvoiceId = null;
        }

        function closeModal(e) {
            if (e.target === document.getElementById('modal-overlay')) closeModalDirect();
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModalDirect();
        });

        // ── Checkbox logic ─────────────────────────────────────
        function getChecked() {
            return [...document.querySelectorAll('.row-cb:checked')];
        }

        function onRowCheckChange() {
            const checked = getChecked();
            const total = document.querySelectorAll('.row-cb').length;
            const toolbar = document.getElementById('bulk-toolbar');
            const countEl = document.getElementById('bulk-count');
            const selectAll = document.getElementById('select-all');

            countEl.textContent = checked.length;
            selectAll.indeterminate = checked.length > 0 && checked.length < total;
            selectAll.checked = checked.length === total;

            if (checked.length > 0) {
                toolbar.classList.add('active');
            } else {
                toolbar.classList.remove('active');
            }

            // Update ZIP name preview in button
            updateZipLabel();
        }

        function toggleSelectAll(master) {
            document.querySelectorAll('.row-cb').forEach(cb => {
                cb.checked = master.checked;
            });
            onRowCheckChange();
        }

        // ── Paid / unpaid switch ────────────────────────────────
        function showInvoiceToast(message, isError) {
            const el = document.createElement('div');
            el.textContent = message;
            el.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;' +
                'padding:12px 20px;border-radius:12px;font-size:14px;font-weight:600;' +
                'box-shadow:0 10px 30px rgba(0,0,0,.15);transition:opacity .25s ease,transform .25s ease;' +
                'opacity:0;transform:translateX(24px);' +
                (isError
                    ? 'background:#FDEDEC;color:#E23738;border:1px solid #E23738;'
                    : 'background:#E9FAF0;color:#50D1B2;border:1px solid #50D1B2;');
            document.body.appendChild(el);
            requestAnimationFrame(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateX(0)';
            });
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(24px)';
                setTimeout(() => el.remove(), 250);
            }, 2500);
        }

        function toggleInvoiceStatus(checkbox) {
            const id = checkbox.dataset.invoiceId;
            const label = checkbox.closest('.status-switch').querySelector('.status-switch-label');
            const newStatus = checkbox.checked ? 'paid' : 'unpaid';
            const previousChecked = !checkbox.checked;

            checkbox.disabled = true;
            label.textContent = newStatus === 'paid' ? 'Paid' : 'Unpaid';

            fetch(`/invoices/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: newStatus }),
            })
                .then(res => {
                    if (!res.ok) throw new Error('Request failed');
                    return res.json();
                })
                .then(() => {
                    showInvoiceToast(`Marked as ${newStatus}.`, false);
                })
                .catch(() => {
                    checkbox.checked = previousChecked;
                    label.textContent = previousChecked ? 'Paid' : 'Unpaid';
                    showInvoiceToast('Could not update status. Try again.', true);
                })
                .finally(() => {
                    checkbox.disabled = false;
                });
        }

        function deselectAll() {
            document.querySelectorAll('.row-cb').forEach(cb => cb.checked = false);
            document.getElementById('select-all').checked = false;
            onRowCheckChange();
        }

        // ── ZIP name builder ───────────────────────────────────
        function buildZipName() {
            const checked = getChecked();
            if (!checked.length) return 'INVOICES.zip';

            // Use month from first checked row's data-month attr (format: YYYY-MM)
            const rawMonth = checked[0].dataset.month || '';
            let monthPart = 'INVOICES';
            if (rawMonth) {
                const d = new Date(rawMonth + '-01');
                const mon = d.toLocaleString('en-US', {
                    month: 'long'
                }).toUpperCase(); // e.g. JUNE
                const yr = d.getFullYear(); // e.g. 2026
                monthPart = mon + yr;
            }

            // Page number from URL ?page= param (default 1)
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page') || '1';

            return `${monthPart}P${page}.zip`;
        }

        function updateZipLabel() {
            const label = document.getElementById('bulk-download-label');
            const checked = getChecked();
            if (checked.length === 0) {
                label.textContent = 'Download ZIP';
                return;
            }
            label.textContent = `Download ${buildZipName()}`;
        }

        // ── PDF fetch + ZIP ────────────────────────────────────
        async function downloadSelectedAsZip() {
            const checked = getChecked();
            if (!checked.length) return;

            const btn = document.getElementById('bulk-download-btn');
            btn.disabled = true;
            btn.innerHTML = `
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="spin">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                </svg>
                <span>Generating…</span>
            `;

            try {
                const zip = new JSZip();

                // Fetch PDFs in parallel (each invoice has a /invoices/{id}/pdf route)
                const fetches = checked.map(async (cb) => {
                    const id = cb.value;
                    const room = cb.dataset.room || id;

                    const response = await fetch(`/invoices/${id}/pdf`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) throw new Error(`Failed for invoice ${id}`);

                    const blob = await response.blob();
                    // File name: room number, sanitised
                    const fileName = `Room_${String(room).replace(/[^a-zA-Z0-9_\-]/g, '_')}.pdf`;
                    zip.file(fileName, blob);
                });

                await Promise.all(fetches);

                const zipBlob = await zip.generateAsync({
                    type: 'blob'
                });
                const zipName = buildZipName();
                const url = URL.createObjectURL(zipBlob);
                const a = document.createElement('a');
                a.href = url;
                a.download = zipName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

            } catch (err) {
                console.error(err);
                alert('Error generating ZIP. Please try again.\n' + err.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span id="bulk-download-label">Download ${buildZipName()}</span>
                `;
            }
        }
    </script>

    <style>
        /* ── Checkbox ──────────────────────────────────────────── */
        .th-check {
            width: 40px;
        }

        .tc-check {
            width: 40px;
        }

        .cb-wrap {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .cb-wrap input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .cb-box {
            width: 16px;
            height: 16px;
            border: 2px solid #D1D5DB;
            border-radius: 4px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            flex-shrink: 0;
        }

        .dark .cb-box {
            border-color: #4B5563;
            background: #1E2130;
        }

        .cb-wrap input:checked+.cb-box {
            background: #7364DB;
            border-color: #7364DB;
        }

        .cb-wrap input:indeterminate+.cb-box {
            background: #7364DB;
            border-color: #7364DB;
        }

        .cb-wrap input:checked+.cb-box::after {
            content: '';
            display: block;
            width: 4px;
            height: 7px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg) translateY(-1px);
        }

        .cb-wrap input:indeterminate+.cb-box::after {
            content: '';
            display: block;
            width: 8px;
            height: 2px;
            background: #fff;
            border-radius: 1px;
        }

        /* Row highlight when checked */
        .inv-tr:has(.row-cb:checked) td {
            background: #F5F3FF !important;
        }

        .dark .inv-tr:has(.row-cb:checked) td {
            background: #241F4A !important;
        }

        /* ── Paid / unpaid switch ───────────────────────────────── */
        .status-switch {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .status-switch-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .status-switch-track {
            position: relative;
            width: 36px;
            height: 20px;
            border-radius: 999px;
            background: #E23738;
            flex-shrink: 0;
            transition: background .15s ease;
        }

        .status-switch-thumb {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .25);
            transition: transform .15s ease;
        }

        .status-switch-input:checked+.status-switch-track {
            background: #50D1B2;
        }

        .status-switch-input:checked+.status-switch-track .status-switch-thumb {
            transform: translateX(16px);
        }

        .status-switch-input:disabled+.status-switch-track {
            opacity: .5;
        }

        .status-switch-label {
            font-size: 11px;
            font-weight: 600;
            min-width: 40px;
            color: #E23738;
        }

        .status-switch-input:checked~.status-switch-label {
            color: #50D1B2;
        }

        /* ── Bulk toolbar ───────────────────────────────────────── */
        .bulk-toolbar {
            display: none;
            margin-bottom: 16px;
        }

        .bulk-toolbar.active {
            display: block;
            animation: slideDown .2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .bulk-toolbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #F1EEFC;
            border: 1px solid #C7D2FE;
            border-radius: 12px;
            padding: 10px 16px;
            gap: 12px;
        }

        .dark .bulk-toolbar-inner {
            background: #241F4A;
            border-color: #4A3F99;
        }

        .bulk-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #5B4BC7;
        }

        .dark .bulk-info {
            color: #C3B8F5;
        }

        .bulk-check-icon {
            width: 22px;
            height: 22px;
            background: #7364DB;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .bulk-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .bulk-deselect {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 7px;
            border: 1px solid #C7D2FE;
            background: #fff;
            color: #6B7280;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .dark .bulk-deselect {
            background: #252A3A;
            border-color: #4A3F99;
            color: #9CA3AF;
        }

        .bulk-deselect:hover {
            background: #F3F4F6;
            color: #374151;
        }

        .dark .bulk-deselect:hover {
            background: #2E3347;
        }

        .bulk-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 7px;
            border: none;
            background: #7364DB;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
        }

        .bulk-download:hover {
            background: #5F4FC4;
        }

        .bulk-download:disabled {
            opacity: .7;
            cursor: not-allowed;
        }

        /* Spinner animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .spin {
            animation: spin .8s linear infinite;
        }

        /* ── Page ── */
        .inv-page {
            padding-bottom: 60px;
        }

        /* ── Search ── */
        .inv-search {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .dark .inv-search {
            background: #1E2130;
            border-color: #2E3347;
        }

        .inv-search-inner {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #9CA3AF;
        }

        .inv-month-input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            width: 130px;
        }

        .dark .inv-month-input {
            color: #D1D5DB;
        }

        /* ── Flatpickr month picker theme ── */
        .flatpickr-calendar {
            border-radius: 14px !important;
            border: 1px solid #E5E7EB !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .1) !important;
            font-family: inherit !important;
        }

        .flatpickr-calendar.arrowTop:before,
        .flatpickr-calendar.arrowTop:after {
            display: none !important;
        }

        .flatpickr-current-month {
            font-size: 14px !important;
        }

        .flatpickr-monthSelect-months {
            padding: 4px 10px 10px !important;
        }

        .flatpickr-monthSelect-month {
            border-radius: 8px !important;
        }

        .flatpickr-monthSelect-month:hover {
            background: #F1EEFC !important;
        }

        .flatpickr-monthSelect-month.selected,
        .flatpickr-monthSelect-month.selected:hover {
            background: #7364DB !important;
            color: #fff !important;
        }

        .numInputWrapper span.arrowUp:after {
            border-bottom-color: #7364DB !important;
        }

        .numInputWrapper span.arrowDown:after {
            border-top-color: #7364DB !important;
        }

        .dark .flatpickr-calendar {
            background: #1E2130 !important;
            border-color: #2E3347 !important;
            color: #D1D5DB !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35) !important;
        }

        .dark .flatpickr-current-month,
        .dark .flatpickr-current-month input.cur-year {
            color: #D1D5DB !important;
        }

        .dark .flatpickr-monthSelect-month {
            color: #D1D5DB !important;
        }

        .dark .flatpickr-monthSelect-month:hover {
            background: #2E3347 !important;
        }

        /* ── Card ── */
        .inv-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 22px 22px 0;
            margin-bottom: 48px;
        }

        .dark .inv-card {
            background: #1E2130;
            border-color: #2E3347;
        }

        .inv-card-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .inv-card-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .dark .inv-card-title {
            color: #F3F4F6;
        }

        .inv-month-badge {
            background: #F1EEFC;
            color: #5B4BC7;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .dark .inv-month-badge {
            background: #312E81;
            color: #C3B8F5;
        }

        /* ── Table ── */
        .inv-scroll {
            overflow-x: auto;
            scrollbar-width: none;
        }

        .inv-scroll::-webkit-scrollbar {
            display: none;
        }

        .inv-tbl {
            width: 100%;
            min-width: 1020px;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .inv-tbl th,
        .inv-tbl td {
            padding: 0;
            text-align: center;
        }

        .th-base {
            background: #FEF3C7;
            color: #92400E;
            font-size: 11px;
            font-weight: 700;
            padding: 10px 8px;
            border-bottom: 2px solid #FDE68A;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .dark .th-base {
            background: #2D2408;
            color: #FDE68A;
            border-color: #4D3A0A;
        }

        .th-elec {
            background: #FEE2E2;
            color: #991B1B;
            font-size: 11px;
            font-weight: 700;
            padding: 9px 8px;
            border-bottom: 2px solid #FECACA;
        }

        .dark .th-elec {
            background: #3B0A0A;
            color: #FCA5A5;
            border-color: #7F1D1D;
        }

        .th-water {
            background: #DBEAFE;
            color: #1E40AF;
            font-size: 11px;
            font-weight: 700;
            padding: 9px 8px;
            border-bottom: 2px solid #BFDBFE;
        }

        .dark .th-water {
            background: #0A1E3B;
            color: #93C5FD;
            border-color: #1E3A6E;
        }

        .th-sub {
            background: #FFFBEB;
            color: #78350F;
            font-size: 11px;
            font-weight: 600;
            padding: 7px 6px;
            border-bottom: 1px solid #E5E7EB;
        }

        .dark .th-sub {
            background: #1A1408;
            color: #FCD34D;
            border-color: #2E3347;
        }

        .inv-tr td {
            border-bottom: 1px solid #F3F4F6;
            padding: 15px 8px;
            color: #374151;
            font-weight: 500;
        }

        .dark .inv-tr td {
            border-color: #2E3347;
            color: #D1D5DB;
        }

        .inv-tr:last-child td {
            border-bottom: none;
        }

        .inv-tr:hover td {
            background: #F9FAFB;
        }

        .dark .inv-tr:hover td {
            background: #252A3A;
        }

        .tc {
            text-align: center;
            vertical-align: middle;
        }

        .tc-muted {
            color: #9CA3AF;
            font-size: 12px;
        }

        .tc-bold {
            font-weight: 700;
            color: #111827;
        }

        .dark .tc-bold {
            color: #F9FAFB;
        }

        .room-pill {
            display: inline-block;
            background: #F1EEFC;
            color: #5B4BC7;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 5px;
        }

        .dark .room-pill {
            background: #312E81;
            color: #C3B8F5;
        }

        .dual-top {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #111827;
        }

        .dark .dual-top {
            color: #F3F4F6;
        }

        .dual-bot {
            display: block;
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 2px;
        }

        .total-hi {
            color: #5F4FC4 !important;
        }

        .dark .total-hi {
            color: #818CF8 !important;
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid #E5E7EB;
            background: #F9FAFB;
            color: #6B7280;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-view:hover {
            border-color: #7364DB;
            color: #7364DB;
            background: #F1EEFC;
        }

        .dark .btn-view {
            background: #252A3A;
            border-color: #2E3347;
            color: #9CA3AF;
        }

        .dark .btn-view:hover {
            border-color: #818CF8;
            color: #818CF8;
            background: #241F4A;
        }

        .tc-empty {
            padding: 56px 0 !important;
        }

        .tc-empty svg,
        .tc-empty p {
            display: block;
            margin: 0 auto;
            color: #9CA3AF;
        }

        .tc-empty p {
            font-size: 14px;
            margin-top: 10px;
        }

        .inv-pagination {
            padding: 18px 0;
        }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-wrap {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 660px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 28px 28px 22px;
            position: relative;
            scrollbar-width: thin;
            animation: mdIn .18s ease;
        }

        .dark .modal-wrap {
            background: #1E2130;
        }

        @keyframes mdIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .modal-x {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid #E5E7EB;
            background: #F9FAFB;
            color: #6B7280;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .modal-x:hover {
            background: #FEE2E2;
            border-color: #FECACA;
            color: #DC2626;
        }

        .dark .modal-x {
            background: #252A3A;
            border-color: #2E3347;
            color: #9CA3AF;
        }

        .md-title-block {
            background: #F5F3FF;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 22px;
            text-align: center;
        }

        .dark .md-title-block {
            background: #241F4A;
        }

        .md-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0;
            line-height: 1.7;
        }

        .dark .md-title {
            color: #D1D5DB;
        }

        .md-title strong {
            color: #7364DB;
        }

        .dark .md-title strong {
            color: #818CF8;
        }

        .md-parties {
            display: flex;
            gap: 12px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .md-party {
            flex: 1;
            min-width: 180px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 14px;
        }

        .dark .md-party {
            background: #252A3A;
            border-color: #2E3347;
        }

        .md-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            flex-shrink: 0;
        }

        .dark .md-avatar {
            border-color: #2E3347;
        }

        .md-pname {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 2px;
        }

        .dark .md-pname {
            color: #F3F4F6;
        }

        .md-prole {
            font-size: 11px;
            color: #9CA3AF;
            margin: 0 0 8px;
        }

        .md-lines {
            margin-bottom: 20px;
        }

        .md-line {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .dark .md-line {
            border-color: #2E3347;
        }

        .md-line-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            flex: 1;
        }

        .md-ico {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dark .md-ico {
            background: #2E3347;
        }

        .md-ico img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        .dark .md-ico img {
            filter: invert(1);
        }

        .md-lbl {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px;
        }

        .dark .md-lbl {
            color: #F3F4F6;
        }

        .md-lbl-total {
            color: #5F4FC4;
            font-size: 14px;
        }

        .dark .md-lbl-total {
            color: #818CF8;
        }

        .md-desc {
            font-size: 12px;
            color: #6B7280;
            margin: 0;
            line-height: 1.6;
        }

        .md-desc strong {
            color: #374151;
        }

        .dark .md-desc strong {
            color: #E5E7EB;
        }

        .md-amt {
            text-align: right;
            background: #F1EEFC;
            color: #5B4BC7;
            border-radius: 8px;
            padding: 7px 12px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .dark .md-amt {
            background: #241F4A;
            color: #C3B8F5;
        }

        .md-amt span {
            display: block;
            font-size: 13px;
            font-weight: 700;
        }

        .md-amt small {
            display: block;
            font-size: 11px;
            margin-top: 2px;
            opacity: .75;
        }

        .md-amt-total {
            background: #5F4FC4;
            color: #fff;
        }

        .dark .md-amt-total {
            background: #5B4BC7;
            color: #F1EEFC;
        }

        .md-divider {
            height: 1px;
            background: #E5E7EB;
            margin: 4px 0;
        }

        .dark .md-divider {
            background: #2E3347;
        }

        .modal-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 16px;
            margin-bottom: 4px;
            border-bottom: 1px solid #F3F4F6;
        }

        .dark .modal-topbar {
            border-color: #2E3347;
        }

        .modal-tabs {
            display: flex;
            gap: 4px;
            background: #F3F4F6;
            border-radius: 8px;
            padding: 3px;
        }

        .dark .modal-tabs {
            background: #252A3A;
        }

        .mtab {
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            color: #6B7280;
            padding: 5px 14px;
            border-radius: 6px;
            transition: all .15s;
        }

        .mtab-active {
            background: #fff;
            color: #5F4FC4;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        }

        .dark .mtab-active {
            background: #1E2130;
            color: #818CF8;
        }

        /* ── Portrait invoice ── */
        .pinv {
            font-family: 'Khmer OS', 'Hanuman', Georgia, serif;
            background: #fff;
            color: #1a1a2e;
            padding: 0;
        }

        .dark .pinv {
            background: #1E2130;
            color: #E5E7EB;
        }

        .pinv-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border-radius: 12px;
            padding: 20px 22px;
            margin-bottom: 18px;
            color: #fff;
        }

        .pinv-head-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .pinv-logo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .pinv-biz {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 2px;
            letter-spacing: .3px;
        }

        .pinv-biz-sub {
            font-size: 11px;
            opacity: .65;
            margin: 0;
        }

        .pinv-head-right {
            text-align: right;
        }

        .pinv-inv-no {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 3px;
            letter-spacing: 1px;
            color: #e2c97e;
        }

        .pinv-inv-date {
            font-size: 11px;
            opacity: .7;
            margin: 0;
        }

        .pinv-strip {
            display: flex;
            align-items: center;
            background: #F8F7FF;
            border: 1px solid #E8E4FF;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 18px;
            gap: 0;
        }

        .dark .pinv-strip {
            background: #252A3A;
            border-color: #2E3347;
        }

        .pinv-strip-item {
            flex: 1;
            text-align: center;
        }

        .pinv-strip-lbl {
            display: block;
            font-size: 10px;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .pinv-strip-val {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .dark .pinv-strip-val {
            color: #F3F4F6;
        }

        .pinv-strip-divider {
            width: 1px;
            height: 32px;
            background: #E5E7EB;
            flex-shrink: 0;
        }

        .dark .pinv-strip-divider {
            background: #2E3347;
        }

        .pinv-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .pinv-th {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #6B7280;
            padding: 9px 12px;
            border-bottom: 2px solid #E5E7EB;
            text-align: left;
        }

        .dark .pinv-th {
            color: #9CA3AF;
            border-color: #2E3347;
        }

        .pinv-th-center {
            text-align: center;
        }

        .pinv-th-right {
            text-align: right;
        }

        .pinv-tr:hover {
            background: #F9FAFB;
        }

        .dark .pinv-tr:hover {
            background: #252A3A;
        }

        .pinv-td {
            padding: 13px 12px;
            border-bottom: 1px solid #F3F4F6;
            font-size: 13px;
            vertical-align: middle;
        }

        .dark .pinv-td {
            border-color: #2E3347;
        }

        .pinv-td-center {
            text-align: center;
            color: #374151;
            font-weight: 600;
        }

        .dark .pinv-td-center {
            color: #D1D5DB;
        }

        .pinv-td-right {
            text-align: right;
            font-weight: 700;
            color: #1a1a2e;
        }

        .dark .pinv-td-right {
            color: #F3F4F6;
        }

        .pinv-item-name {
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 2px;
        }

        .dark .pinv-item-name {
            color: #F3F4F6;
        }

        .pinv-item-note {
            font-size: 11px;
            color: #9CA3AF;
        }

        .pinv-total-row {
            background: #1a1a2e;
        }

        .dark .pinv-total-row {
            background: #0f3460;
        }

        .pinv-total-lbl {
            padding: 13px 12px;
            font-size: 13px;
            font-weight: 700;
            color: #e2c97e;
            letter-spacing: .3px;
        }

        .pinv-total-val {
            padding: 13px 12px;
            text-align: right;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
        }

        .pinv-riel-row {
            background: #F5F3FF;
        }

        .dark .pinv-riel-row {
            background: #241F4A;
        }

        .pinv-riel-lbl {
            padding: 8px 12px;
            font-size: 11px;
            color: #7C3AED;
            font-weight: 600;
        }

        .pinv-riel-val {
            padding: 8px 12px;
            text-align: right;
            font-size: 13px;
            font-weight: 700;
            color: #7C3AED;
        }

        .pinv-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #78350F;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .dark .pinv-note {
            background: #2D2408;
            border-color: #4D3A0A;
            color: #FCD34D;
        }

        .pinv-note-icon {
            flex-shrink: 0;
        }

        .pinv-footer {
            display: flex;
            gap: 24px;
            margin-bottom: 20px;
        }

        .pinv-sig {
            flex: 1;
            text-align: center;
        }

        .pinv-sig-line {
            height: 1px;
            background: #D1D5DB;
            margin: 0 16px 8px;
            margin-top: 40px;
        }

        .dark .pinv-sig-line {
            background: #374151;
        }

        .pinv-sig p {
            font-size: 11px;
            color: #6B7280;
            margin: 0;
        }

        .pinv-print-btn-wrap {
            text-align: center;
            padding-top: 4px;
        }

        .pinv-print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #1a1a2e;
            color: #e2c97e;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .15s;
            letter-spacing: .3px;
        }

        .pinv-print-btn:hover {
            opacity: .85;
        }

        @media print {
            .modal-overlay {
                position: static !important;
                background: none !important;
            }

            .modal-wrap {
                box-shadow: none !important;
                border-radius: 0 !important;
                max-height: none !important;
            }

            .modal-topbar,
            .pinv-print-btn-wrap {
                display: none !important;
            }
        }
    </style>
@endsection
