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
        <form action="index.php?page=register" method="POST" id="registerForm" enctype="multipart/form-data">
            <input type="text" name="ten" id="ten" placeholder="Họ và tên" required />
            <div id="tenError" class="error-message"></div>

            <input type="email" name="email" id="email" placeholder="Email" required />
            <div id="emailError" class="error-message"></div>

            <input type="password" name="matkhau" id="matkhau" placeholder="Mật khẩu" required />
            <div id="matkhauError" class="error-message"></div>

            <input type="text" name="sodienthoai" id="sodienthoai" placeholder="Số điện thoại" />
            <div id="sodienthoaiError" class="error-message"></div>

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

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: -10px;
        margin-bottom: 10px;
    }
</style>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Reset error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    let isValid = true;
    
    // Validate name
    const ten = document.getElementById('ten').value;
    const tenRegex = /^[a-zA-Z\sÀ-ỹ]+$/;
    if (!tenRegex.test(ten)) {
        document.getElementById('tenError').textContent = 'Tên không được chứa số hoặc ký tự đặc biệt';
        isValid = false;
    }
    
    // Validate email
    const email = document.getElementById('email').value;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Email phải có định dạng @gmail.com';
        isValid = false;
    }
    
    // Validate password
    const matkhau = document.getElementById('matkhau').value;
    if (matkhau.length < 6) {
        document.getElementById('matkhauError').textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
        isValid = false;
    }
    
    // Validate phone number
    const sodienthoai = document.getElementById('sodienthoai').value;
    const phoneRegex = /^0\d{9}$/;
    if (sodienthoai && !phoneRegex.test(sodienthoai)) {
        document.getElementById('sodienthoaiError').textContent = 'Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số';
        isValid = false;
    }
    
    if (isValid) {
        this.submit();
    }
});
</script> 