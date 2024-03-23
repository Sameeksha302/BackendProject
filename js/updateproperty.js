function displayImg(event) {
    var image = document.getElementById('property-img');
    image.src = URL.createObjectURL(event.target.files[0]);
}