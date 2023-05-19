<?= $this->extend("layout/sidebar") ?>
<?= $this->section('title') ?>
<h1 class="m-0">Kategori Produk</h1>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn btn-sm btn-primary add-data"><i class="fa fa-plus">Tambah Data</i></button>
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
                                <th scope="col">Nama Kategori</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($categories as $category) :

                            ?>
                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= $category['name'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="editCategory('<?= $category['id'] ?>')">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCategory('<?= $category['id'] ?>', '<?= $category['name'] ?>')">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    <div class="viewmodal" style="display: none;"></div>

</section>
<script>
    function editCategory(id) {

        $.ajax({
            url: "<?= base_url('category/edit') ?>",
            dataType: "json",
            // type: 'post',
            data: {
                act: 1,
                id: id
            },
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#editCategory').on('shown.bs.modal', function(event) {
                        $('#name').focus();
                    });
                    $('#editCategory').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function deleteCategory(id, nama) {
        Swal.fire({
            title: 'Hapus Kategori',
            html: `Yakin hapus nama kategori <strong>${nama}</strong> ini ?`,
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
                    url: "<?= base_url('category/destroy') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        $('.add-data').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url('category/add') ?>",
                dataType: "json",
                // type: 'post',
                data: {
                    act: 0
                },
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#addCategory').on('shown.bs.modal', function(event) {
                            $('#name').focus();
                        });
                        $('#addCategory').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    })
</script>
<?= $this->endSection() ?>