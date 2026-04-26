<!-- Modal Edit Content -->
<div class="modal fade" id="modalEditContent{{ $content->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.landing-page.contents.update', $content) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header bg-warning">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fas fa-edit mr-1"></i> Edit {{ ucfirst($content->type) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ $content->type == 'faq' ? 'Pertanyaan' : 'Judul / Nama' }}</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="{{ $content->title }}" required>
                    </div>
                </div>
                
                @if($content->type == 'testimonial')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Role / Angkatan</label>
                    <div class="col-sm-9">
                        <input type="text" name="subtitle" class="form-control" value="{{ $content->subtitle }}">
                    </div>
                </div>
                @endif

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{ $content->type == 'faq' ? 'Jawaban' : ($content->type == 'testimonial' ? 'Pesan / Kesan' : 'Keterangan') }}</label>
                    <div class="col-sm-9">
                        <textarea name="content" class="form-control" rows="4" required>{{ $content->content }}</textarea>
                    </div>
                </div>

                @if($content->type != 'faq')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Update {{ $content->type == 'testimonial' ? 'Foto' : 'Ikon' }}</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="imageEdit{{ $content->id }}">
                            <label class="custom-file-label" for="imageEdit{{ $content->id }}">Pilih file baru...</label>
                        </div>
                        @if($content->image)
                            <div class="mt-2 text-sm text-muted italic">Current image: {{ basename($content->image) }}</div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Urutan & Status</label>
                    <div class="col-sm-3">
                        <input type="number" name="order_weight" class="form-control" value="{{ $content->order_weight }}" placeholder="Urutan">
                    </div>
                    <div class="col-sm-5 d-flex align-items-center">
                        <div class="custom-control custom-switch ml-3">
                            <input type="checkbox" name="is_active" class="custom-control-input" id="switch{{ $content->id }}" {{ $content->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-normal" for="switch{{ $content->id }}">Status Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary px-4 shadow-none" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning font-weight-bold px-4 shadow-sm text-dark">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
