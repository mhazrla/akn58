<?= $this->extend("layout/sidebar") ?>
<?= $this->section('title') ?>
<h1 class="m-0">Produk</h1>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn btn-sm btn-primary add-data" onclick="window.location='<?= base_url('product/add') ?>'"><i class="fa fa-plus">Tambah Data</i></button>
                </h3>

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
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped res">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Harga Beli</th>
                                <th scope="col">Harga Jual</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($products as $product) :
                            ?>

                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= $product['nama'] ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['stok'] ?></td>
                                    <td>Rp <?= $product['harga_beli'] ?></td>
                                    <td>Rp <?= $product['harga_jual'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="window.location='product/edit/<?= $product['product_id'] ?>'">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteProduct('<?= $product['product_id'] ?>', '<?= $product['nama'] ?>')">
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

<script>
    function deleteProduct(id, nama) {
        Swal.fire({
            title: 'Hapus Produk',
            html: `Yakin hapus produk <strong>${nama}</strong> ini ?`,
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
                    url: "<?= base_url('product/destroy') ?>",
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
</script>

<?= $this->endSection() ?>