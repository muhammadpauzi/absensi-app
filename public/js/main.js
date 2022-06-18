import toast from "./toast.js";

// handle livewire event
window.addEventListener("showToast", (event) => {
    let data = {
        title: "Informasi",
        body: event.detail.message,
        colorClass: toast.TOAST_DANGER, // default
    };
    if (event.detail.success) data["colorClass"] = toast.TOAST_SUCCESS;
    toast.show(data);
});
