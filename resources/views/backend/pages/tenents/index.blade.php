@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div>
        <div
            class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">
            <div class="flex items-center justify-between mb-6">
                <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100">Tenants</div>
                <div class="flex items-center gap-3">
                    <div class="view-toggle" id="tenants-view-toggle">
                        <button type="button" class="view-toggle-btn" data-view="list" title="List view">
                            <img src="/backend/assets/images/icons/icon-ordered-list.svg" alt="list view">
                        </button>
                        <button type="button" class="view-toggle-btn is-active" data-view="grid" title="Grid view">
                            <img src="/backend/assets/images/icons/icon-grid.svg" alt="grid view">
                        </button>
                    </div>
                    <label for="add-tenant-modal"
                        class="cursor-pointer flex items-center gap-2 bg-color-brands text-white text-sm font-semibold rounded-lg px-4 py-2">
                        <img src="/backend/assets/images/icons/icon-add-circle.svg" alt="add icon" class="filter-white">
                        Add Tenant
                    </label>
                </div>
            </div>
            <div id="tenants-list-view" style="display:none;">
            <table class="w-full min-w-[1000px]">
                <tbody>
                    <tr class="border-b border-neutral dark:border-dark-neutral-border pb-[15px]">
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">ID</span>
                            </div>
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Name
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Phone
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Room
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Move In
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Status
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Portal
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border"></th>
                    </tr>
                    @forelse ($tenants as $tenant)
                        <tr
                            class="border-b text-normal text-gray-1100 border-neutral dark:border-dark-neutral-border dark:text-gray-dark-1100">
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    {{ $tenant->id }}
                                </p>
                            </td>
                            <td class="py-[25px]">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full grid place-items-center text-xs font-semibold shrink-0" style="background-color: rgba(115,100,219,.14); color: #7364DB;">
                                        {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                    </div>
                                    <p class="text-normal text-gray-1100 dark:text-gray-dark-1100">{{ $tenant->name }}</p>
                                </div>
                            </td>
                            <td><span>{{ $tenant->phone }}</span></td>
                            <td><span>{{ $tenant->room->number ?? '—' }}</span></td>
                            <td><span>{{ optional($tenant->move_in_date)->format('d M Y') ?? '—' }}</span></td>
                            <td>
                                @if ($tenant->status === 'moved_out')
                                    <span
                                        class="inline-flex items-center rounded-full text-xs font-semibold px-2 py-1"
                                        style="background-color: rgba(128,131,163,.15); color: #8083A3;">Moved
                                        Out</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full text-xs font-semibold px-2 py-1"
                                        style="background-color: rgba(80,209,178,.15); color: #50D1B2;">Active</span>
                                @endif
                            </td>
                            <td>
                                @if ($tenant->hasPortalAccess())
                                    <span
                                        class="inline-flex items-center rounded-full text-xs font-semibold px-2 py-1"
                                        style="background-color: rgba(115,100,219,.14); color: #7364DB;">Enabled</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full text-xs font-semibold px-2 py-1"
                                        style="background-color: rgba(128,131,163,.15); color: #8083A3;">Not Set</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown dropdown-end w-full">
                                    <label class="cursor-pointer dropdown-label flex items-center justify-between p-3"
                                        tabindex="0"><img class="mx-auto cursor-pointer"
                                            src="/backend/assets/images/icons/icon-more.svg" alt="more icon">
                                    </label>
                                    <ul class="dropdown-content" tabindex="0">
                                        <div class="row-menu">
                                            <div class="row-menu-arrow"></div>
                                            <a href="{{ route('tenents.details', $tenant) }}" class="row-menu-item">Details</a>
                                            <label for="edit-tenant-modal-{{ $tenant->id }}" class="row-menu-item">Edit</label>
                                            <div class="row-menu-divider"></div>
                                            <form method="POST" action="{{ route('tenents.destroy', $tenant) }}"
                                                onsubmit="return confirm('Remove {{ $tenant->name }}? This frees up room {{ $tenant->room->number ?? '' }}.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="row-menu-item row-menu-item-danger">Delete</button>
                                            </form>
                                        </div>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-[26px] text-center text-sm text-gray-400 dark:text-gray-dark-400">
                                No tenants yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            <div id="tenants-grid-view" class="tenant-grid">
                @forelse ($tenants as $tenant)
                    <div class="tenant-card">
                        <div class="tenant-card-top">
                            <div class="tenant-card-avatar"
                                style="background-color: rgba(115,100,219,.14); color: #7364DB;">
                                {{ strtoupper(substr($tenant->name, 0, 1)) }}
                            </div>
                            <div class="dropdown dropdown-end">
                                <label class="cursor-pointer dropdown-label tenant-card-more" tabindex="0">
                                    <img src="/backend/assets/images/icons/icon-more.svg" alt="more icon">
                                </label>
                                <ul class="dropdown-content" tabindex="0">
                                    <div class="row-menu">
                                        <div class="row-menu-arrow"></div>
                                        <a href="{{ route('tenents.details', $tenant) }}" class="row-menu-item">Details</a>
                                        <label for="edit-tenant-modal-{{ $tenant->id }}" class="row-menu-item">Edit</label>
                                        <div class="row-menu-divider"></div>
                                        <form method="POST" action="{{ route('tenents.destroy', $tenant) }}"
                                            onsubmit="return confirm('Remove {{ $tenant->name }}? This frees up room {{ $tenant->room->number ?? '' }}.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="row-menu-item row-menu-item-danger">Delete</button>
                                        </form>
                                    </div>
                                </ul>
                            </div>
                        </div>

                        <div class="tenant-card-name">{{ $tenant->name }}</div>
                        <div class="tenant-card-sub">{{ $tenant->phone }}</div>

                        <div class="tenant-card-meta">
                            <div class="tenant-card-meta-item">
                                <span class="tenant-card-meta-label">Room</span>
                                <span class="tenant-card-meta-value">{{ $tenant->room->number ?? '—' }}</span>
                            </div>
                            <div class="tenant-card-meta-item">
                                <span class="tenant-card-meta-label">Move In</span>
                                <span class="tenant-card-meta-value">{{ optional($tenant->move_in_date)->format('d M Y') ?? '—' }}</span>
                            </div>
                        </div>

                        <div class="tenant-card-badges">
                            @if ($tenant->status === 'moved_out')
                                <span class="tenant-card-badge" style="background-color: rgba(128,131,163,.15); color: #8083A3;">Moved Out</span>
                            @else
                                <span class="tenant-card-badge" style="background-color: rgba(80,209,178,.15); color: #50D1B2;">Active</span>
                            @endif

                            @if ($tenant->hasPortalAccess())
                                <span class="tenant-card-badge" style="background-color: rgba(115,100,219,.14); color: #7364DB;">Portal Enabled</span>
                            @else
                                <span class="tenant-card-badge" style="background-color: rgba(128,131,163,.15); color: #8083A3;">Portal Not Set</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="tenant-grid-empty">No tenants yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    @foreach ($tenants as $tenant)
        <input type="checkbox" id="edit-tenant-modal-{{ $tenant->id }}" class="modal-toggle"
            {{ $errors->any() && old('_form') == 'edit-tenant' && old('_tenant_id') == $tenant->id ? 'checked' : '' }}>
        <div class="modal">
            <div class="modal-box relative bg-neutral-bg dark:bg-dark-neutral-bg max-w-[560px]">
                <label for="edit-tenant-modal-{{ $tenant->id }}" class="absolute right-4 top-4 cursor-pointer">
                    <img src="/backend/assets/images/icons/icon-close-modal.svg" alt="close modal">
                </label>
                <h6 class="text-header-6 font-semibold text-gray-1100 dark:text-gray-dark-1100 mb-6">Edit Tenant
                    {{ $tenant->name }}</h6>
                @php
                    $isEditingThis = old('_form') == 'edit-tenant' && old('_tenant_id') == $tenant->id;
                    $roomOptions = $rooms->filter(fn($r) => !$r->tenant || $r->id === $tenant->room_id);
                    $val = fn($field, $default = '') => $isEditingThis ? old($field, $default) : ($tenant->{$field} ?? $default);
                @endphp
                <form method="POST" action="{{ route('tenents.update', $tenant) }}" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit-tenant">
                    <input type="hidden" name="_tenant_id" value="{{ $tenant->id }}">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Full Name</label>
                            <input type="text" name="name" value="{{ $val('name') }}" required
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('name')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Phone</label>
                            <input type="text" name="phone" value="{{ $val('phone') }}" required
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('phone')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Email</label>
                        <input type="email" name="email" value="{{ $val('email') }}"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if ($isEditingThis)
                            @error('email')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Portal Password
                            <span class="text-gray-400 dark:text-gray-dark-400 font-normal">
                                ({{ $tenant->hasPortalAccess() ? 'leave blank to keep current' : 'not set yet' }})
                            </span>
                        </label>
                        <input type="password" name="password" value="" autocomplete="new-password"
                            placeholder="{{ $tenant->hasPortalAccess() ? '********' : 'Set a password to enable portal login' }}"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if ($isEditingThis)
                            @error('password')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                        <p class="text-xs text-gray-400 dark:text-gray-dark-400 mt-1">Requires an email above.
                            Tenant signs in at <span class="font-mono">/tenant/login</span>.</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Room</label>
                        <select name="room_id" required
                            class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @php $currentRoomId = $val('room_id', $tenant->room_id); @endphp
                            @foreach ($roomOptions as $room)
                                <option value="{{ $room->id }}" {{ $currentRoomId == $room->id ? 'selected' : '' }}>
                                    {{ $room->number }} ({{ ucfirst($room->type) }})</option>
                            @endforeach
                        </select>
                        @if ($isEditingThis)
                            @error('room_id')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Move In Date</label>
                            <input type="date" name="move_in_date"
                                value="{{ $isEditingThis ? old('move_in_date', optional($tenant->move_in_date)->format('Y-m-d')) : optional($tenant->move_in_date)->format('Y-m-d') }}"
                                required
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('move_in_date')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Move Out Date</label>
                            <input type="date" name="move_out_date"
                                value="{{ old('move_out_date', optional($tenant->move_out_date)->format('Y-m-d')) }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('move_out_date')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Status</label>
                        @php $currentStatus = $val('status', $tenant->status ?? 'active'); @endphp
                        <select name="status"
                            class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            <option value="active" {{ $currentStatus == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="moved_out" {{ $currentStatus == 'moved_out' ? 'selected' : '' }}>Moved Out
                            </option>
                        </select>
                        @if ($isEditingThis)
                            @error('status')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">ID Card
                                Number</label>
                            <input type="text" name="id_card_number" value="{{ $val('id_card_number') }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('id_card_number')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Occupants</label>
                            <input type="number" min="1" max="20" name="occupants_count"
                                value="{{ $val('occupants_count', 1) }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('occupants_count')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Emergency Contact
                                Name</label>
                            <input type="text" name="emergency_contact_name"
                                value="{{ $val('emergency_contact_name') }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('emergency_contact_name')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Emergency Contact
                                Phone</label>
                            <input type="text" name="emergency_contact_phone"
                                value="{{ $val('emergency_contact_phone') }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @if ($isEditingThis)
                                @error('emergency_contact_phone')
                                    <p class="text-red text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Notes</label>
                        <textarea name="notes" rows="2"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">{{ $val('notes') }}</textarea>
                        @if ($isEditingThis)
                            @error('notes')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <button type="submit"
                        class="bg-color-brands text-white rounded-lg py-3 mt-2 font-semibold">Save Changes</button>
                </form>
            </div>
        </div>
    @endforeach

    <input type="checkbox" id="add-tenant-modal" class="modal-toggle"
        {{ ($errors->any() && old('_form') == 'add-tenant') || request('open') == 'add-tenant' ? 'checked' : '' }}>
    <div class="modal">
        <div class="modal-box relative bg-neutral-bg dark:bg-dark-neutral-bg max-w-[560px]">
            <label for="add-tenant-modal" class="absolute right-4 top-4 cursor-pointer">
                <img src="/backend/assets/images/icons/icon-close-modal.svg" alt="close modal">
            </label>
            <h6 class="text-header-6 font-semibold text-gray-1100 dark:text-gray-dark-1100 mb-6">Add New Tenant</h6>
            <form method="POST" action="{{ route('tenents.store') }}" class="flex flex-col gap-4">
                @csrf
                <input type="hidden" name="_form" value="add-tenant">
                @php $addVal = fn($field, $default = '') => old('_form') == 'add-tenant' ? old($field, $default) : $default; @endphp
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Full Name</label>
                        <input type="text" name="name" value="{{ $addVal('name') }}"
                            required placeholder="e.g. Sok Dara"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('name')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Phone</label>
                        <input type="text" name="phone" value="{{ $addVal('phone') }}"
                            required placeholder="e.g. 012 345 678"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('phone')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Email</label>
                    <input type="email" name="email" value="{{ $addVal('email') }}"
                        placeholder="optional"
                        class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                    @if (old('_form') == 'add-tenant')
                        @error('email')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Portal Password
                        <span class="text-gray-400 dark:text-gray-dark-400 font-normal">(optional)</span>
                    </label>
                    <input type="password" name="password" value="" autocomplete="new-password"
                        placeholder="Set to let this tenant log in"
                        class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                    @if (old('_form') == 'add-tenant')
                        @error('password')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Room</label>
                    <select name="room_id" required
                        class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        <option value="">Select a vacant room</option>
                        @forelse ($vacantRooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('_form') == 'add-tenant' && old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->number }} ({{ ucfirst($room->type) }})</option>
                        @empty
                            <option value="" disabled>No vacant rooms available</option>
                        @endforelse
                    </select>
                    @if (old('_form') == 'add-tenant')
                        @error('room_id')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Move In Date</label>
                        <input type="date" name="move_in_date"
                            value="{{ $addVal('move_in_date', now()->format('Y-m-d')) }}" required
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('move_in_date')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">ID Card Number</label>
                        <input type="text" name="id_card_number" value="{{ $addVal('id_card_number') }}"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('id_card_number')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Occupants</label>
                        <input type="number" min="1" max="20" name="occupants_count"
                            value="{{ $addVal('occupants_count', 1) }}"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('occupants_count')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Emergency Contact
                            Name</label>
                        <input type="text" name="emergency_contact_name" value="{{ $addVal('emergency_contact_name') }}"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('emergency_contact_name')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Emergency Contact
                            Phone</label>
                        <input type="text" name="emergency_contact_phone"
                            value="{{ $addVal('emergency_contact_phone') }}"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if (old('_form') == 'add-tenant')
                            @error('emergency_contact_phone')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Notes</label>
                    <textarea name="notes" rows="2"
                        class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">{{ $addVal('notes') }}</textarea>
                    @if (old('_form') == 'add-tenant')
                        @error('notes')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
                <button type="submit"
                    class="bg-color-brands text-white rounded-lg py-3 mt-2 font-semibold">Save Tenant</button>
            </form>
        </div>
    </div>

    <style>
        /* Plain CSS on purpose: tailwind.min.css here is a static,
           pre-purged build, so the daisyUI-ish .menu/.rounded-box
           utility classes it relied on could inflate unpredictably.
           Custom classes below give this dropdown fixed, compact
           spacing regardless of that. */
        .row-menu {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 126px;
            margin-top: 10px;
            padding: 10px 16px;
            background: var(--neutral-bg, #fff);
            border: 1px solid rgba(128, 131, 163, .2);
            border-radius: 12px;
            box-shadow: 0 40px 120px 0 rgba(0, 0, 0, .122);
        }

        .dark .row-menu {
            background: #1B1B29;
            border-color: rgba(255, 255, 255, .08);
        }

        .row-menu-arrow {
            position: absolute;
            top: -7px;
            right: 18px;
            width: 14px;
            height: 7px;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid var(--neutral-bg, #fff);
        }

        .dark .row-menu-arrow {
            border-bottom-color: #1B1B29;
        }

        .row-menu-item {
            display: block;
            background: transparent;
            border: none;
            padding: 5px 0;
            margin: 0;
            font-size: 11px;
            line-height: 16px;
            color: #8083A3;
            cursor: pointer;
            text-align: left;
            width: 100%;
        }

        .row-menu-item:hover {
            color: #171725;
        }

        .dark .row-menu-item:hover {
            color: #E0E0E0;
        }

        .row-menu-item-danger,
        .row-menu-item-danger:hover {
            color: #E23738;
        }

        .row-menu-divider {
            width: 100%;
            height: 1px;
            background: rgba(128, 131, 163, .2);
            margin: 5px 0;
        }

        .dark .row-menu-divider {
            background: rgba(255, 255, 255, .08);
        }

        /* View toggle (list / grid) */
        .view-toggle {
            display: flex;
            gap: 2px;
            padding: 3px;
            background: rgba(128, 131, 163, .1);
            border-radius: 10px;
        }

        .dark .view-toggle {
            background: rgba(255, 255, 255, .06);
        }

        .view-toggle-btn {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            background: transparent;
            cursor: pointer;
        }

        .view-toggle-btn img {
            width: 16px;
            height: 16px;
            opacity: .5;
        }

        .view-toggle-btn.is-active {
            background: var(--neutral-bg, #fff);
            box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
        }

        .dark .view-toggle-btn.is-active {
            background: #1B1B29;
        }

        .view-toggle-btn.is-active img {
            opacity: 1;
            filter: brightness(0) saturate(100%) invert(44%) sepia(46%) saturate(1526%) hue-rotate(219deg) brightness(94%) contrast(93%);
        }

        /* Tenant grid (card) view */
        .tenant-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
            padding-bottom: 26px;
        }

        .tenant-grid-empty {
            grid-column: 1 / -1;
            text-align: center;
            font-size: 13px;
            color: #8083A3;
            padding: 40px 0;
        }

        .tenant-card {
            border: 1px solid rgba(128, 131, 163, .15);
            border-radius: 16px;
            padding: 18px;
            background: var(--neutral-bg, #fff);
        }

        .dark .tenant-card {
            border-color: rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .02);
        }

        .tenant-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .tenant-card-avatar {
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            display: grid;
            place-items: center;
            font-size: 14px;
            font-weight: 600;
        }

        .tenant-card-more {
            display: grid;
            place-items: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            cursor: pointer;
        }

        .tenant-card-more:hover {
            background: rgba(128, 131, 163, .1);
        }

        .tenant-card-more img {
            width: 16px;
            height: 16px;
        }

        .tenant-card-name {
            font-size: 15px;
            font-weight: 600;
            color: #171725;
            margin-bottom: 2px;
        }

        .dark .tenant-card-name {
            color: #fff;
        }

        .tenant-card-sub {
            font-size: 12px;
            color: #8083A3;
            margin-bottom: 14px;
        }

        .tenant-card-meta {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 0;
            border-top: 1px solid rgba(128, 131, 163, .12);
            border-bottom: 1px solid rgba(128, 131, 163, .12);
            margin-bottom: 14px;
        }

        .dark .tenant-card-meta {
            border-color: rgba(255, 255, 255, .07);
        }

        .tenant-card-meta-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .tenant-card-meta-label {
            font-size: 11px;
            color: #8083A3;
        }

        .tenant-card-meta-value {
            font-size: 13px;
            font-weight: 600;
            color: #171725;
        }

        .dark .tenant-card-meta-value {
            color: #E0E0E0;
        }

        .tenant-card-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tenant-card-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            white-space: nowrap;
        }
    </style>

    <script>
        (function () {
            var STORAGE_KEY = 'tenants-view-preference';
            var toggle = document.getElementById('tenants-view-toggle');
            var listView = document.getElementById('tenants-list-view');
            var gridView = document.getElementById('tenants-grid-view');
            if (!toggle || !listView || !gridView) return;

            function applyView(view) {
                var isGrid = view === 'grid';
                listView.style.display = isGrid ? 'none' : '';
                gridView.style.display = isGrid ? '' : 'none';
                toggle.querySelectorAll('.view-toggle-btn').forEach(function (btn) {
                    btn.classList.toggle('is-active', btn.dataset.view === view);
                });
            }

            toggle.querySelectorAll('.view-toggle-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var view = btn.dataset.view;
                    applyView(view);
                    try { localStorage.setItem(STORAGE_KEY, view); } catch (e) {}
                });
            });

            var saved = null;
            try { saved = localStorage.getItem(STORAGE_KEY); } catch (e) {}
            applyView(saved === 'list' ? 'list' : 'grid');
        })();
    </script>
@endsection
