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

window.addEventListener("redirect", (event) => {
    window.location.assign(event.detail.url);
});

window.addEventListener("livewire-scroll", (event) => {
    window.scrollTo({
        top: event.detail.top,
        behavior: "smooth",
    });
});
