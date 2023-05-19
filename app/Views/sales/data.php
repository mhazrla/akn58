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
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped res">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
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
                                            <td><?= $data['qty'] ?></td>
                                            <td class="text-right">Rp <?= number_format($data['total_price'], 0, ",", ".") ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" onclick="window.location='product/edit/<?= $data['product_id'] ?>'">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteProduct('<?= $product['product_id'] ?>', '<?= $data['nama'] ?>')">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
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
<?= $this->endSection() ?>