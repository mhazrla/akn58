<?= $this->extend("layout/sidebar") ?>
<?= $this->section('title') ?>
<h1 class="m-0">Data Penjualan</h1>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">

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
                                    <input type="number" class="form-control form-control-sm" name="qty" id="qty" value="1" min="1">
                                    <div class="invalid-feedback errorStok" style="display: none;"></div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 salesDetail">

                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>

                </div>
                <!-- /.card -->
            </section>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped res">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">No. Faktur</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($sales as $data) :
                            ?>

                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= $data['sales_date'] ?></td>
                                    <td><?= $data['faktur_sale'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['qty'] ?></td>
                                    <td class="text-right">Rp <?= number_format($data['total_price'], 0, ",", ".") ?></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('<?= $data['id'] ?>', '<?= $data['nama'] ?>')">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="viewmodal" style="display: none;"></div>

<script>
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

    function deleteItem(id, nama) {
        Swal.fire({
            title: 'Hapus Item',
            html: `Yakin hapus item <strong>${nama}</strong> dari tabel penjualan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('sales/destroy') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil menghapus produk',
                            text: response.sukses
                        }).then((result) => {

                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        })
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }


    $(document).ready(function() {
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