@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div>
        <div
            class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">
            <div class="flex items-center justify-between mb-6">
                <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100">Rooms</div>
                <div class="flex items-center gap-3">
                    <label for="manage-floors-modal"
                        class="cursor-pointer flex items-center gap-2 border border-neutral dark:border-dark-neutral-border text-gray-1100 dark:text-gray-dark-1100 text-sm font-semibold rounded-lg px-4 py-2">
                        <img src="/backend/assets/images/icons/icon-home-2.svg" alt="floors icon">
                        Manage Floors
                    </label>
                    <label for="add-room-modal"
                        class="cursor-pointer flex items-center gap-2 bg-color-brands text-white text-sm font-semibold rounded-lg px-4 py-2">
                        <img src="/backend/assets/images/icons/icon-add-circle.svg" alt="add icon"
                            class="filter-white">
                        Add Room
                    </label>
                </div>
            </div>
            <table class="w-full min-w-[900px]">
                <tbody>
                    <tr>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">ID</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Number</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Floor</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Type</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Price</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500 whitespace-nowrap">Meters
                                    (W / E)</span></div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Status</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border"></th>
                    </tr>
                    @forelse ($rooms as $room)
                        <tr>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    {{ $room->id }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <div class="flex flex-col gap-y-1 max-w-[250px]">
                                    <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                        {{ $room->number }}</p>
                                    @if ($room->tenant)
                                        <p class="text-desc text-gray-400 dark:text-gray-dark-400">
                                            Rented by: {{ $room->tenant->name }}</p>
                                    @endif
                                    @if ($room->description)
                                        <p class="text-desc text-gray-400 dark:text-gray-dark-400 truncate max-w-[220px]"
                                            title="{{ $room->description }}">{{ $room->description }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500">
                                    {{ $room->floor->name ?? '—' }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p
                                    class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100 uppercase">
                                    {{ $room->type }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    ${{ number_format($room->rent_price, 2) }}
                                </p>
                                @if ($room->deposit_amount)
                                    <p class="text-desc text-gray-400 dark:text-gray-dark-400">
                                        Deposit: ${{ number_format($room->deposit_amount, 2) }}</p>
                                @endif
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-desc text-gray-500 dark:text-gray-dark-500">
                                    {{ $room->water_meter_no ?? '—' }} / {{ $room->electric_meter_no ?? '—' }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <div class="flex items-center gap-x-2">
                                    @if ($room->status == 'available')
                                        <div class="w-2 h-2 bg-green rounded-full"></div>
                                        <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500 capitalize">active
                                        </p>
                                    @elseif($room->status == 'rented')
                                        <div class="w-2 h-2 bg-red rounded-full"></div>
                                        <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500 capitalize">rented
                                        </p>
                                    @elseif($room->status == 'booked')
                                        <div class="w-2 h-2 bg-yellow rounded-full"></div>
                                        <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500 capitalize">booked
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <div class="dropdown dropdown-end w-full">
                                    <label class="cursor-pointer dropdown-label flex items-center justify-between p-3"
                                        tabindex="0"><img class="mx-auto cursor-pointer"
                                            src="/backend/assets/images/icons/icon-3-dots.svg" alt="3 dots icon">
                                    </label>
                                    <ul class="dropdown-content" tabindex="0">
                                        <div
                                            class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                            <div
                                                class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                            </div>
                                            <li class="text-normal mb-[7px]">
                                                <label for="edit-room-modal-{{ $room->id }}"
                                                    class="flex items-center bg-transparent p-0 gap-[7px] cursor-pointer">
                                                    <span
                                                        class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Edit</span>
                                                </label>
                                            </li>
                                            <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                            </div>
                                            <li class="text-normal mb-[7px]">
                                                <form method="POST" action="{{ route('rooms.destroy', $room) }}"
                                                    onsubmit="return confirm('Delete room {{ $room->number }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center bg-transparent p-0 gap-[7px]">
                                                        <span class="text-red text-[11px] leading-4">Delete</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    @foreach ($rooms as $room)
        <input type="checkbox" id="edit-room-modal-{{ $room->id }}" class="modal-toggle"
            {{ $errors->any() && old('_form') == 'edit-room' && old('_room_id') == $room->id ? 'checked' : '' }}>
        <div class="modal">
            <div class="modal-box relative bg-neutral-bg dark:bg-dark-neutral-bg">
                <label for="edit-room-modal-{{ $room->id }}" class="absolute right-4 top-4 cursor-pointer">
                    <img src="/backend/assets/images/icons/icon-close-modal.svg" alt="close modal">
                </label>
                <h6 class="text-header-6 font-semibold text-gray-1100 dark:text-gray-dark-1100 mb-6">Edit Room
                    {{ $room->number }}</h6>
                @php
                    $isEditingThis = old('_form') == 'edit-room' && old('_room_id') == $room->id;
                @endphp
                <form method="POST" action="{{ route('rooms.update', $room) }}" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit-room">
                    <input type="hidden" name="_room_id" value="{{ $room->id }}">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Room Number</label>
                        <input type="text" name="number"
                            value="{{ $isEditingThis ? old('number') : $room->number }}" required
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @if ($isEditingThis)
                            @error('number')
                                <p class="text-red text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Type</label>
                        <select name="type" required
                            class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @php $currentType = $isEditingThis ? old('type') : $room->type; @endphp
                            <option value="standard" {{ $currentType == 'standard' ? 'selected' : '' }}>Standard
                            </option>
                            <option value="vip" {{ $currentType == 'vip' ? 'selected' : '' }}>VIP</option>
                            <option value="deluxe" {{ $currentType == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Floor</label>
                        <select name="floor_id"
                            class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @php $currentFloorId = $isEditingThis ? old('floor_id') : $room->floor_id; @endphp
                            <option value="">Select floor</option>
                            @foreach ($floors as $floor)
                                <option value="{{ $floor->id }}" {{ $currentFloorId == $floor->id ? 'selected' : '' }}>
                                    {{ $floor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Monthly Rent
                                ($)</label>
                            <input type="number" step="0.01" min="0" name="rent_price"
                                value="{{ $isEditingThis ? old('rent_price') : $room->rent_price }}" required
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Deposit
                                ($)</label>
                            <input type="number" step="0.01" min="0" name="deposit_amount"
                                value="{{ $isEditingThis ? old('deposit_amount') : $room->deposit_amount }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Water Meter
                                No.</label>
                            <input type="text" name="water_meter_no"
                                value="{{ $isEditingThis ? old('water_meter_no') : $room->water_meter_no }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Electric Meter
                                No.</label>
                            <input type="text" name="electric_meter_no"
                                value="{{ $isEditingThis ? old('electric_meter_no') : $room->electric_meter_no }}"
                                class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Description</label>
                        <textarea name="description" rows="2"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">{{ $isEditingThis ? old('description') : $room->description }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Status</label>
                        <select name="status"
                            class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                            @php $currentStatus = $isEditingThis ? old('status') : $room->status; @endphp
                            <option value="available" {{ $currentStatus == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="booked" {{ $currentStatus == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="rented" {{ $currentStatus == 'rented' ? 'selected' : '' }}>Rented</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="bg-color-brands text-white rounded-lg py-3 mt-2 font-semibold">Save Changes</button>
                </form>
            </div>
        </div>
    @endforeach

    <input type="checkbox" id="add-room-modal" class="modal-toggle"
        {{ ($errors->any() && old('_form') == 'add-room') || request('open') == 'add-room' ? 'checked' : '' }}>
    <div class="modal">
        <div class="modal-box relative bg-neutral-bg dark:bg-dark-neutral-bg">
            <label for="add-room-modal" class="absolute right-4 top-4 cursor-pointer">
                <img src="/backend/assets/images/icons/icon-close-modal.svg" alt="close modal">
            </label>
            <h6 class="text-header-6 font-semibold text-gray-1100 dark:text-gray-dark-1100 mb-6">Add New Room</h6>
            <form method="POST" action="{{ route('rooms.store') }}" class="flex flex-col gap-4">
                @csrf
                <input type="hidden" name="_form" value="add-room">
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Room Number</label>
                    <input type="text" name="number" value="{{ old('number') }}" required placeholder="e.g. A101"
                        class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                    @error('number')
                        <p class="text-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Type</label>
                    <select name="type" required
                        class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        <option value="">Select type</option>
                        <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="vip" {{ old('type') == 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="deluxe" {{ old('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                    </select>
                    @error('type')
                        <p class="text-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Monthly Rent
                            ($)</label>
                        <input type="number" step="0.01" min="0" name="rent_price" value="{{ old('rent_price') }}"
                            required placeholder="150.00"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @error('rent_price')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Deposit ($)</label>
                        <input type="number" step="0.01" min="0" name="deposit_amount"
                            value="{{ old('deposit_amount') }}" placeholder="Optional"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @error('deposit_amount')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Floor</label>
                    <select name="floor_id"
                        class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        <option value="">Select floor</option>
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}" {{ old('floor_id') == $floor->id ? 'selected' : '' }}>
                                {{ $floor->name }}</option>
                        @endforeach
                    </select>
                    @error('floor_id')
                        <p class="text-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Water Meter
                            No.</label>
                        <input type="text" name="water_meter_no" value="{{ old('water_meter_no') }}"
                            placeholder="Optional"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @error('water_meter_no')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Electric Meter
                            No.</label>
                        <input type="text" name="electric_meter_no" value="{{ old('electric_meter_no') }}"
                            placeholder="Optional"
                            class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        @error('electric_meter_no')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Description</label>
                    <textarea name="description" rows="2" placeholder="Optional notes about this room"
                        class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">Status</label>
                    <select name="status"
                        class="select2-input w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>
                            Available</option>
                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-color-brands text-white rounded-lg py-3 mt-2 font-semibold">Save Room</button>
            </form>
        </div>
    </div>

    <input type="checkbox" id="manage-floors-modal" class="modal-toggle">
    <div class="modal">
        <div class="modal-box relative bg-neutral-bg dark:bg-dark-neutral-bg">
            <label for="manage-floors-modal" class="absolute right-4 top-4 cursor-pointer">
                <img src="/backend/assets/images/icons/icon-close-modal.svg" alt="close modal">
            </label>
            <h6 class="text-header-6 font-semibold text-gray-1100 dark:text-gray-dark-1100 mb-6">Manage Floors</h6>

            <div class="flex flex-col gap-2 mb-6">
                @forelse ($floors as $floor)
                    <div
                        class="flex items-center justify-between border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-1100 dark:text-gray-dark-1100">{{ $floor->name }}
                            </p>
                            <p class="text-desc text-gray-400 dark:text-gray-dark-400">{{ $floor->rooms_count }}
                                room{{ $floor->rooms_count == 1 ? '' : 's' }}</p>
                        </div>
                        <form method="POST" action="{{ route('floors.destroy', $floor) }}"
                            onsubmit="return confirm('Remove {{ $floor->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" {{ $floor->rooms_count > 0 ? 'disabled' : '' }}
                                class="{{ $floor->rooms_count > 0 ? 'opacity-30 cursor-not-allowed' : 'hover:opacity-70' }}">
                                <img src="/backend/assets/images/icons/icon-trash.svg" alt="delete floor">
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-dark-500">No floors yet.</p>
                @endforelse
            </div>

            <div class="w-full bg-neutral h-[1px] mb-6 dark:bg-dark-neutral-border"></div>

            <form method="POST" action="{{ route('floors.store') }}" class="flex flex-col gap-3">
                @csrf
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-dark-500 mb-1 block">New Floor Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. 4th Floor"
                        class="w-full border border-neutral dark:border-dark-neutral-border rounded-lg px-4 py-2 bg-transparent text-gray-1100 dark:text-gray-dark-1100 focus:outline-none">
                    @error('name')
                        <p class="text-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-color-brands text-white rounded-lg py-3 font-semibold">Add Floor</button>
            </form>
        </div>
    </div>
@endsection
