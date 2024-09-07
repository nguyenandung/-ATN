<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #666666;
        }

        .products {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        .products th,
        .products td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .thank-you {
            margin-top: 20px;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Thông báo đặt hàng</h1>
        <p>Cảm ơn bạn đã đặt hàng tại cửa hàng chúng tôi. Dưới đây là thông tin chi tiết về đơn hàng của bạn:</p>
        <div class="recipient-info">
            <p><strong>Thông tin người nhận: </strong></p>
            <p>Tên: {{ $order->customerName }}</p>
            <p>Địa chỉ: {{ $order->address }}</p>
            <p>Số điện thoại: {{ $order->phone }}</p>
        </div>
        <table class="products">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Loại</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                {{$cart}}
            </tbody>
        </table>

        <div class="thank-you">
            <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>
        </div>
    </div>
</body>

</html>
