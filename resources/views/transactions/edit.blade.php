<x-app-layout>
<div class="container">
    <h2>Edit Transaksi</h2>
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Jenis Transaksi</label>
            <select name="type" class="form-control">
                <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control" value="{{ $transaction->category }}">
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="amount" class="form-control" value="{{ $transaction->amount }}">
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ $transaction->date }}">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ $transaction->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</x-app-layout>

