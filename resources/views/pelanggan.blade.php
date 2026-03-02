<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased min-h-screen">

    <div class="max-w-5xl mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center border-b border-gray-300 pb-4 mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Data Pelanggan</h1>
        </div>
        <div class="flex mb-4">
            <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm font-medium"
                    onclick="openModal('modal-tambah')">
                + Tambah Pelanggan
            </button>
        </div>
        <!-- Alert -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('error') }}
        </div>
        @endif

        <!-- Tabel -->
        <div class="bg-white border border-gray-300 rounded shadow-sm overflow-hidden">
            @if(count($data) > 0)
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">HP</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($data as $index => $pelanggan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium">{{ $pelanggan->nama }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $pelanggan->email }}</td>
                        <td class="px-4 py-3">{{ $pelanggan->hp }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-800 text-xs font-medium border border-blue-300 px-2 py-1 rounded"
                                        onclick="openDetail('{{ addslashes($pelanggan->nama) }}', '{{ $pelanggan->email }}', '{{ $pelanggan->hp }}')">
                                    Detail
                                </button>
                                <button class="text-green-600 hover:text-green-800 text-xs font-medium border border-green-300 px-2 py-1 rounded"
                                        onclick="openEdit({{ $pelanggan->id }}, '{{ addslashes($pelanggan->nama) }}', '{{ $pelanggan->email }}', '{{ $pelanggan->hp }}')">
                                    Edit
                                </button>
                                <button class="text-red-600 hover:text-red-800 text-xs font-medium border border-red-300 px-2 py-1 rounded"
                                        onclick="openDelete({{ $pelanggan->id }}, '{{ addslashes($pelanggan->nama) }}')">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="py-12 text-center text-gray-500">
                <p class="mb-4">Belum ada data pelanggan.</p>
                <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm font-medium"
                        onclick="openModal('modal-tambah')">
                    + Tambah Pelanggan
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- ========== MODAL TAMBAH ========== -->
    <div class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-50" id="modal-tambah" onclick="if(event.target===this) closeModal('modal-tambah')">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-1">Tambah Pelanggan</h2>
            <p class="text-sm text-gray-600 mb-4">Isi data pelanggan baru.</p>
            <form method="POST" action="{{ route('pelanggan.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="number" name="hp" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 text-sm border border-gray-300 rounded hover:bg-gray-100" onclick="closeModal('modal-tambah')">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-gray-700 text-white rounded hover:bg-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========== MODAL EDIT ========== -->
    <div class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-50" id="modal-edit" onclick="if(event.target===this) closeModal('modal-edit')">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-1">Edit Pelanggan</h2>
            <p class="text-sm text-gray-600 mb-4">Perbarui data pelanggan.</p>
            <form method="POST" id="form-edit" action="">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit-nama" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit-email" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="number" name="hp" id="edit-hp" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 text-sm border border-gray-300 rounded hover:bg-gray-100" onclick="closeModal('modal-edit')">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-gray-700 text-white rounded hover:bg-gray-800">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========== MODAL DETAIL ========== -->
    <div class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-50" id="modal-detail" onclick="if(event.target===this) closeModal('modal-detail')">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-1">Detail Pelanggan</h2>
            <p class="text-sm text-gray-600 mb-4">Informasi lengkap pelanggan.</p>
            <div class="space-y-3 text-sm">
                <p><span class="font-medium text-gray-700 w-20 inline-block">Nama:</span> <span id="detail-nama"></span></p>
                <p><span class="font-medium text-gray-700 w-20 inline-block">Email:</span> <span id="detail-email"></span></p>
                <p><span class="font-medium text-gray-700 w-20 inline-block">No. HP:</span> <span id="detail-hp"></span></p>
            </div>
            <div class="flex justify-end mt-6">
                <button type="button" class="px-4 py-2 text-sm border border-gray-300 rounded hover:bg-gray-100" onclick="closeModal('modal-detail')">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ========== MODAL DELETE ========== -->
    <div class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-50" id="modal-delete" onclick="if(event.target===this) closeModal('modal-delete')">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-1">Hapus Pelanggan</h2>
            <p class="text-sm text-gray-600 mb-4">Anda akan menghapus <strong id="delete-nama"></strong>. Tindakan ini tidak dapat dibatalkan.</p>
            <form method="POST" id="form-delete" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 text-sm border border-gray-300 rounded hover:bg-gray-100" onclick="closeModal('modal-delete')">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        function openEdit(id, nama, email, hp) {
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-hp').value = hp;
            document.getElementById('form-edit').action = `/pelanggan/${id}`;
            openModal('modal-edit');
        }


        function openDelete(id, nama) {
            document.getElementById('delete-nama').textContent = nama;
            document.getElementById('form-delete').action = `/pelanggan/${id}`;
            openModal('modal-delete');
        }

        function openDetail(nama, email, hp) {
            document.getElementById('detail-nama').textContent = nama;
            document.getElementById('detail-email').textContent = email;
            document.getElementById('detail-hp').textContent = hp;
            openModal('modal-detail');
        }
    </script>

</body>
</html>