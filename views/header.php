<?php

  require_once("../general.php");

  function returnHeader() {
    global $apex_index_uri;

    if ( isset($_SESSION["LOGIN_STATUS"])) {
      $view = <<<EOD
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand navbar__title" href="/$apex_index_uri">&lt; PHP Blog /&gt;</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar__menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse navbar__menu" id="navbar__menu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 navbar__menu__list">
              <li class="nav-item navbar__menu__list__item">
                <a class="nav-link active" href="/$apex_index_uri">Home</a>
              </li>
              <li class="nav-item dropdown navbar__menu__list__item">
                <a class="nav-link dropdown-toggle" href="#" id="NavbarBlogsMenuDropdown" role="button" data-bs-toggle="dropdown">
                  Blogs
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="/$apex_index_uri/controllers/blogs">View Blogs</a></li>
                  <li><a class="dropdown-item" href="/$apex_index_uri/controllers/add-blog">Add Blog</a></li>
                </ul>
              </li>
              <li class="nav-item navbar__menu__list__item">
                <a class="nav-link" href="/$apex_index_uri/controllers/users">Users</a>
              </li>
              <li class="nav-item dropdown navbar__menu__list__item">
                <a class="nav-link dropdown-toggle" href="#" id="NavbarSettingsMenuDropdown" role="button" data-bs-toggle="dropdown">
                  Settings
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="/$apex_index_uri/controllers/update-profile">Update Profile</a></li>
                  <li><a class="dropdown-item" href="/$apex_index_uri/controllers/update-password">Update Password</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/$apex_index_uri/controllers/logout">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
EOD;
    }
    else {
      $view = <<<EOD
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand navbar__title" href="/$apex_index_uri">&lt; PHP Blog /&gt;</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar__menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse navbar__menu" id="navbar__menu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 navbar__menu__list">
              <li class="nav-item navbar__menu__list__item">
                <a class="nav-link active" href="/$apex_index_uri">Home</a>
              </li>
              <li class="nav-item navbar__menu__list__item">
                <a class="nav-link" href="/$apex_index_uri/controllers/login">Login</a>
              </li>
              <li class="nav-item navbar__menu__list__item">
                <a class="nav-link" href="/$apex_index_uri/controllers/register">Register</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
EOD;
    }
    return $view;
  }

?>