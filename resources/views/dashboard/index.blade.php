<x-app-layout>
    <div class="container mx-auto p-6">
        <x-slot name="header">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
                {{ __('Dashboard Keuangan') }}
            </h2>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg text-center">
                <h5 class="text-lg font-semibold">Saldo Saat Ini</h5>
                <p class="text-2xl font-bold">Rp {{ number_format($balance, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg text-center">
                <h5 class="text-lg font-semibold">Total Pemasukan</h5>
                <p class="text-2xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg text-center">
                <h5 class="text-lg font-semibold">Total Pengeluaran</h5>
                <p class="text-2xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="flex justify-center gap-4 mt-6">
            <!-- Tombol untuk Tambah Pemasukan -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTransactionModal" data-type="income">
                Tambah Pemasukan
            </button>
            <!-- Tombol untuk Tambah Pengeluaran -->
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addTransactionModal" data-type="expense">
                Tambah Pengeluaran
            </button>
        </div>

        <div class="bg-white p-6 mt-6 shadow-lg rounded-lg">
            <h5 class="text-lg font-semibold mb-4">Grafik Pemasukan & Pengeluaran</h5>
            <canvas id="financeChart"></canvas>
        </div>

        <!-- Modal Tambah Transaksi -->
        <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('transactions.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="transactionType" class="form-label">Jenis Transaksi</label>
                                <select id="transactionType" name="type" class="form-control" required>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" class="form-control" required>
                                    <option value="Food">Food</option>
                                    <option value="Kebutuhan">Kebutuhan</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="healing">Healing</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah (Rp)</label>
                                <input type="number" name="amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var addTransactionModal = document.getElementById("addTransactionModal");
            addTransactionModal.addEventListener("show.bs.modal", function (event) {
                var button = event.relatedTarget; // Tombol yang diklik
                var type = button.getAttribute("data-type"); // Ambil tipe transaksi
                
                var transactionTypeSelect = document.getElementById("transactionType");
                transactionTypeSelect.innerHTML = ""; // Kosongkan opsi sebelumnya
                
                if (type === "income") {
                    transactionTypeSelect.innerHTML = '<option value="income" selected>Pemasukan</option>';
                } else if (type === "expense") {
                    transactionTypeSelect.innerHTML = '<option value="expense" selected>Pengeluaran</option>';
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('financeChart').getContext('2d');
            var chartData = {
                labels: @json($monthlyData->pluck('month')),
                datasets: [
                    {
                        label: 'Pemasukan',
                        backgroundColor: 'rgba(0, 255, 0, 0.5)',
                        borderColor: 'green',
                        data: @json($monthlyData->where('type', 'income')->pluck('total'))
                    },
                    {
                        label: 'Pengeluaran',
                        backgroundColor: 'rgba(255, 0, 0, 0.5)',
                        borderColor: 'red',
                        data: @json($monthlyData->where('type', 'expense')->pluck('total'))
                    }
                ]
            };
            new Chart(ctx, {
                type: 'bar',
                data: chartData
            });
        });
    </script>
</x-app-layout>
