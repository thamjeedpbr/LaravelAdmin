<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }
        .certificate-container {
            position: relative;
            width: 1000px; /* Adjust to your image width */
            height: 700px; /* Adjust to your image height */
            background-image: url('{{ asset('course/certificate/annoor-golden.jpg') }}');
            background-size: cover;
            background-position: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .certificate-content {
            position: absolute;
            width: 80%;
            top: 35%; /* Adjust this value to fit vertically */
            left: 10%;
            text-align: center;
            color: #000000;
            font-size: 24px;
            line-height: 1.5;
        }
        .certificate-content p {
            margin: 10px 0;
        }
        .certificate-footer {
            position: absolute;
            bottom: 170px; /* Adjust this value to move the footer up */
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 10%;
            font-size: 18px;
            color: #000000;
        }
        .certificate-footer .date {
            position: absolute;
            left: 13%; /* Adjust this value to place it correctly */
        }
        .certificate-footer .number {
            position: absolute;
            right: 32%; /* Adjust this value to place it correctly */
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-content">
            <p><strong>Mr/Ms {{ $name }}</strong> with Roll No: <strong>{{ $roll_no }}</strong></p>
            <p>has Successfully completed the Peace Radio <strong>{{ $course_type }}</strong></p>
            <p><strong>{{ $course_name }}</strong> with an aggregate of <strong>{{ $marks }}% marks</strong></p>
        </div>
        <div class="certificate-footer">
            <div class="date">
                <p>Date: <strong>{{ $date }}</strong></p>
            </div>
            <div class="number">
                <p>Certificate No: <strong>{{ $certificate_number }}</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
