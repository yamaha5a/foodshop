<?php
session_start();


if (isset($_SESSION['user_id'])) {
   header("http://localhost:81//shopfood/admin/index.php");
   exit();
}
$error_message = ""; // Thêm dòng này để tránh lỗi
if (isset($_SESSION['error_message'])) {
   $error_message = $_SESSION['error_message'];
   unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị để tránh hiển thị lại
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

   <link rel="stylesheet" href="/shopfood/admin/public/css/login.css">

   <title>Login</title>
</head>

<body>
   <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
      <mask id="mask0" mask-type="alpha">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
         0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
         591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
         167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />
      </mask>
      <g mask="url(#mask0)">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
         0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
         591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
         167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />
         <image class="login__img" href="/shopfood/admin/public/img/bg-img.jpg" />
      </g>
   </svg>

   <div class="login container grid">
      <div class="login__access">
         <h1 class="login__title">Đăng nhập tải khoản</h1>

         <div class="login__area">
            <form action="/shopfood/admin/controllers/login.php" method="POST" class="login__form">
               <div class="login__content grid">
                  <div class="login__box">
                     <input type="email" name="email" id="email" required placeholder=" " class="login__input" autocomplete="email">
                     <label for="email" class="login__label">Email</label>
                  </div>
                  <div class="login__box">
                     <input type="password" name="password" id="password" required placeholder=" " class="login__input" autocomplete="current-password">
                     <label for="password" class="login__label">Password</label>
                     <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                  </div>
               </div>
               <button type="submit" class="login__button">Login</button>

               <?php if (!empty($error_message)): ?>
                  <p id="error-message" class="login__error"><?php echo htmlspecialchars($error_message); ?></p>
                  <script>
                     document.addEventListener("DOMContentLoaded", function() {
                        alert("<?php echo htmlspecialchars($error_message); ?>"); // Hiển thị lỗi bằng alert
                     });
                  </script>
               <?php endif; ?>
            </form>


         </div>
      </div>
   </div>

   <script src="/shopfood/admin/public/js/main.js"></script>
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         var errorMessage = document.getElementById("error-message");

         if (errorMessage && errorMessage.textContent.trim() !== "") {
            alert(errorMessage.textContent); // Hiển thị lỗi bằng alert
         }
      });
   </script>


</body>

</html>