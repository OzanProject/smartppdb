<!-- Modal Add Content -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.landing-page.contents.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">{{ $title }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>{{ $type == 'faq' ? 'Pertanyaan' : 'Judul / Nama' }}</label>
                    <input type="text" name="title" class="form-control" placeholder="Masukkan judul..." required>
                </div>
                
                @isset($subtitleLabel)
                <div class="form-group">
                    <label>{{ $subtitleLabel }}</label>
                    <input type="text" name="subtitle" class="form-control" placeholder="...">
                </div>
                @endisset

                <div class="form-group">
                    <label>{{ $type == 'faq' ? 'Jawaban' : ($type == 'testimonial' ? 'Pesan / Kesan' : 'Keterangan') }}</label>
                    <textarea name="content" class="form-control" rows="4" placeholder="..." required></textarea>
                </div>

                @empty($hideImage)
                <div class="form-group">
                    <label>{{ $imageLabel ?? 'Gambar / Ikon' }}</label>
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="image{{ $id }}">
                        <label class="custom-file-label" for="image{{ $id }}">Pilih file...</label>
                    </div>
                    <small class="text-muted">Rekomendasi ukuran: 1:1 (Persegi). Maks 2MB.</small>
                </div>
                @endempty

                <div class="form-group mb-0">
                    <label>Urutan (Order)</label>
                    <input type="number" name="order_weight" class="form-control" value="0">
                    <small class="text-muted">Angka lebih kecil tampil lebih dulu.</small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm">Simpan Konten</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
