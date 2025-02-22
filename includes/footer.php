<footer class="text-center py-3 bg-light">
    <div class="container">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> e-Real Estate. All rights reserved.</p>
    </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<?php if (file_exists('assets/js/scripts.js')): ?>
    <script src="assets/js/scripts.js"></script>
<?php else: ?>
    <script>
        console.error('Custom scripts file not found!');
    </script>
<?php endif; ?>
</body>
</html>