<!DOCTYPE html>
<html lang="en">

				<head>
								<meta charset="UTF-8" />
								<meta name="viewport" content="width=device-width, initial-scale=1.0" />
								<meta http-equiv="X-UA-Compatible" content="ie=edge" />
								<title>Xác thực tài khoản</title>
				</head>

				<body
								style="
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        ">
								<div
												style="
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
            ">
												<h1 style="color: #333333; text-align: center">
																Xác thực tài khoản
												</h1>
												<p style="color: #555555">Xin chào {{ $fullname }},</p>
												<p style="color: #555555">
																Chúc mừng bạn đã đăng ký tài khoản tại chúng tôi.
												</p>
												<p style="color: #555555">Địa chỉ email: {{ $email }}</p>
												<p style="color: #555555">
																Để kích hoạt tài khoản, vui lòng nhập mã xác thực sau:
												</p>
												<div
																style="
                    background-color: #e9ecef;
                    padding: 20px;
                    text-align: center;
                    border-radius: 5px;
                ">
																<span style="font-size: 30px; font-weight: bold; color: #28a745">{{ $token_active_account }}</span>
												</div>
												<p style="color: #555555; margin-top: 20px">Cảm ơn bạn!</p>
								</div>
				</body>

</html>
