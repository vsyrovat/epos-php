<html lang="en">
<head><title>Add Products</title></head>
<body>
<p><button id="push-json-js" onclick="pushProducts()">Push Products JSON</button></p>
<script>
function pushProducts() {
    let xhr = new XMLHttpRequest();
    let url = '/add-product';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 201) {
                alert('Sent successfully');
            } else {
                alert('Some error happens (' + xhr.status + ')');
            }
        }
    };
    let data = JSON.stringify(
        {
            "products": [
                {"title": "foo", "price": "99.99"},
                {"title": "bar", "price": "88.88"}]
        });
    xhr.send(data);
}
</script>
</body>
</html>
