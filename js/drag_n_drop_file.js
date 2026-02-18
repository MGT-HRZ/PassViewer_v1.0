let filesToUpload = [];

// Prevent the default behavior when dragging over the area
function handleDragOver(event) {
    event.preventDefault();  // Necessary to allow file drop
    event.stopPropagation(); // Prevent other default behaviors
    document.getElementById("file-drop-area").classList.add("dragover");
    console.log("File is being dragged over");
}

// Remove the visual feedback when the drag leaves the drop area
function handleDragLeave(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById("file-drop-area").classList.remove("dragover");
    console.log("Drag leave");
}

// Handle dropped files
function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById("file-drop-area").classList.remove("dragover");

    const files = event.dataTransfer.files;
    console.log("Files dropped:", files);
    handleFileSelection(files);
}

// Handle file selection via file input

function handleFileSelect(event) {
    const files = event.target.files;
    console.log("Files selected via input:", files);
    handleFileSelection(files);
}

// Handle both dropped and selected files
// function handleFileSelection(files) {
//     for (let file of files) {
//         if (file.type === "application/pdf") {
//             filesToUpload.push(file);
//             const fileListElement = document.getElementById("file-list");
//             const listItem = document.createElement("li");
//             listItem.textContent = file.name;
//             fileListElement.appendChild(listItem);
//         } else {
//             alert("Only PDF files are allowed.");
//         }
//     }
// }

function handleFileSelection(files) {
    const fileListElement = document.getElementById("file-list");

    for (let file of files) {
        if (file.type === "application/pdf") {
            if (file.name === "Codes.pdf") {
                // Check if the file is already in the filesToUpload array by name
                if (!filesToUpload.some(existingFile => existingFile.name === file.name)) {
                    filesToUpload.push(file);
                    const listItem = document.createElement("li");
                    listItem.textContent = file.name;
                    fileListElement.appendChild(listItem);
                }
            } else {
                alert("PDF file name not expected!");
            }
        } else {
            alert("Only PDF files are allowed!");
        }
    }
}

// When the user clicks submit, prepare files for upload
document.getElementById("upload-form").addEventListener("submit", function(event) {
    event.preventDefault();

    if (filesToUpload.length === 0) {
        alert("Please select or drop PDF files before submitting.");
        return;
    }

    // Create a new FormData object
    const formData = new FormData();

    // Append files to FormData
    for (let i = 0; i < filesToUpload.length; i++) {
        formData.append("files[]", filesToUpload[i]);
    }

    // Use fetch API to submit the form data via POST
    fetch("upload-priority-db.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Upload successful:", data);
        alert("Files uploaded successfully.");
    })
    .catch(error => {
        console.error("Error uploading files:", error);
        alert("Error uploading files.");
    });
});

// Add event listeners for drag and drop
const dropArea = document.getElementById("file-drop-area");
dropArea.addEventListener("dragover", handleDragOver);
dropArea.addEventListener("dragleave", handleDragLeave);
dropArea.addEventListener("drop", handleDrop);

const fileSub = document.getElementById("file-submit");

fileSub.addEventListener("click", function () {
    const fileListElement = document.getElementById("file-list");
   
    // Clear the file list
    fileListElement.innerHTML = '';
    
    // Optionally, also clear the filesToUpload array
    setTimeout(() => {
        filesToUpload = [];
    }, 3000);
});

const fileRst = document.getElementById("file-reset");

fileRst.addEventListener("click", function () {
    const fileListElement = document.getElementById("file-list");
   
    // Clear the file list
    fileListElement.innerHTML = '';
    
    // Optionally, also clear the filesToUpload array
    filesToUpload = [];
});
