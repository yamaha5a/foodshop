<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success text-center">
        <?= $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>