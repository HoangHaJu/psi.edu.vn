<!DOCTYPE html>
<html lang="vi">

				<head>
								<meta charset="UTF-8">
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<title>Khôi phục mật khẩu</title>
								<style>
												body {
																font-family: 'Helvetica Neue', Arial, sans-serif;
																line-height: 1.6;
																color: #333333;
																max-width: 600px;
																margin: 0 auto;
																padding: 20px;
																background-color: #f5f5f5;
												}

												.email-container {
																background-color: #ffffff;
																border-radius: 8px;
																padding: 30px;
																box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
												}

												.header {
																text-align: center;
																margin-bottom: 30px;
												}

												.logo {
																max-width: 150px;
																height: auto;
																margin: 0 auto 20px;
																display: block;
												}

												.title {
																color: #2C3E50;
																font-size: 24px;
																margin-bottom: 20px;
												}

												.content {
																margin-bottom: 30px;
												}

												.user-info {
																background-color: #f8f9fa;
																padding: 15px;
																border-radius: 4px;
																margin-bottom: 20px;
												}

												.reset-button {
																text-align: center;
																margin: 30px 0;
												}

												.button {
																display: inline-block;
																padding: 12px 30px;
																background-color: #4A90E2;
																color: #ffffff !important;
																text-decoration: none;
																border-radius: 4px;
																font-weight: bold;
																transition: background-color 0.3s;
												}

												.button:hover {
																background-color: #357ABD;
												}

												.warning {
																font-size: 13px;
																color: #666;
																background-color: #fff8e1;
																padding: 10px;
																border-radius: 4px;
																border-left: 4px solid #ffc107;
												}

												.footer {
																text-align: center;
																margin-top: 30px;
																padding-top: 20px;
																border-top: 1px solid #eee;
																color: #666;
																font-size: 14px;
												}
								</style>
				</head>

				<body>
								<div class="email-container">
												<div class="header">
																<img src="{{ asset(config('custom.images.logo')) }}" alt="Company Logo" class="logo">
												</div>

												<h1 class="title">Xác nhận đặt lại mật khẩu</h1>

												<div class="content">
																<p>Xin chào <strong>{{ $admin->fullname }}</strong>,</p>

																<div class="user-info">
																				<p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn:</p>
																				<p><strong>Email:</strong> {{ $admin->email }}</p>
																</div>

																<p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này. Ngược lại, bạn có thể đặt lại mật
																				khẩu của mình bằng cách nhấp vào nút bên dưới:</p>
												</div>

												<div class="reset-button">
																<a href="{{ $url }}" class="button">Đặt lại mật khẩu</a>
												</div>

												<div class="warning">
																<p><strong>Lưu ý:</strong> Link đặt lại mật khẩu này sẽ hết hạn trong vòng 30 phút. Vì lý do bảo mật,
																				vui lòng không chia sẻ email này với bất kỳ ai.</p>
												</div>

												<div class="footer">
																<p>Email này được gửi tự động, vui lòng không trả lời.</p>
																<p>© 2024 Mevivu. Tất cả các quyền được bảo lưu.</p>
												</div>
								</div>
				</body>

</html>
