<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Creative Panda</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/scrollbar/jquery.mCustomScrollbar.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/angular-loading/loading-bar.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <script>
    var base = '<?php echo $base ?>';
    var api  = '<?php echo $api  ?>';
    var tmp  = '<?php echo $tmp  ?>';
  </script>
  <script type="text/javascript" src="<?php echo $this->base ?>/assets/plugins/jquery/jquery.min.js"></script>
  <base href="<?php echo $this->base ?>/">
</head>
<body ng-app="ednc" class="flux-layout">

  <!-- SIDE NAV -->
  <aside class="flux-sidenav" id="fluxSidenav">

    <div class="flux-brand">
      <a href="#/dashboard" class="flux-logo-link">
        <div class="flux-logo-wrap">
          <img src="<?php echo $this->base ?>/assets/img/mcp.jpg" alt="MCP Logo" class="flux-logo-img">
        </div>
        <div class="flux-brand-text">
          <span class="flux-brand-name">My Creative</span>
          <span class="flux-brand-sub">Panda Inc.</span>
        </div>
      </a>
    </div>

    <div class="flux-user-card">
      <div class="flux-user-avatar">
        <?php
          $image = '/assets/img/user-male.jpg';
          echo $this->Thumbnail->render($image, array('path' => '',
            'width' => '52', 'height' => '52',
            'resize' => 'crop', 'quality' => '100'
          ), array('class' => 'flux-avatar-img', 'alt' => ''));
        ?>
      </div>
      <div class="flux-user-meta">
        <div class="flux-user-name"><?php echo $currentUser['User']['first_name'] . ' ' . $currentUser['User']['last_name'] ?></div>
        <div class="flux-user-role"><?php echo $currentUser['Role']['name'] ?></div>
      </div>
    </div>

    <nav class="flux-nav">
      <div class="flux-nav-section-label">Main Menu</div>
      <ul class="flux-nav-list">
        <li class="flux-nav-item">
          <a href="#/cruds" class="flux-nav-link" data-route="cruds">
            <span class="flux-nav-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </span>
            <span class="flux-nav-label">Cruds</span>
            <span class="flux-nav-arrow">&#8250;</span>
          </a>
        </li>
        <li class="flux-nav-item">
          <a href="#/users" class="flux-nav-link" data-route="users">
            <span class="flux-nav-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </span>
            <span class="flux-nav-label">Users</span>
            <span class="flux-nav-arrow">&#8250;</span>
          </a>
        </li>
      </ul>
    </nav>

    <div class="flux-signout">
      <a href="<?php echo Router::url(array('controller'=>'main', 'action'=>'logout')) ?>" class="flux-signout-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        <span>Sign Out</span>
      </a>
    </div>
  </aside>

  <button class="flux-mobile-toggle" id="fluxToggle" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>
  <div class="flux-overlay" id="fluxOverlay"></div>

  <main class="flux-main" id="fluxMain">
    <div class="flux-topbar">
      <div class="flux-topbar-left">
        <div class="flux-page-title" id="fluxPageTitle">Dashboard</div>
      </div>
      <div class="flux-topbar-right">
        <div class="flux-topbar-time" id="fluxTime"></div>
      </div>
    </div>
    <div class="flux-content">
      <div ng-view></div>
    </div>
  </main>

  <?php echo $this->element('angularjs') ?>
  <?php echo $this->element('scripts') ?>
  <?php echo $this->fetch('extrajs') ?>

  <script>
    function setActiveNav() {
      var hash = window.location.hash.replace('#/', '');
      document.querySelectorAll('.flux-nav-link').forEach(function(link) {
        link.classList.remove('active');
        var route = link.getAttribute('data-route');
        if (hash.indexOf(route) === 0) {
          link.classList.add('active');
          document.getElementById('fluxPageTitle').textContent =
            link.querySelector('.flux-nav-label').textContent;
        }
      });
    }

    setActiveNav();

    function updateClock() {
      var now = new Date();
      var h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
      var ampm = h >= 12 ? 'PM' : 'AM';
      h = h % 12 || 12;
      document.getElementById('fluxTime').textContent =
        (h < 10 ? '0'+h : h) + ':' +
        (m < 10 ? '0'+m : m) + ':' +
        (s < 10 ? '0'+s : s) + ' ' + ampm;
    }
    setInterval(updateClock, 1000);
    updateClock();

    var toggle  = document.getElementById('fluxToggle');
    var sidenav = document.getElementById('fluxSidenav');
    var overlay = document.getElementById('fluxOverlay');
    toggle.addEventListener('click', function() {
      sidenav.classList.toggle('open');
      overlay.classList.toggle('show');
      toggle.classList.toggle('active');
    });
    overlay.addEventListener('click', function() {
      sidenav.classList.remove('open');
      overlay.classList.remove('show');
      toggle.classList.remove('active');
    });
  </script>
</body>
</html>
