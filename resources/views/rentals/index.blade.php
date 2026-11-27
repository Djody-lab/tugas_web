@extends('layouts.app')

@section('content')
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Transaksi Rental</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau riwayat penyewaan PC warnet secara real-time.</p>
        </div>
        <!-- Tombol Pemicu Modal -->
        <button onclick="openModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition shadow-sm flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Rental Baru
        </button>
    </div>

    <!-- Card Tabel -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Unit PC</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Waktu Mulai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Total Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($rentals as $index => $rental)
                        <tr id="row-{{ $rental->id }}" class="hover:bg-indigo-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($rental->customer->name ?? 'X', 0, 2) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->customer->name ?? 'Tidak diketahui' }}</div>
                                        <div class="text-xs text-gray-500">{{ $rental->customer->phone_number ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-desktop mr-1"></i> {{ $rental->computer->pc_number ?? 'Tidak diketahui' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="far fa-clock text-gray-400 mr-1"></i>
                                {{ \Carbon\Carbon::parse($rental->start_time)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                Rp {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($rental->end_time)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Sedang Bermain</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="deleteRental({{ $rental->id }})" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-full transition" title="Hapus Data">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium text-gray-900">Belum ada data transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Panggil file Modal di sini -->
    @include('rentals.create_modal')

@endsection
<!-- Script Khusus Halaman Ini -->
@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const modal = document.getElementById('rentalModal');

    // Fungsi untuk mendapatkan token dari API Login
    async function getApiToken() {
        // Cek apakah token sudah ada di memori browser
        let token = localStorage.getItem('warnet_token');
        if (token) return token;

        // Jika belum ada, login otomatis di belakang layar
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: 'admin@warnet.com',
                password: 'password123'
            })
        });

        const data = await response.json();
        if (response.ok) {
            localStorage.setItem('warnet_token', data.token);
            return data.token;
        } else {
            Swal.fire('Error', 'Gagal login otomatis ke API', 'error');
            return null;
        }
    }

    // Fungsi Buka/Tutup Modal (Sama seperti sebelumnya)
    function openModal() {
        modal.classList.remove('hidden');
        document.getElementById('modalContent').classList.remove('scale-95');
        document.getElementById('modalContent').classList.add('scale-100');
    }

    function closeModal() {
        document.getElementById('modalContent').classList.add('scale-95');
        document.getElementById('modalContent').classList.remove('scale-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('createForm').reset();
        }, 200);
    }

    // Handle Form Submit (POST) dengan Token
    document.getElementById('createForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const token = await getApiToken(); // Ambil token dulu

        const data = {
            customer_id: document.getElementById('customer_id').value,
            computer_id: document.getElementById('computer_id').value,
            start_time: document.getElementById('start_time').value,
        };

        fetch('/api/rentals', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`, // <-- Tambahkan Header Token
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json().then(resData => ({status: response.status, body: resData})))
        .then(res => {
            if (res.status === 201) {
                closeModal();
                Swal.fire('Berhasil!', 'Data rental berhasil ditambahkan.', 'success').then(() => window.location.reload());
            } else {
                Swal.fire('Gagal!', res.body.message || 'Terjadi kesalahan validasi.', 'error');
            }
        })
        .catch(error => Swal.fire('Error!', 'Tidak dapat terhubung ke server.', 'error'));
    });

    // Handle Delete (DELETE) dengan Token
    async function deleteRental(id) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data transaksi ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const token = await getApiToken(); // Ambil token dulu

                fetch(`/api/rentals/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`, // <-- Tambahkan Header Token
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    if (response.ok) {
                        document.getElementById(`row-${id}`).remove();
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
