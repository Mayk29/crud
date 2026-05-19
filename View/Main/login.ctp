<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign In &mdash; My Creative Panda</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/login.css">
  <script type="text/javascript" src="<?php echo $this->base ?>/assets/plugins/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->base ?>/assets/js/svg-icon.js"></script>
</head>
<body class="flux-login-body">

  <div class="flux-login-bg">
    <div class="flux-login-bg-circle flux-circle-1"></div>
    <div class="flux-login-bg-circle flux-circle-2"></div>
    <div class="flux-login-bg-circle flux-circle-3"></div>
  </div>

  <div class="flux-login-wrap">

    <!-- Left panel -->
    <div class="flux-login-panel flux-login-left">
      <div class="flux-login-brand">
        <div class="flux-login-logo-ring">
          <img src="<?php echo $this->base ?>/assets/img/mcp.jpg" alt="MCP Logo" class="flux-login-logo">
        </div>
        <h1 class="flux-login-title">My Creative<br>Panda Inc.</h1>
        <p class="flux-login-tagline">Since 2006 &mdash; Creative Solutions</p>
      </div>
    </div>

    <!-- Right panel / form -->
    <div class="flux-login-panel flux-login-right">
      <div class="flux-login-form-wrap">
        <div class="flux-login-form-header">
          <h2>Welcome back</h2>
          <p>Sign in to your account to continue</p>
        </div>

        <?php echo $this->Form->create('User', array(
          'url'           => array('controller' => 'main', 'action' => 'login'),
          'class'         => 'flux-login-form',
          'id'            => 'loginForm',
          'inputDefaults' => array('label' => false, 'div' => false)
        )) ?>

          <div class="flux-field-group">
            <label class="flux-field-label">Username</label>
            <div class="flux-input-wrap">
              <span class="flux-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                  <circle cx="12" cy="7" r="4"/>
                </svg>
              </span>
              <?php echo $this->Form->input('username', array(
                'required'    => true,
                'placeholder' => 'Enter your username',
                'autofocus'   => true,
                'class'       => 'flux-input'
              )) ?>
            </div>
          </div>

          <div class="flux-field-group">
            <label class="flux-field-label">Password</label>
            <div class="flux-input-wrap">
              <span class="flux-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </span>
              <?php echo $this->Form->input('password', array(
                'required'    => true,
                'placeholder' => 'Enter your password',
                'class'       => 'flux-input'
              )) ?>
            </div>
          </div>

          <button type="submit" class="flux-login-btn">
            Sign In
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </button>

        </form>

        <div class="flux-login-footer">
          &copy; <?php echo date('Y') ?> My Creative Panda Inc. &mdash; All rights reserved.
        </div>
      </div>
    </div>

  </div>
</body>
</html>
