<header class="header header-sticky mb-4">
      <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
          onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
          <svg class="icon icon-lg">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
          </svg>
        </button>

        <a class="header-brand d-md-none" href="#">
          <!-- logo -->
          <img style="height:48px" src="assets/favicon/parameter-removebg-preview.png" class="img" alt="Oximeter Logo">
          <!-- logo -->
        </a>
        <ul class="header-nav d-none d-md-flex">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <!-- logo -->
              <img style="height:48px" src="assets/favicon/parameter-removebg-preview.png" class="img" alt="Logo">
              <!-- logo -->
              BME680 Server
            </a>
          </li>

        </ul>
        <ul class="header-nav ms-auto">

        </ul>
        <ul class="header-nav ms-3">
          <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
              aria-haspopup="true" aria-expanded="false">

              <div class="avatar bg-primary text-white">
                <?php echo substr(ucfirst($_SESSION['username']), 0, 1); ?>
              </div>


            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
              <div class="dropdown-header bg-light py-2">
                <div class="fw-semibold">
                  <?php echo ucfirst($_SESSION['username']) ?>'s Account
                </div>

              </div>

              <a class="dropdown-item" href="?logout='1'">
                <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                </svg> Logout</a>
            </div>
          </li>
        </ul>
      </div>
      <div class="header-divider"></div>
      <div class="container-fluid">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
              <!-- if breadcrumb is single--><span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span><?php  echo $pagetitle ?><span></li>
          </ol>
        </nav>
      </div>
    </header>