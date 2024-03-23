function passwords() {
    console.log("dhdsajlfkad");
    var id1 = document.getElementById("submit-btn");
    var id2 = document.getElementById("update-btn");
    id2.style.display = "none";
    id1.style.display = "inline-block";
    var id3 = document.getElementById("new-pass-div");
    id3.style.display = "block";
    var id4 = document.getElementById("change-btn");
    id4.style.display = "none";
    displaySubmit();
}


function displaySubmit() {
    console.log("hejr");
    var id1 = document.getElementById("submit-btn");
    const inputs = document.querySelectorAll('input');

        inputs.forEach(function(input) {
        input.removeAttribute('disabled');
    });
  
    var id3 = document.querySelectorAll('img');
    id3.forEach(img => {
        img.style.display = "none";
    });

    id1.style.display = "inline-block";
    id1.disabled = false;
    var id2 = document.getElementById("update-btn");
    id2.style.display = "none";
    var textarea = document.getElementById("myTextarea");
    textarea.disabled = false;
    displayFileInput();
}


function displayFileInput() {
    // Create a new file input element
    var fileInput = document.createElement('input');
    fileInput.setAttribute('type', 'file');
    fileInput.setAttribute('name', 'imageName');
    fileInput.setAttribute('class', 'upload');

    // Replace the img tag with the file input
    var imgDiv = document.getElementById('img-div');
    imgDiv.innerHTML = '';
    imgDiv.appendChild(fileInput);
}