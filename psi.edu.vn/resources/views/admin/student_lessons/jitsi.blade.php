<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://8x8.vc/vpaas-magic-cookie-beaaf0bf82584c61aa5702e80e96cf8d/external_api.js" async></script>
    <style>
        html,
        body,
        #jaas-container {
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="jaas-container"></div>

    <script type="text/javascript">
        window.onload = () => {
            const domain = "8x8.vc";
            const options = {
                roomName: "vpaas-magic-cookie-beaaf0bf82584c61aa5702e80e96cf8d/{{ $room }}",
                parentNode: document.querySelector('#jaas-container'),
            };
            new JitsiMeetExternalAPI(domain, options);
        }
    </script>
</body>

</html>
