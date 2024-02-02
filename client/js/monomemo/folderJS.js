jQuery(function () {
    const params = new URLSearchParams(window.location.search);
    if (!params.has("folder_uuid")) {
        window.location.href = "/client/pages/monomemo/home.php";
    }
    const folderUUID = params.get("folder_uuid");

    getFiles(folderUUID)
})

function getFiles(folderUUID) {
    $.ajax({
        type : "GET",
        url : `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
        data : {type : "single_folder"},
        dataType : "json",
        success : function (response) {
            const mappedFiles = response.map((fileData, index) => {
                return fileData.type === "note" ? 
                `<a class="note-card-container" 
                    href="/client/pages/monomemo/note.php?note_uuid=${fileData.uuid}">
                    <p class="note-card-title">${fileData.title ? fileData.title : ""}</p>
                    <p class="note-card-content">
                    ${fileData.content ? fileData.content : "No Content"}
                    </p>
                </a>` 
            : 
                `<a class="folder-card-container" 
                    href="/client/pages/monomemo/folder.php?folder_uuid=${fileData.uuid}" >
                    <p class="folder-card-title">${fileData.title ? fileData.title : ""}</p>
                </a>` 
            })
            $(".file-container").html(mappedFiles);
        },
        error : function (response) {
            console.log(response);    
        },
    })
}