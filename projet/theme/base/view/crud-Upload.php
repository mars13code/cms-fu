<?php
// https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
// https://davidwalsh.name/fetch
// https://developer.mozilla.org/en-US/docs/Web/API/File/Using_files_from_web_applications
?>
<section class="crud-upload-create">
    <h3>UPLOAD</h3>
    <style>
#drop-area {
  border: 2px dashed #ccc;
  border-radius: 20px;
  width: 480px;
  font-family: sans-serif;
  margin: 1rem auto;
  padding: 20px;
}
#drop-area.highlight {
  border-color: purple;
}
p {
  margin-top: 0;
}
.my-form {
  margin-bottom: 10px;
}
#gallery {
  margin-top: 10px;
}
#gallery img {
  width: 160px;
  height:160px;
  object-fit:cover;
  margin-bottom: 10px;
  margin-right: 10px;
}
.button {
  display: inline-block;
  padding: 10px;
  background: #ccc;
  cursor: pointer;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.button:hover {
  background: #ddd;
}
#fileElem {
  display: none;
}
    </style>
    <div id="drop-area">
        <form class="my-form">
            <p>Transférez des fichiers en cliquant sur le bouton ou bien en glisser-déposer</p>
            <input type="file" id="fileElem" multiple accept="image/*">
            <label class="button" for="fileElem">Select some files</label>
            <div class="feedbackAjax"></div>
            <div class="feedback"></div>
        </form>
        <div id="gallery"></div>
    </div>
    <script>
let feedbackAjax    = document.querySelector('.feedbackAjax');
let dropArea        = document.getElementById('drop-area');
var inputElement    = document.querySelector("#fileElem");
inputElement.addEventListener("change", handleFiles0, false);
function handleFiles0() {
    var fileList = this.files; /* now you can work with the file list */
    handleFiles(fileList);
}

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false)
})

function preventDefaults (e) {
    e.preventDefault()
    e.stopPropagation()
}

;['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false)
})

;['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false)
})

function highlight(e) {
    dropArea.classList.add('highlight')
}

function unhighlight(e) {
    dropArea.classList.remove('highlight')
}

dropArea.addEventListener('drop', handleDrop, false)

function handleDrop(e) {
    let dt = e.dataTransfer
    let files = dt.files
    
    handleFiles(files)
}

function previewFile(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function() {
        let img = document.createElement('img');
        img.src = reader.result;
        document.getElementById('gallery').appendChild(img);
    }
}

function handleFiles(files) {
    console.log(files);
    files = [...files];
    files.forEach(uploadFile);
    files.forEach(previewFile);
}

function uploadFile(file) {
    let url = 'ajax';
    let formData = new FormData();
    
    formData.append('--formGoal', 'Upload.ajax');
    formData.append('uploadFile', file);
    
    fetch(url, {
        mode: 'same-origin',
        credentials: 'same-origin',
        method: 'POST',
        body: formData
    })
    .then(response => { return response.text() })
    .then(responseText => {
        let feedbackUpload = document.createElement('div');
        feedbackUpload.innerHTML = responseText;
        feedbackAjax.appendChild(feedbackUpload);
    })
    .catch(() => { feedbackAjax.innerHTML += '<div>UPLOAD ERROR</div>' })
}


    </script>

    <div class="list-mini">
<?php
$idUser = lireSession("id");

$tabResult = trouverLigne("Page", "dataType", "upload", "AND idUser = $idUser ORDER BY date DESC");
foreach($tabResult as $tabLigne)
{
    extract($tabLigne);
    
    $extension = pathinfo($urlPage, PATHINFO_EXTENSION);
    if (in_array($extension, [ "jpg", "jpeg", "gif", "png" ])) {
    echo
<<<CODEHTML
    <a href="#"><img src="assets/upload/100x100-$urlPage"></a>
CODEHTML;
        
    }

}

?>
    </div>
    
</section>
