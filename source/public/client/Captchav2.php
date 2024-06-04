<?php
// Tạo một chuỗi ngẫu nhiên cho Captcha
$captchaText = generateRandomString(3);

// Lưu chuỗi Captcha vào session để kiểm tra sau này
session_start();
$_SESSION['captchav2'] = $captchaText;

// Tạo hình ảnh Captcha
$imageWidth = 100;
$imageHeight = 40;

$image = imagecreatetruecolor($imageWidth, $imageHeight);
// Thiết lập chế độ trong suốt cho hình ảnh
imagealphablending($image, false);
imagesavealpha($image, true);

// Tạo màu trong suốt cho nền
$transparentColor = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $transparentColor);


// Màu chữ đỏ
$textColor = imagecolorallocate($image, 255, 0, 0);
$textColors = array(
    imagecolorallocate($image, 255, 255, 0),  // Màu vàng
);
// Kích thước font chữ và độ nghiêng
$fontSize = 20;
$angle = 30;

// Vẽ các ký tự Captcha
$x = 10;
$y = $imageHeight / 10 + $fontSize / 2;

for ($i = 0; $i < strlen($captchaText); $i++) {
    $currentColor = $textColors[$i % count($textColors)];
    imagestring($image, $fontSize, $x, $y, $captchaText[$i], $currentColor);
    $x += $fontSize + rand(1, 1); // Khoảng cách giữa các ký tự
    $fontSize += rand(10, 10); // Tăng kích thước font chữ cho mỗi ký tự
}

// Làm mờ hình ảnh Captcha để khó đọc
imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);

// Đặt các header cho hình ảnh
header('Content-Type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Expires: 0');

// Xuất hình ảnh Captcha
imagepng($image);
imagedestroy($image);

// Hàm tạo chuỗi ngẫu nhiên
function generateRandomString($length = 6) {
    $characters = '012345678abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
