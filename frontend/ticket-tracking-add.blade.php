@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Tambah Data Tracking Tiket</h1>

    <form id="addTrackingForm" method="POST" action="{{ route('ticket-tracking.add') }}">
        @csrf
        <div class="mb-4">
            <label for="nomor_tiket" class="block text-sm font-medium text-gray-700">Nomor Tiket</label>
            <input type="text" name="nomor_tiket" id="nomor_tiket" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan nomor tiket">
        </div>

        <div class="mb-4">
            <label for="tipe_tiket" class="block text-sm font-medium text-gray-700">Tipe Tiket</label>
            <select name="tipe_tiket" id="tipe_tiket" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Pilih tipe tiket</option>
                <option value="instalasi">Instalasi</option>
                <option value="maintenance">Maintenance</option>
                <option value="keluhan">Keluhan</option>
                <option value="terminasi">Terminasi</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <input type="text" name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan status tiket">
        </div>

        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan keterangan (opsional)"></textarea>
        </div>

        <div class="mb-4">
            <label for="dilakukan_oleh" class="block text-sm font-medium text-gray-700">Dilakukan Oleh</label>
            <input type="text" name="dilakukan_oleh" id="dilakukan_oleh" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nama pelaku (opsional)">
        </div>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Tambah Tracking</button>
    </form>
</div>
@endsection
