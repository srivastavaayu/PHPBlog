<?php
echo <<<EOD
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand navbar__title" href="/$index_uri[1]">PHP Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar__menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbar__menu" id="navbar__menu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 navbar__menu__list">
EOD;
?>
<?php
  if (isset($_COOKIE["LOGIN_STATUS"])) {
    echo <<<EOD
    <li class="nav-item navbar__menu__list__item">
      <a class="nav-link active" href="/$index_uri[1]">Home</a>
    </li>
    <li class="nav-item dropdown navbar__menu__list__item">
      <a class="nav-link dropdown-toggle" href="#" id="NavbarBlogsMenuDropdown" role="button" data-bs-toggle="dropdown">
        Blogs
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="/$index_uri[1]/blogs">View Blogs</a></li>
        <li><a class="dropdown-item" href="/$index_uri[1]/add-blog">Add Blog</a></li>
      </ul>
    </li>
    <li class="nav-item navbar__menu__list__item">
      <a class="nav-link" href="/$index_uri[1]/users">Users</a>
    </li>
    <li class="nav-item dropdown navbar__menu__list__item">
      <a class="nav-link dropdown-toggle" href="#" id="NavbarSettingsMenuDropdown" role="button" data-bs-toggle="dropdown">
        Settings
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="/$index_uri[1]/profile">Profile</a></li>
        <li><a class="dropdown-item" href="/$index_uri[1]/change-password">Update Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="/$index_uri[1]/logout">Logout</a></li>
      </ul>
    </li>
EOD;
  }
  else {
    echo <<<EOD
    <li class="nav-item navbar__menu__list__item">
      <a class="nav-link active" href="/$index_uri[1]">Home</a>
    </li>
    <li class="nav-item navbar__menu__list__item">
      <a class="nav-link" href="/$index_uri[1]/authentication">Login</a>
    </li>
    <li class="nav-item navbar__menu__list__item">
      <a class="nav-link" href="/$index_uri[1]/authentication">Register</a>
    </li>
EOD;
  }
?>
<?php
  echo <<<EOD
      </ul>
    </div>
  </div>
</nav>
EOD;
?>