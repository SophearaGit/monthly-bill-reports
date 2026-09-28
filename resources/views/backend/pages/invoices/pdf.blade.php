<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 26px;
        }

        body {
            font-family: 'NotoSansKhmer', DejaVu Sans, sans-serif;
            background: #fff;
            color: #1a1a2e;
            margin: 0;
            padding: 0;
        }

        .pinv-head {
            width: 100%;
            background: #1a1a2e;
            border-radius: 12px;
            padding: 20px 22px;
            margin-bottom: 18px;
            color: #fff;
            border-collapse: collapse;
        }

        .pinv-head td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .pinv-head-left-tbl td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .pinv-logo-cell {
            width: 44px;
            padding-right: 14px !important;
        }

        .pinv-logo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .15);
            text-align: center;
            font-size: 15px;
            font-weight: 800;
            color: #e2c97e;
            padding-top: 13px;
        }

        .pinv-biz {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 2px;
        }

        .pinv-biz-sub {
            font-size: 11px;
            color: #cfd2e6;
            margin: 0;
        }

        .pinv-head-right {
            text-align: right;
            width: 40%;
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
            color: #cfd2e6;
            margin: 0;
        }

        .pinv-strip {
            width: 100%;
            background: #F8F7FF;
            border: 1px solid #E8E4FF;
            border-radius: 10px;
            margin-bottom: 18px;
            border-collapse: collapse;
        }

        .pinv-strip-item {
            text-align: center;
            padding: 12px 10px;
            border: none;
            width: 33%;
        }

        .pinv-strip-item-mid {
            border-left: 1px solid #E5E7EB;
            border-right: 1px solid #E5E7EB;
        }

        .pinv-strip-lbl {
            font-size: 10px;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .pinv-strip-val {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a2e;
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

        .pinv-th-center {
            text-align: center;
        }

        .pinv-th-right {
            text-align: right;
        }

        .pinv-td {
            padding: 13px 12px;
            border-bottom: 1px solid #F3F4F6;
            font-size: 13px;
            vertical-align: middle;
        }

        .pinv-td-center {
            text-align: center;
            color: #374151;
            font-weight: 600;
        }

        .pinv-td-right {
            text-align: right;
            font-weight: 700;
            color: #1a1a2e;
        }

        .pinv-item-name {
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 2px;
        }

        .pinv-item-note {
            font-size: 11px;
            color: #9CA3AF;
        }

        .pinv-total-row {
            background: #1a1a2e;
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
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #78350F;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .pinv-footer {
            width: 100%;
            margin-bottom: 4px;
            border-collapse: collapse;
        }

        .pinv-footer td {
            width: 50%;
            text-align: center;
            border: none;
            padding: 0 16px;
        }

        .pinv-sig-line {
            height: 1px;
            background: #D1D5DB;
            margin-top: 40px;
            margin-bottom: 8px;
        }

        .pinv-sig p {
            font-size: 11px;
            color: #6B7280;
            margin: 0;
        }
    </style>
</head>
<body>
            <div class="pinv">
                <table class="pinv-head"><tr>
                    <td class="pinv-head-left-cell">
                        <table class="pinv-head-left-tbl"><tr>
                            <td class="pinv-logo-cell"><div class="pinv-logo">Ly</div></td>
                            <td>
                                <p class="pinv-biz">Ly Anita Properties</p>
                                <p class="pinv-biz-sub">វិក្កយបត្រជួលបន្ទប់</p>
                            </td>
                        </tr></table>
                    </td>
                    <td class="pinv-head-right">
                        <p class="pinv-inv-no">INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</p>
                        <p class="pinv-inv-date">{{ $monthParsed->format('F Y') }}</p>
                    </td>
                </tr></table>
                <table class="pinv-strip"><tr>
                    <td class="pinv-strip-item">
                        <span class="pinv-strip-lbl">បន្ទប់</span><br>
                        <span class="pinv-strip-val">#{{ $invoice->room->number }}</span>
                    </td>
                    <td class="pinv-strip-item pinv-strip-item-mid">
                        <span class="pinv-strip-lbl">អ្នកជួល</span><br>
                        <span class="pinv-strip-val">{{ $invoice->tenant->name }}</span>
                    </td>
                    <td class="pinv-strip-item">
                        <span class="pinv-strip-lbl">ខែ</span><br>
                        <span class="pinv-strip-val">{{ $monthParsed->locale('km')->translatedFormat('F Y') }}</span>
                    </td>
                </tr></table>
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
                                <div class="pinv-item-name">ថ្លៃបន្ទប់</div>
                                <div class="pinv-item-note">$1 = ៛4,150</div>
                            </td>
                            <td class="pinv-td pinv-td-center">—</td>
                            <td class="pinv-td pinv-td-center">—</td>
                            <td class="pinv-td pinv-td-center">—</td>
                            <td class="pinv-td pinv-td-right">${{ number_format($invoice->room->rent_price, 2) }}</td>
                        </tr>
                        <tr class="pinv-tr">
                            <td class="pinv-td">
                                <div class="pinv-item-name">ថ្លៃភ្លើង (kWh)</div>
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
                                <div class="pinv-item-name">ថ្លៃទឹក (m³)</div>
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
                    <span>សូមបង់ប្រាក់មុនថ្ងៃទី <strong>05</strong> នៃខែ។ អរគុណសម្រាប់ការជឿទុកចិត្ត។</span>
                </div>
                <table class="pinv-footer"><tr>
                    <td class="pinv-sig">
                        <div class="pinv-sig-line"></div>
                        <p>អ្នកជួល: {{ $invoice->tenant->name }}</p>
                    </td>
                    <td class="pinv-sig">
                        <div class="pinv-sig-line"></div>
                        <p>អ្នកទទួល: Ly Anita</p>
                    </td>
                </tr></table>
            </div>
</body>
</html>
