const toastContainer = document.getElementById("toast-container");

const TOAST_LIGHT = "";
const TOAST_SUCCESS = "text-bg-success";
const TOAST_DANGER = "text-bg-danger";

const toastComponent = ({ title, body, colorClass = TOAST_LIGHT }) => {
    const toastClass = "toast mb-2 " + colorClass;
    return `<div class="${toastClass}" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">${title}</strong>
            <small class="text-muted">Baru saja</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            ${body}
        </div>
    </div>`;
};

const push = (toastComponentHTML = "", { duration }) => {
    const parentForDuration = document.createElement("div");
    parentForDuration.innerHTML = toastComponentHTML;
    const toastBootstrap = new bootstrap.Toast(
        parentForDuration.firstElementChild,
        {
            delay: duration,
        }
    );
    toastBootstrap.show();
    toastContainer.appendChild(parentForDuration);
};

const show = ({ title, body, duration = 3000, colorClass }) => {
    try {
        const toastComponentHTML = toastComponent({ title, body, colorClass });
        push(toastComponentHTML, { duration });
    } catch (error) {
        console.error("toast error");
    }
};

export default {
    show,
    TOAST_DANGER,
    TOAST_SUCCESS,
};
