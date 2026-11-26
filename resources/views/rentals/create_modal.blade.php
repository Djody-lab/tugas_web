<!-- MODAL TAMBAH DATA -->
<div id="rentalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300" id="modalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Tambah Rental Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
        </div>

        <form id="createForm">
            <!-- Pilih Pelanggan -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                <select id="customer_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih PC -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit PC</label>
                <select id="computer_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Pilih PC --</option>
                    @foreach($computers as $computer)
                        <option value="{{ $computer->id }}">{{ $computer->pc_number }} ({{ $computer->specification }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Waktu Mulai -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                <input type="datetime-local" id="start_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
