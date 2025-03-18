/*=============== SHOW HIDE PASSWORD LOGIN ===============*/
const passwordAccess = (loginPass, loginEye) => {
    const input = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye);
 
    iconEye.addEventListener('click', () => {
       // Thay đổi input từ password sang text và ngược lại
       input.type = input.type === 'password' ? 'text' : 'password';
 
       // Đổi icon mắt
       iconEye.classList.toggle('ri-eye-fill');
       iconEye.classList.toggle('ri-eye-off-fill');
    });
 }
 
 passwordAccess('password', 'loginPassword');
 