<?= $this->extend("layout/sidebar") ?>
<?= $this->section('title') ?>
<h1 class="m-0">Data Penjualan</h1>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class=" col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>

                        <p>Input Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <a href="<?= base_url("sales/add") ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class=" col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>150</h3>

                        <p>Data Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <a href="<?= base_url("sales/data") ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <section class="col-lg connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sales
                        </h3>

                    </div><!-- /.card-header -->
                    <?= form_open("product/store", ['class' => "store-data"]) ?>
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="no_faktur">Faktur</label>
                                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="no_faktur" id="no_faktur" readonly value="<?= $no_faktur ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="date">Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="date" id="date" readonly value="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="tanggal">Aksi</label>
                                    <div class="input-group">
                                        <button class="btn btn-danger btn-sm" type="button" id="btnHapusTransaksi">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>&nbsp;
                                        <button class="btn btn-success submit-data" type="submit">
                                            <i class="fa fa-save"></i>
                                        </button>&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="product_id">Pilih Produk</label>
                                <select class="form-select form-control form-control-sm" name="product_id" id="product_id">
                                </select>
                                <div class="invalid-feedback errorNamaProduk" style="display: none;"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jml">Jumlah</label>
                                    <input type="number" class="form-control form-control-sm" name="qty" id="qty" value="1">
                                    <div class="invalid-feedback errorStok" style="display: none;"></div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jml">Total Bayar</label>
                                    <input type="text" class="form-control form-control-lg" name="total_price" id="total_price" style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 salesDetail">

                            </div>
                        </div>
                    </div><!-- /.card-body -->
                    <?= form_close() ?>

                </div>
                <!-- /.card -->
            </section>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<div class="viewmodal" style="display: none;"></div>

<script>
    function salesDetail() {
        $.ajax({
            type: "post",
            url: "<?= base_url('sales/data') ?>",
            data: {
                no_faktur: $("#no_faktur").val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.salesDetail').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.salesDetail').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function showProduct() {
        $.ajax({
            url: "<?= base_url('sales/getProduct') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#product_id').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        salesDetail()
        showProduct()
    })

    $('.submit-data').click(function(e) {
        e.preventDefault();
        let form = $('.store-data')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('sales/store') ?>",
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