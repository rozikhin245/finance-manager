<x-app-layout>
    <div class="container">
        <h2>Tambah Transaksi</h2>
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Jenis Transaksi</label>
                <select name="type" class="form-control">
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="category" class="form-control">
                    <option value="Food">Food</option>
                    <option value="Kebutuhan">Kebutuhan</option>
                    <option value="urgent">urgent</option>
                    <option value="healing">healing</option>
                </select>
                {{-- <input type="text" name="category" class="form-control"> --}}
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="amount" class="form-control">
            </div>
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="date" class="form-control">
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</x-app-layout>


