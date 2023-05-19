<?= $this->extend("layout/sidebar") ?>
<?= $this->section('title') ?>
<h1 class="m-0">Tambah Produk</h1>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<script src="<?= base_url("assets/plugins/autoNumeric.js") ?>"></script>
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?= form_open("product/store", ['class' => "store-data"]) ?>
                <?= csrf_field() ?>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="name">Nama Produk</label>
                                <input type="text" class="form-control" placeholder="Nama Produk" name="nama" id="nama">
                                <div class="invalid-feedback errorNamaProduk" style="display: none;"></div>
                            </div>
                            <div class="col-4">
                                <label for="name">Stok</label>
                                <input type="number" class="form-control" placeholder="0" name="stok" id="stok">
                                <div class="invalid-feedback errorStok" style="display: none;"></div>
                            </div>
                            <div class="col-4">
                                <label for="name">Kategori</label>
                                <select class="form-select form-control" name="category_id" id="category_id">
                                </select>
                                <div class="invalid-feedback errorCategory" style="display: none;"></div>
                            </div>
                            <div class="col">
                                <label for="name">Harga beli</label>
                                <input type="text" class="form-control" placeholder="Rp100,000" name="harga_beli" id="harga_beli">
                                <div class="invalid-feedback errorHargaBeli" style="display: none;"></div>
                            </div>
                            <div class="col">
                                <label for="name">Harga jual</label>
                                <input type="text" class="form-control" placeholder="Rp100,000" name="harga_jual" id="harga_jual">
                                <div class="invalid-feedback errorHargaJual" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location='<?= base_url('product') ?>'">Kembali</button>
                    <button type="submit" class="btn btn-primary submit-data">Simpan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>
<script>
    function showCategory() {
        $.ajax({
            url: "<?= base_url('product/getCategory') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#category_id').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    $(document).ready(function() {
        showCategory();

        $("#harga_beli").autoNumeric("init", {
            aSep: ',',
            aDec: '.',
            mDec: '2',
        })
        $("#harga_jual").autoNumeric("init", {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        })
    })

    $('.submit-data').click(function(e) {
        e.preventDefault();
        let form = $('.store-data')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('product/store') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.submit-data').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.submit-data').prop('disabled', true);
            },
            complete: function() {
                $('.submit-data').html('Simpan');
                $('.submit-data').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let msg = response.error;


                    if (msg.errorNamaProduk) {
                        $('.errorNamaProduk').html(msg.errorNamaProduk).show();
                        $('#nama').addClass('is-invalid');
                    } else {
                        $('.errorNamaProduk').fadeOut();
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }

                    if (msg.errorStok) {
                        $('.errorStok').html(msg.errorStok).show();
                        $('#stok').addClass('is-invalid');
                    } else {
                        $('.errorStok').fadeOut();
                        $('#stok').removeClass('is-invalid');
                        $('#stok').addClass('is-valid');
                    }

                    if (msg.errorCategory) {
                        $('.errorCategory').html(msg.errorCategory).show();
                        $('#category_id').addClass('is-invalid');
                    } else {
                        $('.errorCategory').fadeOut();
                        $('#category_id').removeClass('is-invalid');
                        $('#category_id').addClass('is-valid');
                    }


                    if (msg.errorHargaBeli) {
                        $('.errorHargaBeli').html(msg.errorHargaBeli).show();
                        $('#harga_beli').addClass('is-invalid');
                    } else {
                        $('.errorHargaBeli').fadeOut();
                        $('#harga_beli').removeClass('is-invalid');
                        $('#harga_beli').addClass('is-valid');
                    }

                    if (msg.errorHargaJual) {
                        $('.errorHargaJual').html(msg.errorHargaJual).show();
                        $('#harga_jual').addClass('is-invalid');
                    } else {
                        $('.errorHargaJual').fadeOut();
                        $('#harga_jual').removeClass('is-invalid');
                        $('#harga_jual').addClass('is-valid');
                    }

                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        html: response.sukses,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
</script>


<?= $this->endSection() ?>