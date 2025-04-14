<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Đăng ký</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Register</li>
    </ol>
</div>

<div class="container-auth">
    <div class="form-box">
        <h2>Đăng ký</h2>
        <form action="index.php?page=register" method="POST"  enctype="multipart/form-data">
            <input type="text" name="ten" placeholder="Họ và tên" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="matkhau" placeholder="Mật khẩu" required />
            <input type="text" name="sodienthoai" placeholder="Số điện thoại" />
            <input type="text" name="diachi" placeholder="Địa chỉ" />
            <select name="gioitinh">
                <option value="">-- Giới tính --</option>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
            <button type="submit">Đăng ký</button>
        </form>
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

    .form-box input,
    .form-box select {
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
</style> 