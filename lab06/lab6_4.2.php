<?php
// Hàm lấy dữ liệu từ form POST
function postIndex($index, $value = "")
{
  // Nếu biến $_POST[$index] chưa tồn tại thì trả về giá trị mặc định $value
  if (!isset($_POST[$index])) return $value;
  // Nếu có thì trả về dữ liệu sau khi loại bỏ khoảng trắng thừa
  return trim($_POST[$index]);
}

// Hàm kiểm tra tính hợp lệ của username
function checkUserName($string)
{
  // Biểu thức chính quy cho phép: chữ cái a-z, A-Z, số 0-9, ký tự ., _ và -
  if (preg_match("/^[a-zA-Z0-9._-]*$/", $string))
    return true; // Nếu khớp thì hợp lệ
  return false;   // Nếu không khớp thì không hợp lệ
}

// Hàm kiểm tra định dạng email
function checkEmail($string)
{
  // Biểu thức chính quy kiểm tra email: phần trước @, tên miền, và phần mở rộng
  if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $string))
    return true;  // Email hợp lệ
  return false;  // Email không hợp lệ
}

// Hàm kiểm tra tính hợp lệ của mật khẩu (tối thiểu 8 ký tự, có ít nhất một số, một chữ hoa và một chữ thường)
function checkPassword($password)
{
  if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $password))
    return true;
  return false;
}

// Hàm kiểm tra số điện thoại (chỉ chứa số)
function checkPhone($phone)
{
  if (preg_match("/^\d+$/", $phone))
    return true;
  return false;
}

// Hàm kiểm tra ngày sinh (dd/mm/yyyy hoặc dd-mm-yyyy)
function checkDateOfBirth($date)
{
  if (preg_match("/^(0[1-9]|[12][0-9]|3[01])[-\/](0[1-9]|1[0-2])[-\/](19|20)\d\d$/", $date))
    return true;
  return false;
}

// Lấy dữ liệu từ form
$sm = postIndex("submit");     // Nút submit
$username = postIndex("username"); // Username nhập vào
$password = postIndex("password"); // Mật khẩu nhập vào
$email = postIndex("email");       // Email nhập vào
$date = postIndex("date");         // Ngày sinh nhập vào
$phone = postIndex("phone");       // Số điện thoại nhập vào
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" ...>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Lab6_4.2</title>
  <style>
    /* Định dạng khung form */
    fieldset {
      width: 50%;
      margin: 100px auto;
    }

    .info {
      width: 600px;
      color: #006;
      background: #6FC;
      margin: 0 auto;
    }

    #frm1 input {
      width: 300px;
    }
  </style>
</head>

<body>
  <fieldset>
    <legend style="margin:0 auto">Đăng ký thông tin </legend>
    <!-- Form gửi dữ liệu bằng phương thức POST -->
    <form action="lab06_3.php" method="post" enctype="multipart/form-data" id='frm1'>
      <table align="center">
        <tr>
          <td width="88">UserName</td>
          <td width="317"><input type="text" name="username" value="<?php echo $username; ?>" />*</td>
        </tr>
        <tr>
          <td>Mật khẩu</td>
          <td><input type="text" name="password" value="<?php echo $password; ?>" />*</td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />*</td>
        </tr>
        <tr>
          <td>Ngày sinh</td>
          <td><input type="text" name="date" value="<?php echo $date; ?>" />*</td>
        </tr>
        <tr>
          <td>Điện thoại</td>
          <td><input type="text" name="phone" value="<?php echo $phone; ?>" /></td>
        </tr>

        <tr>
          <td colspan="2" align="center">
            <input type="submit" value="submit" name="submit">
          </td>
        </tr>
      </table>
    </form>
  </fieldset>

  <?php
  // Nếu nút submit được nhấn
  if ($sm != "") {
  ?>
    <div class="info">Lỗi<br />
      <?php
      // Kiểm tra username hợp lệ
      if (checkUserName($username) == false)
        echo "Username: Các ký tự được phép: a-z, A-Z, số 0-9, ký tự ., _ và - <br>";

      // Kiểm tra mật khẩu hợp lệ
      if (checkPassword($password) == false)
        echo "Mật khẩu: Cần ít nhất 8 ký tự, có ít nhất một chữ hoa, một chữ thường và một chữ số <br>";

      // Kiểm tra email hợp lệ
      if (checkEmail($email) == false)
        echo "Định dạng email sai!<br>";

      // Kiểm tra ngày sinh hợp lệ
      if (checkDateOfBirth($date) == false)
        echo "Ngày sinh: Phải có định dạng dd/mm/yyyy hoặc dd-mm-yyyy <br>";

      // Kiểm tra số điện thoại hợp lệ
      if (checkPhone($phone) == false)
        echo "Số điện thoại: Chỉ được phép nhập số <br>";
      ?>
    </div>
  <?php
  }
  ?>
</body>

</html>
