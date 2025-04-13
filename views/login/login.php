<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Đăng nhập</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Login</li>
    </ol>
</div>

<div class="container-auth">
    <div class="form-box">
        <h2>Đăng nhập</h2>
        <form action="index.php?page=login" method="POST">
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="matkhau" placeholder="Mật khẩu" required />
            <button type="submit">Đăng nhập</button>
        </form>
        <p class="text-center mt-3">
            Chưa có tài khoản? <a href="index.php?page=register">Đăng ký ngay</a>
        </p>
    </div>
</div>

<style>
    .container-auth {
        margin: 80px auto;
        display: flex;
        flex-wrap: wrap;
        max-width: 900px;
        width: 100%;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .form-box {
        flex: 1 1 100%;
        padding: 30px;
    }

    .form-box h2 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #333;
        text-align: center;
    }

    .form-box input {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-box button {
        width: 100%;
        padding: 10px;
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .form-box button:hover {
        background: #218838;
    }

    .form-box a {
        color: #28a745;
        text-decoration: none;
    }

    .form-box a:hover {
        text-decoration: underline;
    }
</style>
