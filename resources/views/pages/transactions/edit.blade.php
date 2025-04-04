  <div class="alert alert-primary" role="alert">
      <strong>Edit Transaksi</strong>
      <p>Pada halaman edit Transaksi, kamu dapat mengubah informasi data transaksi yang sudah tersimpan di sistem.
      </p>
  </div>

  <form wire:submit="update">
      @csrf

      <div class="row gap-1">
          <!-- Card Form Transaksi Utama -->
          <div class="col-md-6">
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <!-- Judul Transaksi -->
                          <div class="col-12">
                              <div class="mb-3">
                                  <label for="title" class="form-label">Judul Transaksi</label>
                                  <input type="text" class="form-control @error("title") is-invalid @enderror"
                                      wire:model="title" id="title" aria-describedby="titleId"
                                      placeholder="Enter transaction title" autofocus autocomplete="title" />
                                  @error("title")
                                      <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                          <!-- Tanggal Transaksi -->
                          <div class="col-12">
                              <div class="mb-3">
                                  <label for="date" class="form-label">Tanggal Transaksi</label>
                                  <input type="date" class="form-control @error("date") is-invalid @enderror"
                                      wire:model="date" id="date" aria-describedby="dateId"
                                      placeholder="Enter transaction date" autofocus autocomplete="date" />
                                  @error("date")
                                      <small id="dateId" class="form-text text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                          <!-- Kategori -->
                          <div class="col-12">
                              <div class="mb-3">
                                  <label for="category_id" class="form-label">Kategori</label>
                                  <select class="form-select @error("category_id") is-invalid @enderror"
                                      wire:model="category_id" id="category_id">
                                      <option selected>Pilih Satu</option>
                                      @foreach ($categories as $category)
                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                      @endforeach
                                  </select>
                                  @error("category_id")
                                      <small class="form-text text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                          <!-- Jenis Transaksi -->
                          <div class="col-12">
                              <div class="mb-3">
                                  <label for="type" class="form-label">Jenis Transaksi</label>
                                  <select class="form-select @error("type") is-invalid @enderror" wire:model="type"
                                      id="type">
                                      <option selected>Pilih Satu</option>
                                      <option value="DEBIT">Debit</option>
                                      <option value="CREDIT">Kredit</option>
                                  </select>
                                  @error("type")
                                      <small class="form-text text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                          <!-- Tombol Update -->
                          <div class="row mb-3">
                              <div class="col-md">
                                  <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                              <div class="col-md align-self-center text-end">
                                  <span wire:loading class="spinner-border spinner-border-sm"></span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Card Detail Item -->
          <div class="col-md">
              <div class="card">
                  <div class="card-body ">
                      @foreach ($items as $index => $item)
                          <div class="row mb-3">
                              <!-- Field keterangan -->
                              <div class="col-md-12">
                                  <div class="mb-3">
                                      <label for="description_{{ $index }}" class="form-label">keterangan</label>
                                      <textarea class="form-control @error("items." . $index . ".description") is-invalid @enderror"
                                          wire:model="items.{{ $index }}.description" id="description_{{ $index }}"
                                          placeholder="Masukkan keterangan..."></textarea>
                                      @error("items." . $index . ".description")
                                          <small class="form-text text-danger">{{ $message }}</small>
                                      @enderror
                                  </div>
                              </div>
                              <!-- Field Jumlah -->
                              <div class="col-md-10">
                                  <div class="mb-3">
                                      <label for="amount_{{ $index }}" class="form-label">Jumlah</label>
                                      <input type="number"
                                          class="form-control @error("items." . $index . ".amount") is-invalid @enderror"
                                          wire:model="items.{{ $index }}.amount"
                                          id="amount_{{ $index }}" placeholder="0" />
                                      @error("items." . $index . ".amount")
                                          <small class="form-text text-danger">{{ $message }}</small>
                                      @enderror
                                  </div>
                              </div>
                              <!-- Tombol Hapus Item -->
                              <div class="col-md-2">
                                  <div class="mb-3">
                                      <label class="form-label text-white">X</label>
                                      <button type="button" wire:click="removeItem({{ $index }})"
                                          class="btn btn-danger">
                                          X
                                      </button>
                                  </div>
                              </div>
                          </div>
                          <hr>
                      @endforeach
                      <!-- Tombol Tambah Detail -->
                      <div class="row mb-3">
                          <div class="col-auto">
                              <button type="button" wire:click="addItem" class="btn btn-primary">
                                  Tambah Detail
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </form>
