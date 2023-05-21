<?= $this->extend("layout/main") ?>

<?= $this->section('sidebar') ?>
<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8g1xgfONND3jpusoYg1XpV8o7gknHPTIMfA&usqp=CAU" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block"><?= user()->username ?></a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

      <li class="nav-item menu-open">
        <a href="<?= base_url("/") ?>" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <?php if (in_groups('admin')) :  ?>
        <li class="nav-item">
          <a href="<?= base_url("category") ?>" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Kategori
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url("product") ?>" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Produk
            </p>
          </a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a href="<?= base_url("sales") ?>" class="nav-link">
          <i class="nav-icon fas fa-table"></i>
          <p>
            Penjualan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url("logout") ?>" class="nav-link">
          <i class="nav-icon fas fa-arrow-right"></i>
          <p>
            Logout
          </p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
<?= $this->endSection() ?>