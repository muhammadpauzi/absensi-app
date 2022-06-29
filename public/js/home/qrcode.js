import toast from "../toast.js";
import { fetchWithToken, toFormurlenconded } from "../utils.js";

const QRCodeScannerModal = document.getElementById("qrcode-scanner-modal");

QRCodeScannerModal.addEventListener("show.bs.modal", async (event) => {
    const isEnter = event.relatedTarget.dataset.isEnter == "1";

    function onScanSuccess(code) {
        handlePresence(isEnter ? enterPresenceUrl : outPresenceUrl, code);
        html5QrcodeScanner.clear();
        window.location.reload();
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            rememberLastUsedCamera: false,
        },
        /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess);
});

async function handlePresence(baseurl, code) {
    const res = await fetchWithToken(baseurl, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: toFormurlenconded({ code }),
    });
    const data = res.json();

    let dataToast = {
        title: "QRCode Absensi Pesan",
        body: data.message,
        colorClass: toast.TOAST_SUCCESS, // default
    };
    if (data.success) dataToast["colorClass"] = toast.TOAST_SUCCESS;
    toast.show(dataToast);
}
