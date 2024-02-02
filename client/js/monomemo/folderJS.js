jQuery(function () {
    const params = new URLSearchParams(window.location.search);
    if (!params.has("folder_uuid")) {
        window.location.href = "/client/pages/monomemo/home.php";
    }
    const folderUUID = params.get("folder_uuid");

    $(".folder-data-container").on("input", "#single-folder-name", function(e) {
        setTimeout(() => {
            const folderTitle = $("#single-folder-name").val();
            updateFolder(folderUUID, folderTitle)
        }, [400])
    })

    getFiles(folderUUID)
})

function getFiles(folderUUID) {
    $.ajax({
        type : "GET",
        url : `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
        data : {type : "single_folder"},
        dataType : "json",
        success : function (response) {
            const {files, folder_data} = response
            const mappedFiles = files.map((fileData, index) => {
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
            });

            const folderData = `
            <a href=${folder_data.folder_from ? `/client/pages/monomemo/folder.php?folder_uuid=${folder_data.folder_uuid}` : "/client/pages/monomemo/folder.php"} >
                <i class="fa-solid fa-arrow-left"></i>
            </a> 
            <textarea id="single-folder-name" placeholder="No Title">${folder_data.folder_name}</textarea>`;

            $(".folder-data-container").html(folderData);
            $(".file-container").html(mappedFiles);

        },
        error : function (response) {
            console.log(response);    
        },
    })
}

function updateFolder(folderUUID, folderTitle) {
    $.ajax({
        type : "POST",
        url : `/server/routers/monomemo/folder.route.php?folder_uuid=${folderUUID}`,
        data : {type : "update_folder", folderTitle},
        dataType : "json",
        success : function (response) {
            console.log(response);
        }
    })
}