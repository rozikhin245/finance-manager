<x-app-layout>
    <section class="relative w-full h-screen bg-green-700 text-white flex items-center">
        <div class="container mx-auto px-6 lg:px-16 flex flex-col lg:flex-row items-center">
            <div class="w-full lg:w-1/2">
                <h1 class="text-4xl lg:text-5xl font-bold mb-4">Membantu Memanajeme Keuangan Pibadi</h1>
                <p class="text-lg mb-6">Rumah impian hadir untuk membantu mencari hunian nyaman, untuk ditinggali sendiri dengan sumber terpercaya.</p>
                {{-- <a href="#" class="bg-white text-green-700 font-semibold py-3 px-6 rounded-lg shadow-lg hover:bg-gray-200 transition">Temukan Rumah</a> --}}
            </div>
            <div class="w-full lg:w-1/2 mt-8 lg:mt-0 flex justify-center">
                <img src="img/icon1.png" alt="Rumah Impian" class="rounded-lg  w-full max-w-lg">
            </div>
        </div>
    </section>
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 ">
            <div class="bg-primary text-white p-6 rounded-lg shadow-lg text-center">
                <h5 class="text-lg font-semibold">Saldo Saat Ini</h5>
                <p class="text-2xl font-bold">Rp {{ number_format($balance, 0, ',', '.') }},00</p>
            </div>
            <div class="bg-success text-white p-6 rounded-lg shadow-lg text-center">
                <h5 class="text-lg font-semibold">Total Pemasukan</h5>
                <p class="text-2xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }},00</p>
            </div>
            <div class="bg-danger text-white p-6 rounded-lg shadow-lg text-center">
                <h5 class="text-lg font-semibold">Total Pengeluaran</h5>
                <p class="text-2xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }},00</p>
            </div>
        </div>

        <div class="flex justify-center gap-4 mt-6">
            <button class="btn btn-success add-transaction-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal" data-type="income">
                Tambah Pemasukan
            </button>
            <button class="btn btn-danger add-transaction-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal" data-type="expense">
                Tambah Pengeluaran
            </button>
        </div >
        <div class="mt-10">
            <!-- Tabel Transaksi -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Transaksi</h5>
                    <table class="table table-striped">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td class="text-center">{{ $transaction->date }}</td>
                                    <td class="text-center">{{ $transaction->category }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $transaction->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="text-center">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <!-- Dropdown Button -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-black type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="list" class="w-4 h-4"></i>
                                            </button>                                            
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('transactions.edit', $transaction->id) }}">Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                    <!-- Tombol View All di Tengah -->
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">View All</a>
                    </div>
                </div>
            </div>
            
        </div>
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
                        <div class="mb-3 d-none">
                            <label for="transactionType" class="form-label">Jenis Transaksi</label>
                            <select id="transactionType" name="type" class="form-control" required>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select id="category" name="category" class="form-control" required>
                                <!-- Kategori akan diisi melalui JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3" id="otherCategoryField" style="display: none;">
                            <label for="other_category" class="form-label">Kategori Lainnya</label>
                            <input type="text" id="other_category" name="other_category" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah (Rp)</label>
                            <input type="number" name="amount" class="form-control" required>
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
    
    <!-- Script untuk mengatur form -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var transactionType = document.getElementById("transactionType");
            var categorySelect = document.getElementById("category");
            var otherCategoryField = document.getElementById("otherCategoryField");
            var otherCategoryInput = document.getElementById("other_category");

            const categories = {
                income: ["Gaji","sampingan", "Lainnya"],
                expense: ["Keperluan", "Urgent", "Kebutuhan", "Lainnya"]
            };

            function updateCategoryOptions(type) {
                categorySelect.innerHTML = ""; 
                categories[type].forEach(cat => {
                    let option = document.createElement("option");
                    option.value = cat.toLowerCase() === "lainnya" ? "other" : cat;
                    option.textContent = cat;
                    categorySelect.appendChild(option);
                });
            }

            transactionType.addEventListener("change", function () {
                updateCategoryOptions(this.value);
            });

            categorySelect.addEventListener("change", function () {
                if (this.value === "other") {
                    otherCategoryField.style.display = "block";
                    otherCategoryInput.required = true;
                } else {
                    otherCategoryField.style.display = "none";
                    otherCategoryInput.required = false;
                }
            });

            document.querySelectorAll(".add-transaction-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let type = this.getAttribute("data-type");
                    transactionType.value = type;
                    updateCategoryOptions(type);
                });
            });

            updateCategoryOptions(transactionType.value);
        });
    </script>

    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    {{-- TARGET TAMBUNGAN --}}
    <div class="container mt-6 card p-10">
        <div class="row">
            <!-- Kolom Kiri: Informasi Saldo -->
            <div class="col-md-6">
                <!-- Saldo Awal -->
                <div class="col-md-12 mb-4 mt-4">
                    <div class="card text-white bg-success shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Saldo Saat Ini</h5>
                            <h2 class="fw-bold">Rp {{ number_format($sama, 0, ',', '.') }},00</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="card text-white bg-primary shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Saldo Saat Ini</h5>
                            <h2 class="fw-bold"><span id="currentBalance">0</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="card text-white bg-warning shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Dana Teralokasi</h5>
                            <h2 class="fw-bold"><span id="allocatedBalance">0</span></h2>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Saldo Saat Ini -->


                    <!-- Total Dana Teralokasi -->

                </div>
            </div>

            <!-- Kolom Kanan: Form dan Daftar Target -->
            <div class="col-md-6">
                <!-- Form Tambah Target Tabungan -->
                <div class="card p-4 mt-4 shadow-sm">
                    <h5 class="mb-3">Tambah Target Tabungan</h5>
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" id="targetName" class="form-control" placeholder="Nama Target (misal: Beli Rumah)">
                        </div>
                        <div class="col-md-5">
                            <input type="number" id="targetAmount" class="form-control" placeholder="Total Target (Rp)">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" onclick="addTarget()">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Target Tabungan -->
                <div class="card p-4 mt-4 shadow-sm">
                    <h5>Daftar Target Tabungan</h5>
                    <ul id="targetList" class="list-group list-group-flush"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pop-up untuk Alokasi Dana (tetap di luar grid agar tidak terpengaruh layout) -->
    <div class="modal fade mb-10" id="allocationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alokasikan Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="number" id="allocationAmount" class="form-control" placeholder="Jumlah alokasi (Rp)">
                    <input type="hidden" id="allocationIndex">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="confirmAllocation()">Simpan</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let balance = {{ $balance }};
        let targets = JSON.parse(localStorage.getItem('targets')) || [];
        let allocatedBalance = targets.reduce((sum, t) => sum + t.saved, 0);

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
        }

        function saveToLocalStorage() {
            localStorage.setItem('targets', JSON.stringify(targets));
        }

        function addTarget() {
            let name = document.getElementById('targetName').value.trim();
            let amount = parseFloat(document.getElementById('targetAmount').value);
            if (!name || isNaN(amount) || amount <= 0) {
                alert("Masukkan nama dan jumlah target yang valid!");
                return;
            }
            targets.push({ name, amount, saved: 0 });
            saveToLocalStorage();
            updateTargetList();
        }

        function openAllocationModal(index) {
            document.getElementById('allocationIndex').value = index;
            document.getElementById('allocationAmount').value = '';
            new bootstrap.Modal(document.getElementById('allocationModal')).show();
        }

        function confirmAllocation() {
            let index = document.getElementById('allocationIndex').value;
            let allocation = parseFloat(document.getElementById('allocationAmount').value);
            if (isNaN(allocation) || allocation <= 0 || allocation > (balance - allocatedBalance)) {
                alert("Jumlah alokasi tidak valid atau saldo tidak mencukupi!");
                return;
            }
            if (targets[index].saved + allocation > targets[index].amount) {
                alert("Jumlah alokasi melebihi target!");
                return;
            }
            targets[index].saved += allocation;
            allocatedBalance = targets.reduce((sum, t) => sum + t.saved, 0);
            saveToLocalStorage();
            updateTargetList();
            bootstrap.Modal.getInstance(document.getElementById('allocationModal')).hide();
        }

        function removeTarget(index) {
            allocatedBalance -= targets[index].saved;
            targets.splice(index, 1);
            saveToLocalStorage();
            updateTargetList();
        }

        function updateTargetList() {
        document.getElementById('currentBalance').innerText = formatCurrency(balance - allocatedBalance);
        document.getElementById('allocatedBalance').innerText = formatCurrency(allocatedBalance);
        let list = document.getElementById('targetList');
        list.innerHTML = "";
        targets.forEach((target, index) => {
            let progress = Math.round((target.saved / target.amount) * 100);
            let li = document.createElement('li');
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                <div class="flex-grow-1">
                    <strong>${target.name}</strong><br>
                    <small>Target: ${formatCurrency(target.amount)} | Terkumpul: ${formatCurrency(target.saved)} (${progress}%)</small>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: ${progress}%"></div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" onclick="openAllocationModal(${index})">
                                <i class="fas fa-coins me-2"></i> Alokasikan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" onclick="removeTarget(${index})">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </div>
            `;
            list.appendChild(li);
        });
    }


    window.onload = updateTargetList;
</script>
</x-app-layout>
