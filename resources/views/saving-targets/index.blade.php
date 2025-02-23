<x-app-layout>
    <div class="container mt-6">
        <!-- Saldo Awal -->
        <div class="col-md-12 mb-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Saldo Saat Ini</h5>
                    <h2 class="fw-bold">Rp {{ number_format($sama, 0, ',', '.') }},00</h2>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Saldo Saat Ini -->
            <div class="col-md-6">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Saldo Saat Ini</h5>
                        <h2 class="fw-bold"><span id="currentBalance">0</span></h2>
                    </div>
                </div>
            </div>

            <!-- Total Dana Teralokasi -->
            <div class="col-md-6">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Dana Teralokasi</h5>
                        <h2 class="fw-bold"><span id="allocatedBalance">0</span></h2>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- Modal Pop-up untuk Alokasi Dana -->
    <div class="modal fade" id="allocationModal" tabindex="-1">
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
                    <div>
                        <strong>${target.name}</strong><br>
                        <small>Target: ${formatCurrency(target.amount)} | Terkumpul: ${formatCurrency(target.saved)} (${progress}%)</small>
                        <div class="progress mt-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: ${progress}%"></div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-warning btn-sm" onclick="openAllocationModal(${index})"><i class="fas fa-coins"></i> Alokasikan</button>
                        <button class="btn btn-danger btn-sm" onclick="removeTarget(${index})"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                `;
                list.appendChild(li);
            });
        }

        window.onload = updateTargetList;
    </script>
</x-app-layout>

