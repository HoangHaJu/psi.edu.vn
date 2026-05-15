<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận xét buổi học</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f8ff;
            /* Màu nền nhạt */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .letter-container {
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            padding: 40px;
            border-radius: 10px;
            position: relative;
            /* Hình nền kẻ dòng */
            background-image: linear-gradient(to bottom, transparent 0%, transparent 24px, #eee 25px, #eee 25.5px, transparent 25.5px, transparent 50px);
            background-size: 100% 50px;
            background-repeat: repeat;
        }

        .letter-header h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-family: 'Caveat', cursive;
            /* Sử dụng font viết tay */
            font-size: 2.5em;
        }

        .letter-body {
            font-family: 'Caveat', cursive;
            /* Sử dụng font viết tay */
            font-size: 1.2em;
            line-height: 1.7;
            color: #333;
        }

        .letter-body p {
            margin-bottom: 20px;
        }

        .salutation {
            margin-bottom: 30px;
            font-style: normal;
            /* Loại bỏ italic nếu không cần */
        }

        .closing {
            text-align: right;
            margin-top: 40px;
        }

        .signature {
            text-align: right;
            font-weight: bold;
        }

        /* Họa tiết trang trí */
        .letter-container::before,
        .letter-container::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 30px;
            /* Điều chỉnh chiều cao họa tiết */
            background-image: url('floral-border.png');
            /* Thay thế bằng đường dẫn ảnh của bạn */
            background-repeat: repeat-x;
            background-size: contain;
            /* Đảm bảo toàn bộ họa tiết hiển thị */
        }

        .letter-container::before {
            top: 10px;
            left: 0;
        }

        .letter-container::after {
            bottom: 10px;
            left: 0;
        }
    </style>
</head>

<body>
    <div class="letter-container">
        <div class="letter-header">
            <h1>Lesson review</h1>
        </div>
        <div class="letter-body">
            <p class="salutation">Dear friend {{ $student->student->fullname }}</p>
            <p>{{ $review['teacher_review'] }}</p>
            <p class="closing">Your Teacher,</p>
            <p class="signature">{{ $student->teacher_lesson->teacher->fullname }}</p>
        </div>
    </div>
</body>

</html>
