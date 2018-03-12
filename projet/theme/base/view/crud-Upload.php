<?php
// https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
// https://davidwalsh.name/fetch

?>
<section>
    <h3>UPLOAD</h3>
    <style>
#drop-area {
  border: 2px dashed #ccc;
  border-radius: 20px;
  width: 480px;
  font-family: sans-serif;
  margin: 100px auto;
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
  width: 150px;
  margin-bottom: 10px;
  margin-right: 10px;
  vertical-align: middle;
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
            <p>Upload multiple files with the file dialog or by dragging and dropping images onto the dashed region</p>
            <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
            <label class="button" for="fileElem">Select some files</label>
            <div class="feedbackAjax"></div>
            <div class="feedback"></div>
        </form>
    </div>
    <script>
let feedbackAjax = document.querySelector('.feedbackAjax');

let dropArea = document.getElementById('drop-area');
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

function handleFiles(files) {
  ([...files]).forEach(uploadFile)
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
  .then(responseText => { feedbackAjax.innerHTML = responseText })
  .catch(() => { feedbackAjax.innerHTML += '<div>UPLOAD ERROR</div>' })
}

    </script>
</section>
