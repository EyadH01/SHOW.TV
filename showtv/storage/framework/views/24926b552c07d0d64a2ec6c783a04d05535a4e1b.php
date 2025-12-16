ج

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: rotate 10s linear infinite;"></div>
                    <i class="fas fa-sign-in-alt fa-3x mb-3" style="position: relative; z-index: 1;"></i>
                    <h2 class="mb-0" style="position: relative; z-index: 1; font-weight: 700;"><?php echo e(__('Login')); ?></h2>
                    <p class="mb-0 mt-2" style="opacity: 0.9; position: relative; z-index: 1;"><?php echo e(__('messages.welcome_back')); ?></p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="<?php echo e(route('login')); ?>" class="user-form">
                        <?php echo csrf_field(); ?>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i><?php echo e(__('Email Address')); ?>

                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: rgba(102, 126, 234, 0.1); border-color: rgba(102, 126, 234, 0.3);">
                                    <i class="fas fa-at"></i>
                                </span>
                                <input id="email" type="email"
                                       class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       name="email"
                                       value="<?php echo e(old('email')); ?>"
                                       required
                                       autocomplete="email"
                                       autofocus
                                       placeholder="<?php echo e(__('messages.enter_email')); ?>"
                                       style="border-left: none; background: rgba(255, 255, 255, 0.05);">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-flex align-items-center mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong><?php echo e($message); ?></strong>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold mb-2">
                                <i class="fas fa-lock me-2 text-primary"></i><?php echo e(__('Password')); ?>

                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: rgba(102, 126, 234, 0.1); border-color: rgba(102, 126, 234, 0.3);">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input id="password" type="password"
                                       class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="<?php echo e(__('messages.enter_password')); ?>"
                                       style="border-left: none; background: rgba(255, 255, 255, 0.05);">
                                <button class="btn btn-outline-secondary" type="button" id="toggle-password" style="border-color: rgba(102, 126, 234, 0.3);">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-flex align-items-center mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong><?php echo e($message); ?></strong>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input me-3" type="checkbox" name="remember" id="remember"
                                       <?php echo e(old('remember') ? 'checked' : ''); ?>

                                       style="width: 20px; height: 20px; border-color: rgba(102, 126, 234, 0.5);">
                                <label class="form-check-label fw-medium" for="remember" style="cursor: pointer; user-select: none;">
                                    <i class="fas fa-check-circle me-2 text-primary"></i>
                                    <?php echo e(__('Remember Me')); ?>

                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3" style="position: relative; overflow: hidden;">
                                <span style="position: relative; z-index: 1;">
                                    <i class="fas fa-sign-in-alt me-2"></i><?php echo e(__('Login')); ?>

                                </span>
                                <div style="position: absolute; top: 50%; left: 50%; width: 0; height: 0; border-radius: 50%; background: rgba(255, 255, 255, 0.3); transition: all 0.5s ease; transform: translate(-50%, -50%);"></div>
                            </button>
                        </div>

                        <!-- Additional Links -->
                        <div class="text-center">
                            <?php if(Route::has('password.request')): ?>
                                <a class="text-decoration-none d-block mb-3" href="<?php echo e(route('password.request')); ?>" style="color: #4facfe; font-weight: 500;">
                                    <i class="fas fa-key me-1"></i><?php echo e(__('Forgot Your Password?')); ?>

                                </a>
                            <?php endif; ?>
                            <p class="mb-0" style="color: var(--text-muted);">
                                <?php echo e(__("messages.dont_have_account")); ?>

                                <a href="<?php echo e(route('register')); ?>" class="text-decoration-none fw-bold" style="color: #667eea;">
                                    <?php echo e(__("messages.register_here")); ?>

                                </a>
                            </p>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>

<style>
    .user-form .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        border-color: #4facfe !important;
    }

    .user-form .btn:hover::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        animation: ripple 0.6s linear;
    }

    @keyframes  ripple {
        to {
            width: 0;
            height: 0;
            opacity: 0;
        }
    }

    @keyframes  rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .card-header::before {
        animation: rotate 10s linear infinite;
    }

    /* Password toggle animation */
    #toggle-password {
        transition: all 0.3s ease;
    }

    #toggle-password:hover {
        background: rgba(102, 126, 234, 0.1) !important;
        border-color: #4facfe !important;
    }

    /* Enhanced form styling */
    .input-group-text {
        transition: all 0.3s ease;
    }

    .form-control:hover + .input-group-text,
    .form-control:focus + .input-group-text {
        border-color: #4facfe !important;
        color: #4facfe !important;
    }

    /* Loading state */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    // Form submission animation
    const form = document.querySelector('.user-form');
    const submitBtn = form.querySelector('button[type="submit"]');

    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><?php echo e(__("messages.logging_in")); ?>';
        });
    }

    // Auto-focus email if no value
    const emailInput = document.getElementById('email');
    if (emailInput && !emailInput.value) {
        emailInput.focus();
    }

    // Enter key navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && document.activeElement === passwordInput) {
            form.dispatchEvent(new Event('submit'));
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/auth/login.blade.php ENDPATH**/ ?>