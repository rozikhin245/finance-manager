<x-app-layout>
    <style>
        .koko {
            align-items: center; 
            justify-content: center;
            width: 100%
        }
    </style>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Keuangan Anda') }}
            </h2>
        </x-slot>    
        
        <!-- Form Filter -->
        <div class="bg-white p-6 rounded-lg shadow-md koko">
            <h3 class="text-lg font-semibold mb-4">Filter Transaksi</h3>
            <form action="{{ route('transactions.index') }}" method="GET" class="koko">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-9">
                    <select name="filter_type" id="filter_type" class="form-select p-2 border rounded-md">
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                    <input type="date" name="date" id="filter_daily" class="form-input p-2 border rounded-md">
                    <input type="month" name="month" id="filter_monthly" class="form-input p-2 border rounded-md hidden">
                    <input type="number" name="year" id="filter_yearly" class="form-input p-2 border rounded-md hidden" min="2000" max="2099" value="{{ date('Y') }}">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tampilkan</button>
                </div>
            </form>
        </div>
    
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const filterType = document.getElementById('filter_type');
                const daily = document.getElementById('filter_daily');
                const monthly = document.getElementById('filter_monthly');
                const yearly = document.getElementById('filter_yearly');
    
                function updateFilterVisibility() {
                    daily.style.display = filterType.value === 'daily' ? 'block' : 'none';
                    monthly.style.display = filterType.value === 'monthly' ? 'block' : 'none';
                    yearly.style.display = filterType.value === 'yearly' ? 'block' : 'none';
                }
    
                filterType.addEventListener('change', updateFilterVisibility);
                updateFilterVisibility();
            });
        </script>
    
        <!-- Tabel Transaksi -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transaksi</h5>
                <table class="table table-striped">
                    <thead class="bg-gray-200">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->category }}</td>
                                <td>
                                    <span class="badge {{ $transaction->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <div class="container">
        <h2>Daftar Transaksi</h2>

    
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <table class="table">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ $transaction->category }}</td>
                        <td>Rp{{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ $transaction->date }}</td>
                        <td>
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
