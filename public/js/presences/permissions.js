// const permissionDetailModal = new bootstrap.Modal("#permission-detail-modal");
const permissionDetailModal = document.getElementById(
    "permission-detail-modal"
);

// const permissionDetailModalTriggers = document.querySelectorAll(
//     ".permission-detail-modal-triggers"
// );

// permissionDetailModalTriggers.forEach((el) => {
//     el.addEventListener("click");
// });

permissionDetailModal.addEventListener("show.bs.modal", async (event) => {
    const badgeTrigger = event.relatedTarget;
    const { permissionId } = badgeTrigger.dataset;
    const res = await fetch(permissionUrl + "?id=" + permissionId);
    const data = await res.json();
    const permissionTitleModal =
        permissionDetailModal.querySelector("#permission-title");
    const permissionDescriptionModal = permissionDetailModal.querySelector(
        "#permission-description"
    );
    permissionTitleModal.textContent = data.title;
    permissionDescriptionModal.textContent = data.description;
});
